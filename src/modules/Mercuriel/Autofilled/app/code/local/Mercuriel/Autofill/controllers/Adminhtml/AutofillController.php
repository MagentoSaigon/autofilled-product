<?php
class Mercuriel_Autofill_Adminhtml_AutofillController extends Mage_Adminhtml_Controller_Action{
    public function indexAction(){
        $this->_title($this->__('Autofill Set'));
        $this->loadLayout()
        ->_setActiveMenu('catalog');
        $this->_addContent($this->getLayout()->createBlock('mercuriel_autofill/adminhtml_autofill'));
        $this->renderLayout();
    }

    /*public function gridAction(){
        $this->loadLayout();
        $this->getReponse()->setBody(
            $this->getLayout()->createBlock('mercuriel_autofill/adminhtml_autofill_grid')->toHtml()
        );
    }*/

    protected function _initAction(){
        $this->loadLayout()
        ->_setActiveMenu('catalog');
        return $this;
    }

    public function newAction() {
        $id  = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('mercuriel_autofill/autofill')->load($id);
//        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data))
                $model->setData($data);
            Mage::register('mercuriel_autofill', $model);

            $this->loadLayout();
            $this->_setActiveMenu('catalog/attribute');
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('mercuriel_autofill/adminhtml_autofill_edit'));
//                ->_addLeft($this->getLayout()->createBlock('mercuriel_autofill/adminhtml_autofill_edit_tabs'));
            $this->renderLayout();
//        } else {
//            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mercuriel_autofill')->__('Item does not exist'));
//            $this->_redirect('*/*/');
//        }
    }

}
?>