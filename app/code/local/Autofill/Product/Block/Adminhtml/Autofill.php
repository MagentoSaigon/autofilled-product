<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 24/11/2016
 * Time: 13:49
 */
class Autofill_Product_Block_Adminhtml_Autofill extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_autofill';

        $this->_blockGroup = 'autofill_product';

        $this->_headerText = Mage::helper('autofill_product')->__('Attribute Auto-Fill Set');

        $this->_addButtonLabel = Mage::helper('autofill_product')->__('Add New Auto-fill Set');

        parent::__construct();

    }
}