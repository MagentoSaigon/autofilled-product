<?php
class Mercuriel_Autofilled_Block_Adminhtml_Autofill extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct()
    {
        $this->_controller = "adminhtml_autofilled";

        $this->_blockGroup = "mercuriel_autofilled";

        $this->_headerText = Mage::helper('mercuriel_autofilled')->__('Attribute Auto-Fill Set');

        parent::__construct();
        
        $this->_addButtonLabel = Mage::helper('mercuriel_autofilled')->__('Add New Auto-fill Set');
    }
}