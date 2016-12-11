<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 24/11/2016
 * Time: 13:53
 */
class Autofill_Product_Block_Adminhtml_Autofill_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareLayout()
    {
        $this->setChild('continue_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('autofill_product')->__('Continue'),
                    'class'     => 'save',
                    'onclick'   => "setSettings('".$this->getContinue()."','attribute_set_id','name_info')",
                    'class' => 'add'
                ))
        );
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }

        return parent::_prepareLayout();
    }
    public function getContinue()
    {
        return $this->getUrl('*/*/new/', array(
            '_current'  => true,
            'set'       => '{{attribute_set}}',
            'name_info'      =>  '{{name_info}}'
        ));
    }
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'=>'edit_form',
            'action' => $this->getUrl('*/*/save', array
            ('set' => $this->getRequest()->getParam('set'),
                'name_info' =>$this->getRequest()->getParam('name_info'),
                'id'=>$this->getRequest()->getParam('id')
            )),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $fieldset = $form->addFieldset('autofill_form',

            array('legend'=>Mage::helper('autofill_product')->__('Edit Set Name')));


        $setId = $this->getRequest()->getParam('set');
        $info_id = $this->getRequest()->getParam('id');

        if($info_id)
        {
            $autofillData = array();

            $autofillData = Mage::getModel('autofill_product/info')->load($info_id);

            if ($info_id)
            {
                $autofillData->load((int) $info_id);

                if ($autofillData->getAttributeSetId())
                {
                    $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                    if ($data)
                    {
                        $autofillData->setData($data)->setId($info_id);
                    }
                } else
                {
                    Mage::getSingleton('adminhtml/session')->addError
                    (Mage::helper('autofill_product')->__('The Autofill-Set does not exist'));
                    $this->_redirect('*/*/');
                }
            }
            $autofillValue = Mage::getModel('autofill_product/autofill')
                ->getCollection()->addFieldToFilter('info_id',$info_id);
            foreach($autofillValue as $item)
            {
                $autofillData[$item['attribute_code']] = $item['value'];
            }

            Mage::unregister('autofill_info_data');

            Mage::register('autofill_info_data',$autofillData);
        }
        if (Mage::getSingleton('adminhtml/session')->getFormData())
        {
            $data = Mage::getSingleton('adminhtml/session')->getFormData();
            Mage::getSingleton('adminhtml/session')->setFormData(null);

        }
        elseif(Mage::registry('autofill_info_data'))
        {
            $data = Mage::registry('autofill_info_data');
        }

        if($setId)
        {
            $groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
                ->setAttributeSetFilter($setId)
                ->setSortOrder()
                ->load();

            foreach ($groupCollection as $group)
            {
                if($group->getAttributeGroupName() == "General")
                {
                    $attributes = Mage::getResourceModel('catalog/product_attribute_collection')
                        ->setAttributeGroupFilter($group->getId())
                        ->addVisibleFilter()
                        ->checkConfigurableProducts()
                        ->load();

                    $storeId   = Mage::app()->getStore()->getId();

                    foreach($attributes as $attr)
                    {
                        $config    = Mage::getModel('eav/config');

                        $attribute = $config->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attr['attribute_code']);

                        $fieldset->addField(

                            $attr['attribute_code'],
                            Mage::helper('autofill_product')->convertFrontendInput($attr['frontend_input']),

                            array(
                                'label' => Mage::helper('autofill_product')->__($attr['frontend_label']),

                                'name' => $attr['attribute_code'],

                                'values'=>$attribute->setStoreId($storeId)->getSource()->getAllOptions(),

                                'config' => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
                            ));

                    }
                }
            }
        }
        else
        {
            $fieldset->addField('name_info', 'text', array(
                'label' => Mage::helper('autofill_product')->__('Autofill-set Name'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'name_info',
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
        }

        $form->setValues($data);

        return parent::_prepareForm();
    }
}