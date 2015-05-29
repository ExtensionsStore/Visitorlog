<?php

/**
 * Adminhtml customer edit form block
 *
 * @category   Aydus
 * @package    Aydus_Visitorlog
 * @author     Aydus <davidt@aydus.com>
 */
class Aydus_Visitorlog_Block_Adminhtml_Visitorlog_View_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getData('action'),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $visitor = Mage::registry('current_visitor');

        if ($visitor->getId()) {
            $form->addField('visitor_id', 'hidden', array(
                'name' => 'visitor_id',
            ));
            $form->setValues($visitor->getData());
        }

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
