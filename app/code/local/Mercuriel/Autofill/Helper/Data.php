<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/9/2016
 * Time: 8:07 PM
 */

class Mercuriel_Autofill_Helper_Data extends Mage_Core_Helper_Abstract {


    public function getAttributeId($attributeCodeName, $setId){
       $connection = Mage::getSingleton('core/resource')->getConnection('core_setup');
        $data = $connection->select()
            ->from(array('a'=>'eav_attribute'))
            ->join(array('b'=>'eav_entity_attribute'), "a.attribute_id = b.attribute_id")
            ->where('attribute_code = ?', $attributeCodeName)
            ->where('attribute_set_id = ?', $setId)->query()->fetchAll();
        if(is_null($data))
            return null;
        return $data[0]['attribute_id'];

    }
    public function isAttributeCode($attributeCode = null, $setId = null){
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $data = $connection->select('attribute_code')
            ->from(array('a'=>'eav_attribute'))
            ->join(array('b'=>'eav_entity_attribute'), "a.attribute_id = b.attribute_id")
            ->where('attribute_code = ?', $attributeCode)
            ->where('attribute_set_id = ?', $setId)->query()->fetchAll();
        return !empty($data);
    }
    public function getAttributeGroupId($attributeSetId)
    {
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $data = $connection->select('attribute_group_id')
            ->from(array('attribute_group' => 'eav_attribute_group'))
            ->where('attribute_set_id = ?', $attributeSetId)
            ->where('attribute_group_name = ?', "General")->query()->fetchAll();
        return $data[0]['attribute_group_id'];
    }
    public function getAttributeCollection($attributeSetId){
        $attributeGroupId = $this->getAttributeGroupId($attributeSetId);
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $data = $connection->select()
            ->from(array('entity_attribute'=>'eav_entity_attribute'))
            ->where('attribute_group_id = ?', $attributeGroupId)
            ->join(array('attribute'=>'eav_attribute'), 'entity_attribute.attribute_id = attribute.attribute_id')
            ->where('frontend_input is not null')
            ->where('frontend_label is not null')
            ->where('backend_type != ?', 'static') //WE have to filter the unnecessary values
            ->query()->fetchAll();
        return $data;
    }
}