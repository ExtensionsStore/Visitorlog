<?php

/**
 * Visitorlog Geoip controller
 *
 * @category   Aydus
 * @package	   Aydus_Visitorlog
 * @author     Aydus Consulting <davidt@aydus.com>
 */

class Aydus_Visitorlog_Adminhtml_GeoipController extends Mage_Adminhtml_Controller_Report_Abstract
{
	public function indexAction()
	{
		$this->_title($this->__('Visitor Info'))->_title($this->__('Geo IP Lookup'));
		
		//$this->_showLastExecutionTime(Mage_Reports_Model_Flag::REPORT_SHIPPING_FLAG_CODE, 'shipping');
		
		$this->_initAction()
		->_setActiveMenu('report/visitorlog/geoip')
		->_addBreadcrumb(Mage::helper('aydus_visitorlog')->__('Visitor Log'), Mage::helper('aydus_visitorlog')->__('Geo IP Lookup'));
		
		$gridBlock = $this->getLayout()->getBlock('adminhtml_geoip.grid');
		$filterFormBlock = $this->getLayout()->getBlock('grid.filter.form');
		
		$this->_initReportAction(array(
				$gridBlock,
				$filterFormBlock
		));
		
		$this->renderLayout();		
	}
	    
    /**
     * export as csv - action
     * 
     * @todo coming soon
     * @return void
     */
    public function exportCsvAction()
    {
    	$fileName   = 'geoip.csv';
    	$content    = $this->getLayout()->createBlock('aydus_visitorlog/adminhtml_geoip_grid')->getCsv();
    	$this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * 
     * @todo coming soon
     * @return void
     */
    public function exportExcelAction()
    {
    	$fileName   = 'geoip.xls';
    	$content    = $this->getLayout()->createBlock('aydus_visitorlog/adminhtml_geoip_grid')->getExcelFile();
    	$this->_prepareDownloadResponse($fileName, $content);
    }
    
    /**
     * export as xml - action
     * 
     * @todo coming soon
     * @return void
     */
    public function exportXmlAction()
    {
    	$fileName   = 'geoip.xml';
    	$content    = $this->getLayout()->createBlock('aydus_visitorlog/adminhtml_geoip_grid')->getXml();
    	$this->_prepareDownloadResponse($fileName, $content);
    }

}
