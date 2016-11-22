<?php
class Mercuriel_Autofill_Block_Adminhtml_Autofill_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('autofill_form', array('legend'=>Mage::helper('mercuriel_autofill')->__('Item information')));

        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('form')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));

        return parent::_prepareForm();
    }
}