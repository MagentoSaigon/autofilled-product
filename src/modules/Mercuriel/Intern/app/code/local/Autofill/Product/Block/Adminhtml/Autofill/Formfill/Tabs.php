<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 07/11/2016
 * Time: 14:29
 */
class Autofill_Product_Block_Adminhtml_Autofill_Formfill_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    protected $_attributeTabBlock = 'adminhtml/catalog_product_edit_tab_attributes';
    public function __construct(array $args)
    {
        parent::__construct();
        $this->setId('form_tab');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('autofill_product')->__('Infomation AutoFill-Set '));
    }
    public function _prepareLayout()
    {

        $setId = $this->getRequest()->getParam('set');

        if($setId)
        {
            $groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
                ->setAttributeSetFilter($setId)
                ->setSortOrder()
                ->load();

            foreach ($groupCollection as $group)
            {
                if($group->getAttributeGroupName()== "General")
                {
                    $attributes = Mage::getResourceModel('catalog/product_attribute_collection')
                        ->setAttributeGroupFilter($group->getId())
                        ->load();
                    $this->addTab('group_'.$group->getId(), array(

                        'label'     => Mage::helper('autofill_product')->__($group->getAttributeGroupName()),

                        'content'   => $this->_translateHtml($this->getLayout()->createBlock($this->getAttributeTabBlock(),
                            'adminhtml.catalog.product.edit.tab.attributes')->setGroup($group)
                            ->setGroupAttributes($attributes)
                            ->toHtml()),
                    ));
                }
            }
        }
        return parent::_prepareLayout();
    }

    public function getProduct()
    {
        if (!($this->getData('product') instanceof Mage_Catalog_Model_Product)) {
            $this->setData('product', Mage::registry('product'));
        }
        return $this->getData('product');
    }

    public function getAttributeTabBlock()
    {
        if (is_null(Mage::helper('adminhtml/catalog')->getAttributeTabBlock())) {
            return $this->_attributeTabBlock;
        }
        return Mage::helper('adminhtml/catalog')->getAttributeTabBlock();
    }

    public function setAttributeTabBlock($attributeTabBlock)
    {
        $this->_attributeTabBlock = $attributeTabBlock;
        return $this;
    }
    protected function _translateHtml($html)
    {
        Mage::getSingleton('core/translate_inline')->processResponseBody($html);
        return $html;
    }

}