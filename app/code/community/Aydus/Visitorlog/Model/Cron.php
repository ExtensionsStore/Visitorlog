<?php

/**
 * Visitorlog cron
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus <davidt@aydus.com>
 */
class Aydus_Visitorlog_Model_Cron {

    protected $_resource;
    protected $_read;
    protected $_write;
    protected $_entities = array(
        'log/customer',
        'log/quote_table',
        'log/summary_table',
        'log/url_table',
        'log/url_info_table',
        'log/visitor',
        'log/visitor_info',
        'log/visitor_online',
    );

    /**
     * Backup Magento logs to archive files
     * 
     * @param Mage_Cron_Model_Schedule $schedule
     */
    public function logBackup($schedule) {
        if (!Mage::getStoreConfigFlag(Mage_Log_Model_Cron::XML_PATH_LOG_CLEAN_ENABLED) || !Mage::getStoreConfigFlag('system/log/backup')) {
            return $this;
        }

        $this->_resource = Mage::getSingleton('core/resource');
        $this->_read = $this->_resource->getConnection('core_read');
        $this->_write = $this->_resource->getConnection('core_write');

        $this->_duplicateTables();
        $this->_backupTables();

        $this->_archiveLogs();
    }

    /**
     * Duplicate tables to backup 
     * 
     */
    protected function _duplicateTables() {
        foreach ($this->_entities as $entity) {

            $tableName = $this->_resource->getTableName($entity);

            $this->_write->query("CREATE TABLE IF NOT EXISTS " . $tableName . "_tmp LIKE $tableName");
            $this->_write->query("INSERT IGNORE INTO " . $tableName . "_tmp SELECT * from $tableName");
        }
    }

    /**
     * Backup each table
     */
    protected function _backupTables() {
        foreach ($this->_entities as $entity) {

            $tableName = $this->_resource->getTableName($entity) . '_tmp';

            while (true) {

                $rows = $this->_read->fetchAll("SELECT * FROM $tableName LIMIT 100");

                if (count($rows) == 0) {
                    break;
                }

                $this->_backupRows($tableName, $rows);
                $this->_deleteRows($tableName, $rows);
            }
        }
    }

    /**
     *
     * Backup rows
     *
     * @param string $tableName
     * @param array $rows
     */
    protected function _backupRows($tableName, $rows) {
        if (is_array($rows) && count($rows) > 0) {

            $rowsAr = array();

            foreach ($rows as $row) {

                $row = array_map('addslashes', $row);

                $rowsAr[] = "'" . implode("','", $row) . "'";
            }

            $data = implode("\n", $rowsAr);

            $date = date('Y-m-d');
            $logArchiveDir = Mage::getBaseDir('var') . DS . 'log' . DS . 'visitorlog' . DS . $date;
            if (!is_dir($logArchiveDir)) {
                mkdir($logArchiveDir, 0777, true);
            }

            $filename = $logArchiveDir . DS . str_replace('_tmp', '', $tableName) . '.txt';
            file_put_contents($filename, $data);
        }
    }

    /**
     * Delete rows
     * 
     * @param string $tableName
     * @param array $rows
     */
    protected function _deleteRows($tableName, $rows) {
        if (is_array($rows) && count($rows) > 0) {

            $primary = $this->_read->fetchOne("SELECT k.COLUMN_NAME
		FROM information_schema.table_constraints t
		LEFT JOIN information_schema.key_column_usage k
		USING(constraint_name,table_schema,table_name)
		WHERE t.constraint_type='PRIMARY KEY'
		        AND t.table_schema=DATABASE()
		        AND t.table_name='$tableName';");

            foreach ($rows as $row) {

                $id = $row[$primary];

                $this->_write->query("DELETE FROM $tableName WHERE $primary = $id");
            }
        }
    }

    /**
     * Archive all logs
     */
    protected function _archiveLogs() {
        $dateDir = date('Y-m-d');
        $archiveDir = Mage::getBaseDir('var') . DS . 'log' . DS . 'visitorlog';
        chdir($archiveDir);
        $archiveFile = $dateDir . '.tar.gz';
        exec("tar czf $archiveFile $dateDir");
        exec("rm -rf $dateDir");
        chdir(Mage::getBaseDir());
    }

}
