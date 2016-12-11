<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 24/11/2016
 * Time: 13:48
 */
class Autofill_Product_Adminhtml_AutofillController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('AutoFill-Set'));
        $this->loadLayout()
            ->_setActiveMenu('catalog');
        $this->renderLayout();
        return $this;
    }
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog');
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

        Mage::register('autofill_info_data', $model);

        $this->_initAction();

        if($this->getRequest()->getParam('id'))
        {
            $this->_title('Edit Autofill-Set');
        }else
        {
            $this->_title('Add New Autofill-Set');
        }


        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->_addContent($this->getLayout()->createBlock('autofill_product/adminhtml_autofill_edit'));

        $this->renderLayout();
    }
    public function saveAction()
    {
        $data = $this->getRequest()->getParams();

        $info_id = $this->getRequest()->getParam('id');

        $info = Mage::getModel('autofill_product/autofill')
            ->convertDataToSaveForAutoFillInFo($data);

        if($info_id)
        {
            $infoModel = Mage::getModel('autofill_product/info')->load($info_id);
            $infoModel->addData($info);
            try
            {
                $infoModel->setId($info_id)->save();

            }catch(Exception $e)
            {
                Mage::logException($e);
            }
            $dataValue = Mage::getModel('autofill_product/autofill')
                ->convertDataToSaveAttributeValue($data,$info_id);

            $valueModel = Mage::getModel('autofill_product/autofill')->getCollection()
            ->addFieldToFilter('info_id',$info_id);
                foreach ($valueModel as $model)
                {
                    for($i=0;$i<count($dataValue);$i++)
                    {
                        $updateAttr = Mage::getModel('autofill_product/autofill')
                            ->load($model->getId()+$i);
                        $updateAttr->addData($dataValue[$i]);
                        try
                        {
                          $updateAttr->setId($model->getId()+$i)->save();
                        }
                        catch (Exception $e)
                        {
                            Mage::logException($e);

                        }
                        if($i == count($dataValue)-1)
                        {
                            break 2;
                        }
                }
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('autofill_product')->__('Autofill-Set Data was successfully updated'));

            $this->_redirect('*/*/');
        }else
        {
            $infoModel = Mage::getModel('autofill_product/info')->setData($info);
            $valueModel = Mage::getModel('autofill_product/autofill');
            try
            {
                $infoModel->save();

                $id = $infoModel->getId();

            }catch(Exception $e)
            {
                Mage::logException($e);
            }
            $dataValue = Mage::getModel('autofill_product/autofill')
                ->convertDataToSaveAttributeValue($data,$id);
            foreach($dataValue as $value)
            {
                $valueModel->setData($value);
                try
                {
                    $valueModel->save();
                }catch(Exception $e)
                {
                    Mage::logException($e);
                }
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('autofill_product')->__('Autofill-Set Data was successfully saved'));

            $this->_redirect('*/*/');
        }
    }
    public function massDeleteAction()
    {
        $idsInfo  = $this->getRequest()->getParams('id');
        if(!is_array($idsInfo)) {
            Mage::getSingleton('adminhtml/session')
                ->addError(Mage::helper('autofill_product')->__('Please select one or more autofill-set.'));
        } else {
            try {
                $model = Mage::getModel('autofill_product/info');
                foreach ($idsInfo as $ids)
                {
                    foreach($ids as $id)
                    {
                        $model->load($id)->delete();
                    }

                }
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(Mage::helper('adminhtml')->__('Deleted autofill-set'));
            } catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    public function deleteAction()
    {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('autofill_product/info');

                $model->setId($id);

                $model->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('autofill_product')->__('The Autofill-set has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find the example to delete.'));
        $this->_redirect('*/*/');
    }
    public function editAction()
    {
        $info_id = $this->getRequest()->getParam('id');

        $autofillData = Mage::getModel('autofill_product/info')->load($info_id);

        if ($info_id)
        {
            $this->_title('Edit Autofill-Set');
            $autofillData->load((int) $info_id);

            if ($autofillData->getAttributeSetId())
            {
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
                if ($data)
                {
                    $autofillData->setData($data)->setId($info_id);
                }
            } else
                {
                Mage::getSingleton('adminhtml/session')->addError
                (Mage::helper('autofill_product')->__('The Autofill-Set does not exist'));
                $this->_redirect('*/*/');
            }
        }
        Mage::register('autofill_info_data',$autofillData);

        $this->loadLayout();

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->renderLayout();
    }


    public function ajaxAction()
    {
        $info_id = $this->getRequest()->getPost('info_id');

        $data = Mage::getModel('autofill_product/autofill')->retrieveJsonDataOfAutoFill($info_id);

        $this->getResponse()->setBody($data);
    }

}