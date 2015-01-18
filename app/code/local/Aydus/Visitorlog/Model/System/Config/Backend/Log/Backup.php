<?php

/**
 * Backup logs cron backend model
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus Consulting <davidt@aydus.com>
 */

class Aydus_Visitorlog_Model_System_Config_Backend_Log_Backup extends Mage_Core_Model_Config_Data
{
    const CRON_STRING_PATH  = 'crontab/jobs/log_backup/schedule/cron_expr';

    /**
     * Cron settings after save
     *
     * @return Mage_Adminhtml_Model_System_Config_Backend_Log_Cron
     */
    protected function _afterSave()
    {
        $enabled    = $this->getData('groups/log/fields/enabled/value');
        $time       = $this->getData('groups/log/fields/time/value');
        $frequncy   = $this->getData('groups/log/fields/frequency/value');
        $errorEmail = $this->getData('groups/log/fields/error_email/value');
        $backup     = $this->getData('groups/log/fields/backup/value');
        $before     = $this->getData('groups/log/fields/backup_before/value');
        
        if (intval($time[0]) == 0){
        	$hour = 24 - $before;
            $time[0] = $hour;
        } else {
            $time[0] = intval($time[0]) - 1;
        }        
        
        $frequencyDaily     = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_DAILY;
        $frequencyWeekly    = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_WEEKLY;
        $frequencyMonthly   = Mage_Adminhtml_Model_System_Config_Source_Cron_Frequency::CRON_MONTHLY;

        if ($enabled && $backup) {
            $cronDayOfWeek = date('N');
            $cronExprArray = array(
                intval($time[1]),                                   # Minute
                intval($time[0]),                                   # Hour
                ($frequncy == $frequencyMonthly) ? '1' : '*',       # Day of the Month
                '*',                                                # Month of the Year
                ($frequncy == $frequencyWeekly) ? '1' : '*',        # Day of the Week
            );
            $cronExprString = join(' ', $cronExprArray);
        }
        else {
            $cronExprString = '';
        }

        try {
            Mage::getModel('core/config_data')
                ->load(self::CRON_STRING_PATH, 'path')
                ->setValue($cronExprString)
                ->setPath(self::CRON_STRING_PATH)
                ->save();
        }
        catch (Exception $e) {
            Mage::throwException(Mage::helper('adminhtml')->__('Unable to save the cron expression.'));
        }
    }
    
}
