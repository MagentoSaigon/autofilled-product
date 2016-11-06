<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 05/11/2016
 * Time: 23:56
 */
class Autofill_Product_Model_Autofill extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        $this->_init('autofill_product/autofill');
    }
    public function getAttributeSetNameForProduct()
    {
        $attributeSetCollection = Mage::getModel('eav/entity_attribute_set')->getCollection()
            ->addFieldToFilter('entity_type_id',4);

        $data = array(
            array(
            'value'=>0,
            'label'=>Mage::helper('autofill_product')->__('-- Please Select Attribute Set --')
        ));

        foreach($attributeSetCollection as $attributeSet)
        {
            $data[] = array(
                'value' => $attributeSet['attribute_set_id'],
                'label' => Mage::helper('autofill_product')->__($attributeSet['attribute_set_name']),
            );
        }

        return $data;
    }
}