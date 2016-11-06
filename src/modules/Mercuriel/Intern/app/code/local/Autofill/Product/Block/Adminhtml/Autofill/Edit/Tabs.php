<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 06/11/2016
 * Time: 10:08
 */
class Autofill_Product_Block_Adminhtml_Autofill_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct(array $args)
    {
        parent::__construct();
        $this->setId('form_tab');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('autofill_product')->__('Info AutoFill-Set '));
    }
    public function _beforeToHtml()
    {
        $this->addTab('form_info',array(
            
            'label' =>Mage::helper('autofill_product')->__('AutoFill-Set Infomation'),
            'title' =>Mage::helper('autofill_product')->__('AutoFill-Set Infomation'),

            'content' =>$this->getLayout()->createBlock('autofill_product/adminhtml_autofill_edit_tabs_info')->toHtml()
        ));
        
        return parent::_beforeToHtml();
    }

}