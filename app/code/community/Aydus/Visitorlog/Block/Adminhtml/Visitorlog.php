<?php

/**
 * Aydus Visitorlog admin block
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus <davidt@aydus.com>
 */

class Aydus_Visitorlog_Block_Adminhtml_Visitorlog extends Mage_Adminhtml_Block_Widget_Grid_Container 
{

    public function __construct()
    {
        $this->_controller         = 'adminhtml_visitorlog';
        $this->_blockGroup         = 'aydus_visitorlog';
        parent::__construct();
        $this->_headerText         = Mage::helper('aydus_visitorlog')->__('Visitor Log');
        $this->removeButton('add');
    }
}
