<?php
/**
 * Created by PhpStorm.
 * User: tuan
 * Date: 20/11/2016
 * Time: 22:05
 */ 
class Training_Autofill_Model_Resource_Group_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('training_autofill/group');
    }

}