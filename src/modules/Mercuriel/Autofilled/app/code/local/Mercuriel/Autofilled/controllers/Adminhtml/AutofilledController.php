<?php
class Mercuriel_Autofilled_Adminhtml_AutofilledController extends Mage_Adminhtml_Controller_Action{
    public function indexAction(){
        $this->_title($this->__('Autofill Set'));
        $this->loadLayout()
        ->_setActiveMenu('catalog');
        $this->renderLayout();
        return $this;
    }

    protected function _initAction(){
        $this->loadLayout()
        ->_setActiveMenu('catalog');
        return $this;
    }
}
?>