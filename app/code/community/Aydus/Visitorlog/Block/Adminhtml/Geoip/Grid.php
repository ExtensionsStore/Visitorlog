<?php

/**
 * Adminhtml geoip grid block
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus <davidt@aydus.com>
 */
include("lib/GeoIP/geoipcity.inc");

class Aydus_Visitorlog_Block_Adminhtml_Geoip_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function getHeaderHtml() {
        return '<h3>' . Mage::helper('aydus_visitorlog')->__('Search GeoIP Database') . '</h3>';
    }

    protected function _prepareLayout() {
        parent::_prepareLayout();

        $this->unsetChild('export_button');
        $this->unsetChild('reset_filter_button');
        $this->unsetChild('search_button');
    }

    protected function _prepareCollection() {
        $filter = $this->getParam($this->getVarNameFilter(), null);

        if (is_string($filter)) {

            $collection = new Varien_Data_Collection;
            $data = $this->helper('adminhtml')->prepareFilterString($filter);

            if (is_array($data) && isset($data['ip_address'])) {

                $ipAddress = $data['ip_address'];

                if (preg_match('/^(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))\.(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))\.(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))\.(\d|[1-9]\d|1\d\d|2([0-4]\d|5[0-5]))$/', $ipAddress)) {

                    $record = $this->helper('aydus_visitorlog/geoip')->getRecord($ipAddress);

                    $row = (array) $record;

                    $rowObj = new Varien_Object();
                    $rowObj->setData($row);
                    $collection->addItem($rowObj);
                    $this->setCollection($collection);
                }
            }
        }

        return $this;
    }

    protected function _prepareColumns() {

        $this->addColumn('country_code', array(
            'header' => Mage::helper('aydus_visitorlog')->__('Country Code'),
            'index' => 'country_code',
        ));

        $this->addColumn('country_code3', array(
            'header' => Mage::helper('aydus_visitorlog')->__('Country Code 3'),
            'index' => 'country_code3',
        ));

        $this->addColumn('country_name', array(
            'header' => Mage::helper('aydus_visitorlog')->__('Country Name'),
            'index' => 'country_name',
        ));

        $this->addColumn('region', array(
            'header' => Mage::helper('aydus_visitorlog')->__('State/Province/Region'),
            'index' => 'region',
        ));

        $this->addColumn('city', array(
            'header' => Mage::helper('aydus_visitorlog')->__('City'),
            'index' => 'city',
        ));

        $this->addColumn('postal_code', array(
            'header' => Mage::helper('aydus_visitorlog')->__('Postal Code'),
            'index' => 'postal_code',
        ));

        $this->addColumn('latitude', array(
            'header' => Mage::helper('aydus_visitorlog')->__('Latitude'),
            'index' => 'latitude',
        ));

        $this->addColumn('longitude', array(
            'header' => Mage::helper('aydus_visitorlog')->__('Longitude'),
            'index' => 'longitude',
        ));

        $this->addColumn('area_code', array(
            'header' => Mage::helper('aydus_visitorlog')->__('Area Code'),
            'index' => 'area_code',
        ));

        $this->addColumn('dma_code', array(
            'header' => Mage::helper('aydus_visitorlog')->__('Designated Market Area'),
            'index' => 'dma_code',
        ));

        $this->addColumn('metro_code', array(
            'header' => Mage::helper('aydus_visitorlog')->__('Metro Code'),
            'index' => 'metro_code',
        ));

        //$this->addExportType('*/*/exportCsv', Mage::helper('adminhtml')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('adminhtml')->__('Excel XML'));
        //$this->addExportType('*/*/exportXml', Mage::helper('adminhtml')->__('XML'));

        return parent::_prepareColumns();
    }

}
