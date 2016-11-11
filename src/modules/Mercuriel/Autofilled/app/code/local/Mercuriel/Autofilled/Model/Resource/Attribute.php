<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/11/2016
 * Time: 5:57 PM
 */ 
class Mercuriel_Autofilled_Model_Resource_Attribute extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('mercuriel_autofilled/att_set_default', 'att_set_default_id');
    }

}