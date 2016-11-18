<?php
class Mercuriel_Autofill_Adminhtml_AutofillController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        return $this;
    }
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id',null);;
        $autofill = Mage::getResourceModel('mercuriel_autofill/autofillGroup_collection');
        if($id){
            $autofill->getSelect()
                ->join('eav_attribute_group',
                    'eav_attribute_group.attribute_group_id = main_table.attribute_group_id',
                    array('attribute_group_name','attribute_set_id'))
                ->join('eav_attribute_set',
                    'eav_attribute_set.attribute_set_id = eav_attribute_group.attribute_set_id',
                    array('attribute_set_name'));
            $autofill = $autofill->addFieldToFilter('autofill_group_id', $id)->getFirstItem();

            if($autofill->getId()){
                $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            }
            if($data){
                $autofill->setData($data)->setId($id);
            }
        }
        else{
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mercuriel_autofill')->__('The Autofill Set is not exist'));
            $this->_redirect('*/*/');
        }
        Mage::register('autofill_data', $autofill);
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }
    public function saveAction()
    {

        if( $this->getRequest()->getPost())
        {
            try{
                $data = $this->getRequest()->getPost();
                $id   = $this->getRequest()->getParam('autofill_group_id');
                if ($data && $id)
                {
                    Mage::getModel('mercuriel_autofill/autofillGroup')->load($id)
                        ->setData($data)->save();
                    $params = $this->getRequest()->getPost();
                    foreach($params as $key => $value)
                    {
                        Mage::getModel('mercuriel_autofill/autofillValue')->addFieldToFilter('attribute_id',
                            Mage::getModel('eav/attribute')->addFieldToFilter('attribute_code',$key)
                                ->addFieldToFilter('attribute_group_id', $id)->getId())
                            ->addFieldToFilter('autofill_group_id', $id);
                            }

                  $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getPost('autofill_group_id')));
                }
            }
            catch(Exception $e){
                $this->_getSession()->addError(Mage::helper('mercuriel_autofill')->__(
                    'An error occured while saving the registry data. Please review the log and try again.'
                ));
                Mage::logException($e);
                $this->_redirect('*/*/edit', array(
                    'id' => $this->getRequest()->getPost('autofill_group_id')
                ));
            }
        }
    }
    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        return $this;
    }
    public function massDeleteAction()
    {
        $autofillIds = $this->getRequest()->getParam('autofill');
        if(!is_array($autofillIds)){
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mercuriel_autofill')->__(
                'Please select one or more registries.'
            ));
            $this->getResponse()->setRedirect($this->getUrl('*/*/index'));
            return;
        }
        else{
            try{
                $autofill = Mage::getModel('mercuriel_autofill/autofillGroup');
                foreach($autofillIds as $autofillId){
                    $autofill->load($autofillId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mercuriel_autofill')->__(
                    'Total %d autofill attribute value Group(s) were deleted', count($autofillIds)
                ));
                $this->getResponse()->setRedirect($this->getUrl('*/*/index'));
                return;
            }
            catch(Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                return;
            }
        }
        $this->loadLayout();
        $this->renderLayout();
        return $this;
    }
}