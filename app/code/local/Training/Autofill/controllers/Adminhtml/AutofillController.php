<?php

/**
 * Created by PhpStorm.
 * User: tuan
 * Date: 20/11/2016
 * Time: 22:01
 */
class Training_Autofill_Adminhtml_AutofillController extends
    Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        return $this;
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('training_autofill/group')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('autofill_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('catalog');

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('training_autofill')
                    ->__('Attribute Set does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('training_autofill/group');
            $model  ->setData($data)
                    ->setId($this->getRequest()->getParam('id'));
            try {
                $model->save();
                Mage::getSingleton('adminhtml/session')
                        ->addSuccess(Mage::helper('training_autofill')
                        ->__('Successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')
                ->addError(Mage::helper('training_autofill')
                ->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $autofillIds = $this->getRequest()->getParam('delete_id');
        if (!is_array($autofillIds)) {
            Mage::getSingleton('adminhtml/session')
                    ->addError(Mage::helper('adminhtml')
                    ->__('Please select item(s)'));
        } else {
            try {
                foreach ($autofillIds as $autofillId) {
                    $web = Mage::getModel('training_autofill/group')->load($autofillId);
                    $web->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($autofillIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}