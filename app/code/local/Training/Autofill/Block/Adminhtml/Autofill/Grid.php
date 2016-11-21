<?php

/**
 * Created by PhpStorm.
 * User: tuan
 * Date: 20/11/2016
 * Time: 22:37
 */
class Training_Autofill_Block_Adminhtml_Autofill_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('grid_id');
        $this->setDefaultSort('group_set_id');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('training_autofill/group')->getCollection();

        $collection->getSelect()->join(Mage::getConfig()
            ->getTablePrefix().'eav_attribute_set', 
            'main_table.attribute_set_id ='.Mage::getConfig()->getTablePrefix().'
            eav_attribute_set.attribute_set_id',array('attribute_set_name'));
        
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('group_set_id',
            array(
                'header' => $this->__('ID'),
                'align' => 'right',
                'width' => '100px',
                'index' => 'group_set_id'
            )
        );
        $this->addColumn('name',
            array(
                'header' => $this->__('Name'),
                'align' => 'left',
                'width' => '100px',
                'index' => 'name'
            )
        );

      $this->addColumn('attribute_set_name',
            array(
                'header' => $this->__('Attribute Set Name'),
                'align' => 'left',
                'width' => '100px',
                'index' => 'attribute_set_name'
            )
        );

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('group_set_id');
        $this->getMassactionBlock()->setFormFieldName('delete_id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('training_autofill')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('training_autofill')->__('Are you sure?')
        ));
        return $this;
    }
}
