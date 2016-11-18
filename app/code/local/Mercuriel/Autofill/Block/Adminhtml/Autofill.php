<?php
class Mercuriel_Autofill_Block_Adminhtml_Autofill extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct()
    {
        $this->_blockGroup = 'mercuriel_autofill';
        $this->_controller = 'adminhtml_autofill';
        $this->_headerText = Mage::helper('mercuriel_autofill')->__('Manage Autofill Attribute Set');
        parent::__construct();

    }
}