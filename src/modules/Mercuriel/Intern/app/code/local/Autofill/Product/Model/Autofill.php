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

        foreach($attributeSetCollection as $attributeSet)
        {
            $data[] = array(
                'value' => $attributeSet['attribute_set_id'],
                'label' => Mage::helper('autofill_product')->__($attributeSet['attribute_set_name']),
            );
        }
        return $data;
    }
    public function retrieveJsonDataOfAutoFill($info_id)
    {
        $dataCollection =  Mage::getModel('autofill_product/autofill')->getCollection()
            ->addFieldToFilter('info_id',$info_id);

        foreach($dataCollection as $data)
        {
            $result[$data['attribute_code']] = $data['value'] ;
        }
        return Mage::helper('core')->jsonEncode($result);
    }
    public function loadByInfoId($info_id)
    {
        $matches = $this->getCollection()
            ->addFieldToFilter('info_id', $info_id);

        foreach ($matches as $match) {
            return $this->load($match->getId());
        }

    }
    public function convertDataToSaveForAutoFillInFo($data)
    {
        $attributeSetName  = Mage::getModel('eav/entity_attribute_set')
            ->getCollection()
            ->addFieldToFilter('attribute_set_id', $data['set'])
            ->getFirstItem()
            ->getAttributeSetName();

        $attributeSetId  = Mage::getModel('eav/entity_attribute_set')
            ->getCollection()
            ->addFieldToFilter('attribute_set_id', $data['set'])
            ->getFirstItem()
            ->getAttributeSetId() ;

        $info = array(
            'name_info'=>$data['name_info'],
            'attribute_set_name'=>$attributeSetName,
            'attribute_set_id' =>$attributeSetId
        );
        return $info  ;
    }
    public function convertDataToSaveAttributeValue($data,$info_id)
    {
        foreach($data as $key =>$value)
        {
            $attributeId = Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', $key);
            if($attributeId != 0)
            {
                $dataValue[] = array(
                    'attribute_code'=>$key,
                    'attribute_id' =>$attributeId,
                    'attribute_set_id'=>$data['set'],
                    'info_id'=>$info_id,
                    'value'=>$value
                );
            }
        }
        return $dataValue;
    }
}