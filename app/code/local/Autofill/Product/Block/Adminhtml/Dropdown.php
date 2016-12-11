<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 23/11/2016
 * Time: 13:46
 */
class Autofill_Product_Block_Adminhtml_Dropdown extends Mage_Core_Block_Template
{
    public function getAttributeInfo($attribute_set_id)
    {
        return Mage::getModel('autofill_product/info')->getCollection()
            ->addFieldToFilter('attribute_set_id',$attribute_set_id);
    }
}