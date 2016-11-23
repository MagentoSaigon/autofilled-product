<?php
class Mercuriel_Autofill_Block_Adminhtml_Select extends Mage_Adminhtml_Block_Abstract
{
    public function getAttributeSet($attributeSetId){
        return Mage::getModel('mercuriel_autofill/autofillSet')->getCollection()
            ->addFieldToFilter('attribute_set_id', $attributeSetId);
    }

}