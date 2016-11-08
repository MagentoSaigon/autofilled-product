<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 06/11/2016
 * Time: 10:10
 */
class Autofill_Product_Block_Adminhtml_Autofill_Edit_Tabs_Info extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareLayout()
    {
        $this->setChild('continue_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('autofill_product')->__('Continue'),
                    'class'     => 'save',
                    'onclick'   => "setSettings('".$this->getContinue()."','attribute_set_id','name-auto-fill')",
                    'class' => 'add'
                ))
        );

        return parent::_prepareLayout();
    }
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $form->setUseContainer(true);

        $this->setForm($form);

        if (Mage::getSingleton('adminhtml/session')->getFormData())
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData();
            Mage::getSingleton('adminhtml/session')->setFormData(null);

        }
        elseif(Mage::registry('autofill_data'))
        {
            $data = Mage::registry('autofill_data')->getData();
        }
        $fieldset = $form->addFieldset('autofill_form',

            array('legend'=>Mage::helper('autofill_product')->__('Edit Set Name')));

        $fieldset->addField('name-auto-fill', 'text', array(
            'label' => Mage::helper('autofill_product')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
        ));
        $fieldset->addField(
            'attribute_set_id',
            'select',
            array(
                'class'=>'validate-select',
                'label' => Mage::helper('autofill_product')->__('Attribute Set Name '),
                'required'=>true,
                'name' => 'set',
                'values' => Mage::getModel('autofill_product/autofill')->getAttributeSetNameForProduct()
            )
        );
        $fieldset->addField('continue_button', 'note', array(
            'text' => $this->getChildHtml('continue_button'),
        ));



        $form->setValues($data);

        return parent::_prepareForm();
    }
    public function getContinue()
    {
        return $this->getUrl('*/*/newFill/', array(
            '_current'  => true,
            'set'       => '{{attribute_set}}',
            'name'      =>  '{{name}}'
        ));
    }
}