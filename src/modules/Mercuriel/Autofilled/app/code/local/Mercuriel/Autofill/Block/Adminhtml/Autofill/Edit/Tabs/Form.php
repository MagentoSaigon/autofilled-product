<?php
class Mercuriel_Autofill_Block_Adminhtml_Autofill_Edit_Tabs_Form extends Mage_Adminhtml_Block_Widget_Form{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        if (Mage::getSingleton('adminhtml/session')->getAutofillData()) {
            $data = Mage::getSingleton('adminhtml/session')->getAutofillData();
            Mage::getSingleton('adminhtml/session')->setAutofillsData(null);
        } elseif (Mage::registry('mercuriel_autofill'))
            $data = Mage::registry('mercuriel_autofill')->getData();

        $fieldset = $form->addFieldset('tests_form', array('legend' => Mage::helper('mercuriel_autofill')->__('Item information')));

        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('tests')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));

        $form->setValues($data);
        return parent::_prepareForm();
    }
}