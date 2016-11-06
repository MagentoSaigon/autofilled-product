<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 06/11/2016
 * Time: 00:43
 */
class Autofill_Product_Adminhtml_AutofillController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        return $this;

    }
    protected function _initAction()
    {
        $this
            ->loadLayout()
            ->_setActiveMenu('catalog')
        ;
        return $this;
    }
    public function newAction()
    {
        $id = $this->getRequest()->getParam('id');

        $model = Mage::getModel('autofill_product/autofill')->load($id);

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data))
        {
            $model->setData($data);
        }

        Mage::register('autofill_data_model', $model);

        $this->_initAction();
        $this->_title('Add New Autofill-Set');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->_addContent($this->getLayout()->createBlock('autofill_product/adminhtml_autofill_edit'));
        $this->_addLeft($this->getLayout()->createBlock('autofill_product/adminhtml_autofill_edit_tabs'));
        $this->renderLayout();

    }
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id', null);
        
        $dataAutoFill = Mage::getModel('autofill_product/autofill');
        if ($id) 
        {
            $dataAutoFill->load((int) $id);

            if ($dataAutoFill->getId())
            {
                $data = Mage::getSingleton
                ('adminhtml/session')->getFormData(true);
                if ($data)
                {
                    $dataAutoFill->setData($data)->setId($id);
                }
            }
            else
            {
                Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('autofill_product')
                        ->__('The Autofill-Set does not exist'));
                $this->_redirect('*/*/');
            }
        }
        Mage::register('autofill_data', $dataAutoFill);

        $this->loadLayout();

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->renderLayout();
    }
}