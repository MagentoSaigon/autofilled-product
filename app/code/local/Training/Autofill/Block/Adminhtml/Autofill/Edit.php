<?php
/**
 * Created by PhpStorm.
 * User: tuan
 * Date: 20/11/2016
 * Time: 22:37
 */
class Training_Autofill_Block_Adminhtml_Autofill_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'id';
        parent::__construct();
        $this->_blockGroup = 'training_autofill';
        $this->_controller = 'adminhtml_autofill';
        $this->_mode = 'edit';
        $modelTitle = $this->_getModelTitle();
        $this->_updateButton('save', 'label', $this->_getHelper()->__("Save $modelTitle"));
    }

    protected function _getModelTitle()
    {
        return 'Auto-Fill Set';
    }

    protected function _getHelper()
    {
        return Mage::helper('training_autofill');
    }

    public function getHeaderText()
    {
        $model = $this->_getModel();
        $modelTitle = $this->_getModelTitle();
        if ($model && $model->getId()) {
            return $this->_getHelper()->__("Edit $modelTitle (ID: {$model->getId()})");
        } else {
            return $this->_getHelper()->__("New $modelTitle");
        }
    }

    protected function _getModel()
    {
        return Mage::registry('autofill_data');
    }
}
