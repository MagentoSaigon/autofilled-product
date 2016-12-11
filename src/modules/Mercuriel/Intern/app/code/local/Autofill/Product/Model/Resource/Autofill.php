<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 05/11/2016
 * Time: 23:58
 */
class Autofill_Product_Model_Resource_Autofill extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('autofill_product/autofill_product','id');
    }
}