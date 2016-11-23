<?php
class Mercuriel_Autofill_Model_Resource_AutofillSet_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('mercuriel_autofill/autofillSet');
    }

}