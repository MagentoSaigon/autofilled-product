<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 10/11/2016
 * Time: 09:44
 */
class Autofill_Product_Model_Resource_Info_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('autofill_product/info');
    }
}