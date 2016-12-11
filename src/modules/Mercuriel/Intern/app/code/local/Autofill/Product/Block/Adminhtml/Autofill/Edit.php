<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 24/11/2016
 * Time: 13:52
 */
class Autofill_Product_Block_Adminhtml_Autofill_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'set';

        $this->_blockGroup = 'autofill_product';

        $this->_controller = 'adminhtml_autofill';

        $this->_mode = 'edit';

        $setId = $this->getRequest()->getParam('set');

        if($setId == null )
        {
            $this->_removeButton('save');
        }
        $this->_updateButton('save', 'label',

            Mage::helper('autofill_product')->__('Save AutoFill-Set'));
        $this->_updateButton('delete', 'label',

            Mage::helper('autofill_product')->__('Delete AutoFill-Set'));

    }

    public function getHeaderText(){
        if(Mage::registry('autofill_info_data') && Mage::registry('autofill_info_data')->getId())
            return Mage::helper('autofill_product')->__("Edit Auto-fill Set '%s'",
                $this->htmlEscape(Mage::registry('autofill_info_data')->getTitle()));
        return Mage::helper('autofill_product')->__('Add New Auto-fill Set');
    }
}