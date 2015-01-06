<?php

/**
 * Visitorlog geoip filter form
 *
 * @category   Aydus
 * @package	   Aydus_Visitorlog
 * @author     Aydus Consulting <davidt@aydus.com>
 */

class Aydus_Visitorlog_Block_Adminhtml_Geoip_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Prepare form for render
	 */
	protected function _prepareForm()
	{
        $actionUrl = $this->getUrl('*/*/');
        $form = new Varien_Data_Form(
            array('id' => 'filter_form', 'action' => $actionUrl, 'method' => 'get', 'onsubmit' => 'filterFormSubmit(); return false;')
        );
        $htmlIdPrefix = 'sales_report_';
        $form->setHtmlIdPrefix($htmlIdPrefix);
		
		$fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('aydus_visitorlog')->__('Input IP Address to Search GeoIP Database')));

		$fieldset->addField('ip_address', 'text',
			array(
				'name'  => 'ip_address',
				'label' => Mage::helper('aydus_visitorlog')->__('IP Address'),
				'title' => Mage::helper('aydus_visitorlog')->__('IP Address'),
				'note'  => Mage::helper('aydus_visitorlog')->__('Type the numerical IP address. IP addresses consist of four number segments of one to three digits each (i.e. 74.125.226.227 and 208.80.152.201)'),
				'required' => true,
			)
		);
			
		$form->setUseContainer(true);
		$this->setForm($form);
	}	

	/**
	 * Fill form with values
	 */
	protected function _initFormValues()
	{
		if ($this->getFilterData()){
			$data = $this->getFilterData()->getData();
			foreach ($data as $key => $value) {
				if (is_array($value) && isset($value[0])) {
					$data[$key] = explode(',', $value[0]);
				}
			}
			$this->getForm()->addValues($data);
		}
		
		return parent::_initFormValues();
	}

}
