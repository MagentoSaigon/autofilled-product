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
        $this->setTitle(Mage::helper('autofill_product')->__('Info AutoFill-Set '));
    }
    public function _beforeToHtml()
    {
        $setId = $this->getRequest()->getParam('set');

        if ($setId)
        {
            $groupCollection = Mage::getResourceModel('eav/entity_attribute_group_collection')
                ->setAttributeSetFilter($setId)
                ->setSortOrder()
                ->load();

            foreach ($groupCollection as $group) {

                $this->addTab('group_' . $group->getId(), array(
                    'label' => Mage::helper('catalog')->__($group->getAttributeGroupName()),
                    'content' => $this->_translateHtml($this->getLayout()->createBlock($this->getAttributeTabBlock(),
                        'adminhtml.catalog.product.edit.tab.attributes')->toHtml()),
                ));
            }
        }

        return parent::_beforeToHtml();
    }
    protected function _translateHtml($html)
    {
        Mage::getSingleton('core/translate_inline')->processResponseBody($html);
        return $html;
    }
    public function getAttributeTabBlock()
    {
        if (is_null(Mage::helper('adminhtml/catalog')->getAttributeTabBlock())) {
            return $this->_attributeTabBlock;
        }
        return Mage::helper('adminhtml/catalog')->getAttributeTabBlock();
    }
}