<?php
class Mercuriel_Autofill_Block_Adminhtml_Autofill_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'mercuriel_autofill';
        $this->_controller = 'adminhtml_autofill';

        $this->_updateButton('save', 'label',Mage::helper('mercuriel_autofill')->__('Save Attribute'));
    }

    public function getHeaderText(){
        return Mage::helper('mercuriel_autofill')->__('Add new attribute');
    }
}
