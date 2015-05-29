<?php

/**
 * Visitorlog urls tab
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus <davidt@aydus.com>
 */
class Aydus_Visitorlog_Block_Adminhtml_Visitorlog_View_Tab_Url extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId('visitorlog_urls_grid');
        $this->setDefaultSort('visit_time', 'desc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection() {
        $prefix = Mage::getConfig()->getTablePrefix();

        $collection = Mage::getModel('log/visitor')->getCollection();
        $collection->addFieldToFilter('visitor_id', $this->getVisitor()->getId());
        $select = $collection->getSelect();
        $select->reset(Zend_Db_Select::COLUMNS);
        $select->join(
                array('u' => $prefix . 'log_url'), 'main_table.visitor_id = u.visitor_id', array('u.url_id', 'u.visit_time')
        );

        $select->join(
                array('i' => $prefix . 'log_url_info'), 'u.url_id = i.url_id', array('i.url', 'i.referer')
        );

        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    /**
     * prepare the grid columns
     * 
     * @return Preserve_Artisan_Block_Adminhtml_Artisan_Edit_Tab_Product
     */
    protected function _prepareColumns() {
        $this->addColumn('url_id', array(
            'header' => Mage::helper('aydus_visitorlog')->__('ID'),
            'align' => 'left',
            'index' => 'url_id',
        ));
        $this->addColumn('visit_time', array(
            'header' => Mage::helper('aydus_visitorlog')->__('Visit Time'),
            'align' => 'left',
            'index' => 'visit_time',
        ));
        $this->addColumn('url', array(
            'header' => Mage::helper('aydus_visitorlog')->__('Url'),
            'align' => 'left',
            'index' => 'url',
        ));
        $this->addColumn('referer', array(
            'header' => Mage::helper('aydus_visitorlog')->__('Referer'),
            'align' => 'left',
            'index' => 'referer',
        ));
    }

    /**
     * get row url
     * 
     * @return string
     */
    public function getRowUrl($item) {
        return '#';
    }

    /**
     * get grid url
     * 
     * @return string
     */
    public function getGridUrl() {
        return $this->getUrl('*/*/urls', array(
                    'id' => $this->getVisitor()->getId()
        ));
    }

    /**
     * get the current visitor
     * 
     * @return Mage_Log_Model_Visitor
     */
    public function getVisitor() {
        return Mage::registry('current_visitor');
    }

}
