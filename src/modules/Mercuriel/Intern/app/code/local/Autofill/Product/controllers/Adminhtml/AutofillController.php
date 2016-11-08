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
        $this->_title($this->__('AutoFill-Set'));
        $this
            ->loadLayout()
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

        Mage::register('autofill_data', $model);

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
    public function newFillAction()
    {
        $setId = $this->getRequest()->getParam('set');

        $name = $this->getRequest()->getParam('name');

        if(Mage::getModel('core/session')->getAutofillName() || Mage::getModel('core/session')->getAttrSetId() )
        {
            Mage::getModel('core/session')->unsAutofillName();

            Mage::getModel('core/session')->unsAttrSetId();
        }

        Mage::getModel('core/session')->setAutofillName($name);

        Mage::getModel('core/session')->setAttrSetId($setId);

        $product = $this->_initProduct();

        Mage::dispatchEvent('catalog_product_new_action', array('product' => $product));

        $attributeSetId = $this->getRequest()->getParam('set');

        $model = Mage::getModel('autofill_product/autofill')->load($attributeSetId);

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data))
        {
            $model->setData($data);
        }

        Mage::register('autofill_data', $model);

        $this->_initAction();

        $this->_title('New Autofill-Set');

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->_addContent($this->getLayout()->createBlock('autofill_product/adminhtml_autofill_formfill'));

        $this->_addLeft($this->getLayout()->createBlock('autofill_product/adminhtml_autofill_formfill_tabs'));

        $this->renderLayout();

    }
    public function saveAction()
    {
        $nameAutoFill =  Mage::getModel('core/session')->getAutofillName();

        $setId =  Mage::getModel('core/session')->getAttrSetId();

        $attrSetName = Mage::getModel('eav/entity_attribute_set')->load($setId);

        $data = $this->getRequest()->getPost();

        $model = Mage::getModel('autofill_product/autofill');

        foreach($data['product'] as $k=>$v)
        {
            $attributeId = Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', $k);

            $data = array(
                'name' => $nameAutoFill,
                'attribute_set_id'=> $setId,
                'attribute_id'=>$attributeId,
                'attribute_set_name' =>$attrSetName['attribute_set_name'],
                'value' =>$v
            );
            $setModel = $model->setData($data);
            try{
                $setModel->save();
            }
            catch (Exception $e)
            {
                Mage::logException($e);
            }
        }
        if($setModel->save())
        {
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('autofill_product')
                ->__('AutoFill-Set was successfully saved.'));
        }
        Mage::getModel('core/session')->unsAutofillName();
        Mage::getModel('core/session')->unsAttrSetId();
        $this->_redirect('*/*/');
    }

    protected function _initProduct()
    {
        $this->_title($this->__('Catalog'))
            ->_title($this->__('Manage Products'));

        $productId  = (int) $this->getRequest()->getParam('id');
        $product    = Mage::getModel('catalog/product')
            ->setStoreId($this->getRequest()->getParam('store', 0));

        if (!$productId) {
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $product->setAttributeSetId($setId);
            }

            if ($typeId = $this->getRequest()->getParam('type')) {
                $product->setTypeId($typeId);
            }
        }

        $product->setData('_edit_mode', true);
        if ($productId) {
            try {
                $product->load($productId);
            } catch (Exception $e) {
                $product->setTypeId(Mage_Catalog_Model_Product_Type::DEFAULT_TYPE);
                Mage::logException($e);
            }
        }

        $attributes = $this->getRequest()->getParam('attributes');
        if ($attributes && $product->isConfigurable() &&
            (!$productId || !$product->getTypeInstance()->getUsedProductAttributeIds())) {
            $product->getTypeInstance()->setUsedProductAttributeIds(
                explode(",", base64_decode(urldecode($attributes)))
            );
        }

        // Required attributes of simple product for configurable creation
        if ($this->getRequest()->getParam('popup')
            && $requiredAttributes = $this->getRequest()->getParam('required')) {
            $requiredAttributes = explode(",", $requiredAttributes);
            foreach ($product->getAttributes() as $attribute) {
                if (in_array($attribute->getId(), $requiredAttributes)) {
                    $attribute->setIsRequired(1);
                }
            }
        }

        if ($this->getRequest()->getParam('popup')
            && $this->getRequest()->getParam('product')
            && !is_array($this->getRequest()->getParam('product'))
            && $this->getRequest()->getParam('id', false) === false) {

            $configProduct = Mage::getModel('catalog/product')
                ->setStoreId(0)
                ->load($this->getRequest()->getParam('product'))
                ->setTypeId($this->getRequest()->getParam('type'));

            /* @var $configProduct Mage_Catalog_Model_Product */
            $data = array();
            foreach ($configProduct->getTypeInstance()->getEditableAttributes() as $attribute) {

                /* @var $attribute Mage_Catalog_Model_Resource_Eav_Attribute */
                if(!$attribute->getIsUnique()
                    && $attribute->getFrontend()->getInputType()!='gallery'
                    && $attribute->getAttributeCode() != 'required_options'
                    && $attribute->getAttributeCode() != 'has_options'
                    && $attribute->getAttributeCode() != $configProduct->getIdFieldName()) {
                    $data[$attribute->getAttributeCode()] = $configProduct->getData($attribute->getAttributeCode());
                }
            }

            $product->addData($data)
                ->setWebsiteIds($configProduct->getWebsiteIds());
        }

        Mage::register('product', $product);
        Mage::register('current_product', $product);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $product;
    }

}