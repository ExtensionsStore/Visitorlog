<?php

/**
 * Visitorlog visitor view
 *
 * @category   Aydus
 * @package	   Aydus_Visitorlog
 * @author     Aydus Consulting <davidt@aydus.com>
 */
class Aydus_Visitorlog_Block_Adminhtml_Visitorlog_View extends Mage_Adminhtml_Block_Widget_Form_Container 
{
	public function __construct()
	{
		parent::__construct();
		$this->_objectId = 'id';
		$this->_blockGroup = 'aydus_visitorlog';
		$this->_controller = 'adminhtml_visitorlog';
		$this->_mode = 'view';
		
		$visitor = Mage::registry('current_visitor');
		
		$this->_headerText = Mage::helper('aydus_visitorlog')->__('Visitor Id: %d', $visitor->getId());
		
		$this->_removeButton('save');
		$this->_removeButton('reset');
		$this->_removeButton('delete');
	}

}
