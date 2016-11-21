<?php
/**
 * Created by PhpStorm.
 * User: tuan
 * Date: 20/11/2016
 * Time: 22:37
 */
class Training_Autofill_Block_Adminhtml_Autofill extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_blockGroup      = 'training_autofill';
        $this->_controller      = 'adminhtml_autofill';
        $this->_headerText      = $this->__('Auto-Fill Attr.Sets');
        $this->_addButtonLabel  = $this->__('Add Attr.Set');
        parent::__construct();
    }

}

