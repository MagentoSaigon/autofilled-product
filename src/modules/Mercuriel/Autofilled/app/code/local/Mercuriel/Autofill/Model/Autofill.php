<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/11/2016
 * Time: 5:57 PM
 */ 
class Mercuriel_Autofill_Model_Autofill extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('mercuriel_autofill/autofill');
    }

    public function getAttributeSetNameForProduct()
    {
        $attributeSetCollection = Mage::getModel('eav/entity_attribute_set')->getCollection()
            ->addFieldToFilter('entity_type_id',4);
        foreach($attributeSetCollection as $attributeSet)
        {
            $data[] = array(
                'value' => $attributeSet['attribute_set_id'],
                'label' => Mage::helper('mercuriel_autofill')->__($attributeSet['attribute_set_name']),
            );
        }
        return $data;
    }

}