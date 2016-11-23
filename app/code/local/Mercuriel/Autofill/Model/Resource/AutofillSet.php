<?php
class Mercuriel_Autofill_Model_Resource_AutofillSet extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('mercuriel_autofill/autofill_set', 'autofill_set_id');
    }

}