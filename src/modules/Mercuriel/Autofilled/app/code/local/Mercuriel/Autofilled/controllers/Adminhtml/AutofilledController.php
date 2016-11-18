<?php
class Mercuriel_Autofilled_Adminhtml_AutofilledController extends Mage_Adminhtml_Controller_Action{
    public function indexAction(){
        $this->_title($this->__('Autofill Set'));
        $this->loadLayout()
        ->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('mercuriel_autofilled/adminhtml_autofill'));
        $this->renderLayout();
    }

    public function gridAction(){
        $this->loadLayout();
        $this->getReponse()->setBody(
            $this->getLayout()->createBlock('mercuriel_autofilled/adminhtml_autofill_grid')->toHtml()
        );
    }

    protected function _initAction(){
        $this->loadLayout()
        ->_setActiveMenu('catalog');
        return $this;
    }
}
?>