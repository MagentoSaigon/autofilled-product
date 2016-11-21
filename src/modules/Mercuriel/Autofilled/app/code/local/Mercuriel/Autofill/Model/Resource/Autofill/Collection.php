<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/11/2016
 * Time: 5:57 PM
 */ 
class Mercuriel_Autofill_Model_Resource_Autofill_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('mercuriel_autofill/autofill');
    }

}