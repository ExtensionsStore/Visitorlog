<?php

/**
 * Visitor log controller
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus <davidt@aydus.com>
 */
class Aydus_Visitorlog_Adminhtml_VisitorlogController extends Mage_Adminhtml_Controller_Action {

    /**
     * Init selected visitor
     * 
     * @param string $idFieldName
     * @return Aydus_Visitorlog_Adminhtml_VisitorlogController
     */
    protected function _initVisitor($idFieldName = 'id') {
        $this->_title($this->__('Visitor Info'))->_title($this->__('Visitor Log'));
        $visitorId = (int) $this->getRequest()->getParam($idFieldName);

        $visitor = Mage::getModel('log/visitor');

        if ($visitorId) {
            $visitor->load($visitorId);
        }

        Mage::register('current_visitor', $visitor);
        return $this;
    }

    /**
     * Display grid of visitors log
     */
    public function indexAction() {
        $this->_title($this->__('Visitors'))->_title($this->__('Visitor Log'));
        $this->loadLayout()->renderLayout();
    }

    /**
     * Ajax grid of visitors log
     */
    public function gridAction() {
        $this->loadLayout()->renderLayout();
    }

    /**
     * Display visitor info
     */
    public function viewAction() {
        $this->_initVisitor();
        $this->loadLayout()->renderLayout();
    }

    /**
     * Display visitors urls
     */
    public function urlsAction() {
        $this->_initVisitor();
        $this->loadLayout()->renderLayout();
    }

    /**
     * export as csv - action
     * 
     * @return void
     */
    public function exportCsvAction() {
        $fileName = 'visitorlog.csv';
        $content = $this->getLayout()->createBlock('aydus_visitorlog/adminhtml_visitorlog_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     * 
     * @return void
     */
    public function exportExcelAction() {
        $fileName = 'visitorlog.xls';
        $content = $this->getLayout()->createBlock('aydus_visitorlog/adminhtml_visitorlog_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     * 
     * @return void
     */
    public function exportXmlAction() {
        $fileName = 'visitorlog.xml';
        $content = $this->getLayout()->createBlock('aydus_visitorlog/adminhtml_visitorlog_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

}
