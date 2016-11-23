<?php
class Mercuriel_Autofill_Adminhtml_AutofillController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('autofill/valueset');
        $this->renderLayout();
        return $this;
    }
    public function newAction()
    {

        $this->_title($this->__('New Autofill Set'));
        $this->loadLayout();
//        if ($this->getRequest()->getParam('popup')) {
//            $this->loadLayout('popup');
//        } else {
//            $_additionalLayoutPart = '';
//            if ($product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE
//                && !($product->getTypeInstance()->getUsedProductAttributeIds()))
//            {
//                $_additionalLayoutPart = '_new';
//            }
//            $this->loadLayout(array(
//                'default',
//                strtolower($this->getFullActionName()),
//                'adminhtml_catalog_product_'.$product->getTypeId() . $_additionalLayoutPart
//            ));
            $this->_setActiveMenu('catalog/attribute');
//        }

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
//
//        $block = $this->getLayout()->getBlock('catalog.wysiwyg.js');
//        if ($block) {
//            $block->setStoreId($product->getStoreId());
//        }

        $this->renderLayout();
    }
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id',null);

        $autofill = Mage::getResourceModel('mercuriel_autofill/autofillSet_collection');
        if($id){
            $autofill->getSelect()
                ->join('eav_attribute_set',
                    'eav_attribute_set.attribute_set_id = main_table.attribute_set_id');
            $autofill = $autofill->addFieldToFilter('autofill_set_id', $id)->getFirstItem();
            $autofill['autofill_set_name'] = $autofill['name'];
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
        $this->_setActiveMenu('catalog/attributes');
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
        $this->renderLayout();
    }
    public function saveAction()
    {

        if($this->getRequest()->getPost())
        {
            try{
                $data = $this->getRequest()->getPost();
                $id = $this->getRequest()->getParam('autofill_set_id');

                if ($data && $id)
                {
                    Mage::getModel('mercuriel_autofill/autofillSet')->load($id)
                        ->setName($data['autofill_set_name'])
                        ->setAttributeSetId($data['attribute_set_id'])
                        ->save();
                    $valueData = array();
                    $valueData['autofill_set_id'] = $id;
                    foreach($data as $key => $value){

                        if(Mage::helper('mercuriel_autofill')->isAttributeCode($key, $data['attribute_set_id']) && !is_null($value)){

                            $valueData['attribute_id'] = Mage::helper('mercuriel_autofill')->getAttributeId($key, $data['attribute_set_id']);
                            $valueData['value'] = $value;
                            $item = Mage::getResourceModel('mercuriel_autofill/autofillValue_collection')
                                ->addFieldToFilter('autofill_set_id', $id)
                                ->addFieldToFilter('attribute_id', $valueData['attribute_id'])
                                ->getFirstItem();

//                            die(Mage::helper('mercuriel_autofill')->getAttributeId($key, $data['attribute_set_id']));
                            if($item){

//                                die($item->getId());
                                Mage::getModel('mercuriel_autofill/autofillValue')
                                    ->load($item->getId())
                                    ->setAttributeId($valueData['attribute_id'])
                                    ->setValue($valueData['value'])
                                    ->save();
                            }
                            else {
                                Mage::getModel('mercuriel_autofill/autofillValue')->setData($valueData)->save();
                            }
                        }
                    }
                  $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getPost('autofill_set_id')));
                }
//                elseif($data && is_null($id)){
//                    Mage::getModel('mercuriel_autofill/autofillSet')->setData($data)->save();
//                }
            }
            catch(Exception $e){
                $this->_getSession()->addError(Mage::helper('mercuriel_autofill')->__(
                    'An error occured while saving the registry data. Please review the log and try again.'
                ));
                Mage::logException($e);
                die($e);
                $this->_redirect('*/*/edit', array(
                    'id' => $this->getRequest()->getPost('autofill_set_id')
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
    public function ajaxAction()
    {
        //This fucntion will return the array which have type of $key -> $values
        //key is the id of autofill set that have the attribute set id is the sended attribute set id
        //And value take form the table autofill_value
        $this->loadLayout();
        $this->renderLayout();

        $returnData = array();
        $param = $this->getRequest()->getParam('id');
        $keys = Mage::getModel('mercuriel_autofill/autofillSet')->getCollection()
            ->addFieldToFilter('attribute_set_id', 4);
        foreach($keys as $key){
            $values = Mage::getModel('mercuriel_autofill/autofillValue')->getCollection()
                ->addFieldToFilter('autofill_set_id', $key->getId());
            $autofillValues = array();
            foreach($values as $value){
                $autofillValues[Mage::getModel('eav/entity_attribute')
                    ->load((int)($value->getAttributeId()))->getAttributeCode()] = $value->getValue();

            }
            $returnData[$key->getId()] = $autofillValues;
        }
        return $returnData;

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
                $autofill = Mage::getModel('mercuriel_autofill/autofillSet');
                foreach($autofillIds as $autofillId){
                    $autofill->load($autofillId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mercuriel_autofill')->__(
                    'Total %d autofill attribute value Set(s) were deleted', count($autofillIds)
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