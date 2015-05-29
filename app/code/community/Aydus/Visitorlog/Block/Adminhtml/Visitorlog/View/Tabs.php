<?php

/**
 * Visitorlog admin view tabs
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus <davidt@aydus.com>
 */
class Aydus_Visitorlog_Block_Adminhtml_Visitorlog_View_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    /**
     * Initialize Tabs
     */
    public function __construct() {
        parent::__construct();
        $this->setId('visitorlog_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('log')->__('Visitor Info'));
    }

    /**
     * before render html
     * 
     * @return Aydus_Visitorlog_Block_Adminhtml_Visitorlog_View_Tabs
     */
    protected function _beforeToHtml() {
        $this->addTab('tab_url', array(
            'label' => Mage::helper('log')->__('Urls'),
            'title' => Mage::helper('log')->__('Urls'),
            'url' => $this->getUrl('*/*/urls', array('_current' => true)),
            'class' => 'ajax'
        ));

        return parent::_beforeToHtml();
    }

    /**
     * Retrieve visitor entity
     * 
     * @return Mage_Log_Model_Visitor
     */
    public function getVisitor() {
        return Mage::registry('current_visitor');
    }

}
