<?php
class Mercuriel_Autofill_Model_Resource_AutofillValue_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract{
    public function _construct()
    {
        $this->_init('mercuriel_autofill/autofillValue');
    }
}