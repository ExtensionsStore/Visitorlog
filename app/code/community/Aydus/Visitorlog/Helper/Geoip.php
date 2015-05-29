<?php

/**
 * Visitorlog GeoIP helper
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus <davidt@aydus.com>
 */
class Aydus_Visitorlog_Helper_Geoip extends Mage_Core_Helper_Abstract {

    protected $_geoip;

    public function __construct() {
        try {

            $dir = __DIR__;
            chdir($dir . DS . '..');

            $libPath = Mage::getBaseDir() . DS . 'lib' . DS . 'Aydus' . DS . 'geoipcity.inc';

            if (file_exists($libPath)) {
                include_once($libPath);
            } else {
                //include geoip scripts
                include_once('lib' . DS . 'geoipcity.inc');
            }

            //include geoip database
            if (file_exists(Mage::getBaseDir('var') . DS . 'aydus' . DS . 'GeoIPCity.dat')) {

                $path = Mage::getBaseDir('var') . DS . 'aydus' . DS . 'GeoIPCity.dat';
            } else {

                $path = 'lib' . DS . 'GeoLiteCity.dat';
            }

            //open database file
            $this->_geoip = geoip_open($path, GEOIP_STANDARD);
            chdir(Mage::getBaseDir());
        } catch (Exception $e) {

            Mage::log($e->getMessage(), null, 'aydus_visitorlog.log');
        }
    }

    public function getRecord($ip) {
        try {

            $record = geoip_record_by_addr($this->_geoip, $ip);
        } catch (Exception $e) {

            Mage::log($e->getMessage(), null, 'aydus_visitorlog.log');
        }

        return $record;
    }

}
