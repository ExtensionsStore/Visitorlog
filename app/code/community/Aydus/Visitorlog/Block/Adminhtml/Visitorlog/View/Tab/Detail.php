<?php

/**
 * Visitorlog details tab
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus <davidt@aydus.com>
 */

class Aydus_Visitorlog_Block_Adminhtml_Visitorlog_View_Tab_Detail 
	extends Mage_Adminhtml_Block_Template
	implements Mage_Adminhtml_Block_Widget_Tab_Interface 
{
	public function getVisitor()
	{
		return Mage::registry('current_visitor');
	}
	
	public function getStore()
	{
		$visitor = $this->getVisitor();
		$store = Mage::getModel('core/store')->load($visitor->getStoreId());
		
		return $store;
	}
	
	public function getRecord()
	{
		$visitor = $this->getVisitor();
		$ip = long2ip($visitor->getRemoteAddr());
		
		$record = $this->helper('aydus_visitorlog/geoip')->getRecord($ip);
		
		return $record;
	}
	
	public function getTabLabel()
	{
		return $this->helper('aydus_visitorlog')->__('Details');
	}
	
	public function getTabTitle()
	{
		return $this->helper('aydus_visitorlog')->__('Visitor Info');
	}
	
	public function canShowTab()
	{
		if (Mage::registry('current_visitor')->getId()) {
			return true;
		}
		
		return false;
	}
	
	public function isHidden()
	{
		if (Mage::registry('current_visitor')->getId()) {
			
			return false;
		}
		
		return true;
	}
}
