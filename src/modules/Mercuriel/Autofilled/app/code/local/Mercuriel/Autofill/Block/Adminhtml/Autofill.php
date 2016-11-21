<?php
class Mercuriel_Autofill_Block_Adminhtml_Autofill extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct()
    {
        $this->_controller = "adminhtml_autofill";

        $this->_blockGroup = "mercuriel_autofill";

        $this->_headerText = Mage::helper('mercuriel_autofill')->__('Attribute Auto-Fill Set');

        parent::__construct();
        
        $this->_addButtonLabel = Mage::helper('mercuriel_autofill')->__('Add New Auto-fill Set');
    }
}