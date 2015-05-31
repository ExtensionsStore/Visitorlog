<?php 

/**
 * Cron test
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus <davidt@aydus.com>
 */

class Aydus_Visitorlog_Test_Model_Cron extends EcomDev_PHPUnit_Test_Case_Config 
{	
    /**
     * 
     * @test 
     * @loadFixture 
     */
    public function logBackup()
    {
        echo "\nAydus_Visitorlog model test started.";
        
        $schedule = Mage::getModel('cron/schedule');
        
        $cron = new Aydus_Visitorlog_Model_Cron();
        $cron->logBackup($schedule);
        
        $dateDir = date('Y-m-d');
        $archiveFile = Mage::getBaseDir('var') . DS . 'log' . DS . 'visitorlog'. DS. $dateDir . '.tar.gz';

        $fileExists = file_exists($archiveFile);

        $this->assertTrue($fileExists);
        
        echo "\nAydus_Visitorlog model test completed.";
    }
	
}