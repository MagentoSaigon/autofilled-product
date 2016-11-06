<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 06/11/2016
 * Time: 09:33
 */
class Autofill_Product_Block_Adminhtml_Autofill_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';

        $this->_blockGroup = 'autofill_product';

        $this->_controller = 'adminhtml_autofill';

        $this->_mode = 'edit';

        $this->_updateButton('save', 'label',
            Mage::helper('autofill_product')->__('Save AutoFill-Set'));

        $this->_updateButton('delete', 'label',

            Mage::helper('autofill_product')->__('Delete AutoFill-Set'));

    }
    
    public function getHeaderText(){
        if(Mage::registry('autofill_data') && Mage::registry('autofill_data')->getId())
            return Mage::helper('autofill_product')->__("Edit Auto-fill Set '%s'",
                $this->htmlEscape(Mage::registry('autofill_data')->getTitle()));
        return Mage::helper('autofill_product')->__('Add New Auto-fill Set');
    }
}