<?php
/**
 * Created by PhpStorm.
 * User: tuan
 * Date: 21/11/2016
 * Time: 21:06
 */ 
class Training_Autofill_Model_Resource_Value_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('training_autofill/value');
    }

}