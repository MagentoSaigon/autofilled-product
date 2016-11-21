<?php

/**
 * Created by PhpStorm.
 * User: tuan
 * Date: 20/11/2016
 * Time: 22:37
 */
class Training_Autofill_Block_Adminhtml_Autofill_Edit_Form extends
    Mage_Adminhtml_Block_Widget_Form
{
    protected function _getHelper()
    {
        return Mage::helper('training_autofill');
    }

    protected function _getModelTitle()
    {
        return 'Edit Set Name';
    }

    protected function _prepareForm()
    {
        $modelTitle = $this->_getModelTitle();
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );

        if (Mage::getSingleton('adminhtml/session')->getFormData()) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData();
            Mage::getSingleton('adminhtml/session')->setFormData(null);
        } elseif (Mage::registry('autofill_data')) {
            $data = Mage::registry('autofill_data')->getData();
        }

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => $this->_getHelper()->__("$modelTitle")
        ));

        $fieldset->addField('name', 'text', array(
            'label' => $this->_getHelper()->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'name',
            'note' => $this->_getHelper()->__('For internal use.'),
        ));

        $attributeSetCollection = Mage::getResourceModel('eav/entity_attribute_set_collection')->load();

        foreach ($attributeSetCollection as $attributeSet) {
            $name = $attributeSet->getAttributeSetName();
            $id = $attributeSet->getEntityTypeId();
            $sets[] = array(
                'value' => $id,
                'label' => $name,
            );
        }
        $fieldset->addField('attribute_set_id', 'select', array(
            'label' => $this->_getHelper()->__('Attribute Set'),
            'required' => true,
            'name' => 'attribute_set_id',
            'class' => 'required-entry',
            'values' => $sets,
        ));
        $form->setUseContainer(true);
        $form->setValues($data);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}