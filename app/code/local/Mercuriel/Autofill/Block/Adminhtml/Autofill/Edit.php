<?php
class Mercuriel_Autofill_Block_Adminhtml_Autofill_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct(){
        parent::__construct();
        $this->_objectId = 'autofill_set_id';
        $this->_blockGroup = 'mercuriel_autofill';
        $this->_controller = 'adminhtml_autofill';
        $this->_mode = 'edit';
        $this->_updateButton('save'     , 'label', Mage::helper('mercuriel_autofill')->__('Save Autofill Set'));
        $this->_updateButton('delete'   , 'label', Mage::helper('mercuriel_autofill')->__('Delete Autofill Set'));
    }
    public function getHeaderText()
    {
        if(Mage::registry('autofill_data') && Mage::registry('autofill_data')->getId())
        {
            return Mage::helper('mercuriel_autofill')->__('Edit Autofill Set %d', Mage::registry('autofill_data')->getId());
        }
        return Mage::helper('mercuriel_autofill')->__('Add new Autofill Attribute Set'); // TODO: Change the autogenerated stub
    }

}