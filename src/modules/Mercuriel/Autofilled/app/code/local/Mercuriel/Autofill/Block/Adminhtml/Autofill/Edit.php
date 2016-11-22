<?php
class Mercuriel_Autofill_Block_Adminhtml_Autofill_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'mercuriel_autofill';
        $this->_controller = 'adminhtml_autofill';

        $this->_updateButton('save', 'label', Mage::helper('mercuriel_autofill')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('mercuriel_autofill')->__('Delete Item'));
    }

    public function getHeaderText(){
        if(Mage::registry('autofill_data') && Mage::registry('autofill_data')->getId())
            return Mage::helper('autofill_product')->__("Edit Auto-fill Set '%s'",
                $this->htmlEscape(Mage::registry('autofill_data')->getTitle()));
        return Mage::helper('mercuriel_autofill')->__('Add New Auto-fill Set');
    }
}
