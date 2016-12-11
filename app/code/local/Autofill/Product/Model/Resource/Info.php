<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 10/11/2016
 * Time: 09:43
 */
class Autofill_Product_Model_Resource_Info extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('autofill_product/autofill_info','id');
    }
}