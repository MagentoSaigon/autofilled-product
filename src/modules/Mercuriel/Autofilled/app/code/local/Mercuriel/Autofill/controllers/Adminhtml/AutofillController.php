<?php
class Mercuriel_Autofill_Adminhtml_AutofillController extends Mage_Adminhtml_Controller_Action{
    public function indexAction(){
        $this->_title($this->__('Autofill Set'));
        $this->loadLayout()
        ->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('mercuriel_autofill/adminhtml_autofill'));
        $this->renderLayout();
    }

    public function gridAction(){
        $this->loadLayout();
        $this->getReponse()->setBody(
            $this->getLayout()->createBlock('mercuriel_autofill/adminhtml_autofill_grid')->toHtml()
        );
    }

    public function newAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('mercuriel_autofill/adminhtml_autofill_edit'))
            ->_addLeft($this->getLayout()->createBlock('mercuriel_autofill/adminhtml_autofill_edit_tabs'));
        $this->renderLayout();
    }
}
?>