<?php

/**
 * Visitorlog helper
 *
 * @category   Aydus
 * @package	   Aydus_Visitorlog
 * @author     Aydus Consulting <davidt@aydus.com>
 */

class Aydus_Visitorlog_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $_geoip;
	
	public function __construct()
	{
		$dir = __DIR__;
		chdir($dir.DS.'..');
		include('lib'.DS.'geoipcity.inc');
		$path = 'lib'.DS.'GeoLiteCity.dat';
		$this->_geoip = geoip_open($path, GEOIP_STANDARD);
		chdir(Mage::getBaseDir());
	}
	
	public function getRecord($ip)
	{
		try {
			
			$record = geoip_record_by_addr($this->_geoip, $ip);
				
		}catch (Exception $e){
			
			Mage::log($e->getMessage(),null,'aydus_visitorlog.log');
		}
		
		return $record;
	}
}