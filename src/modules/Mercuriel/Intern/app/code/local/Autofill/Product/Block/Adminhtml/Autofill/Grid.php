<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 24/11/2016
 * Time: 13:50
 */
class Autofill_Product_Block_Adminhtml_Autofill_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('autofillId');

        $this->setDefaultSort('id');

        $this->setDefaultDir('DESC');

        $this->setSaveParametersInSession(true);
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('autofill_product/info')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
                'header' => Mage::helper('autofill_product')->__('Id'),
                'width' => 50,
                'index' => 'id',
                'sortable' => false,
            )
        );
        $this->addColumn('name_info', array(
                'header' => Mage::helper('autofill_product')->__('Name Autofill-Set'),
                'width' => 50,
                'index' => 'name_info',
                'sortable' => false,
            )
        );
        $this->addColumn('attribute_set_name', array(
                'header' => Mage::helper('autofill_product')->__('Attr.Set Name'),
                'width' => 50,
                'index' => 'attribute_set_name',
                'sortable' => false,
            )
        );
        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    protected function _prepareMassaction(){
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('autofill');
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('autofill_product')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('autofill_product')->__('Are you sure?')
        ));
        return $this;
    }
}