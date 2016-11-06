<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 06/11/2016
 * Time: 10:10
 */
class Autofill_Product_Block_Adminhtml_Autofill_Edit_Tabs_Info extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $form->setUseContainer(true);

        $this->setForm($form);

        $dataAttributeSet = Mage::getModel('autofill_product/autofill')
            ->getAttributeSetNameForProduct();

        if (Mage::getSingleton('adminhtml/session')->getFormData())
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData();
            Mage::getSingleton('adminhtml/session')->setFormData(null);
        }elseif(Mage::registry('autofill_data'))
        {
            $data = Mage::registry('autofill_data')->getData();
        }
        $fieldset = $form->addFieldset('autofill_form',

            array('legend'=>Mage::helper('autofill_product')->__('Edit Set Name')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('autofill_product')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
        ));
        $fieldset->addField(
            'attribute_set_id',
            'select',
            array(
                'class'=>'required-entry',
                'label' => Mage::helper('autofill_product')->__('Attribute Set Name '),
                'required'=>true,
                'name' => 'attribute_set_id',
                'values' => Mage::getModel('autofill_product/autofill')->getAttributeSetNameForProduct()
            )
        );



        $form->setValues($data);

        return parent::_prepareForm();
    }
}