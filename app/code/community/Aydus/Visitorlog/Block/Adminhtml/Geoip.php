<?php

/**
 * Adminhtml geoip grid container
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus <davidt@aydus.com>
 */

class Aydus_Visitorlog_Block_Adminhtml_Geoip extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
    	$this->_blockGroup = 'aydus_visitorlog';
        $this->_controller = 'adminhtml_geoip';
        $this->_headerText = Mage::helper('aydus_visitorlog')->__('Search GeoIP Database');
        parent::__construct();
        $this->setTemplate('report/grid/container.phtml');
        $this->_removeButton('add');
        $this->addButton('filter_form_submit', array(
            'label'     => Mage::helper('aydus_visitorlog')->__('Search'),
            'onclick'   => 'filterFormSubmit()'
        ));
    }

    public function getFilterUrl()
    {
        $this->getRequest()->setParam('filter', null);
        return $this->getUrl('*/*/index', array('_current' => true));
    }
}
