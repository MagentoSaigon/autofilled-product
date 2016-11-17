<?php
class Mercuriel_Autofilled_Block_Adminhtml_Autofill_Grid extends Mage_Adminhtml_Block_Widget_Grid{
    public function __construct()
    {
        parent::__construct();
        $this->setId('autofill_id');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('mercuriel_autofilled/attribute')->getCollection();
        $collection->getSelect()->group("autofill_set_name");
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id',array(
            'header' => Mage::helper('mercuriel_autofilled')->__('Id'),
            'width' => 50,
            'index' => 'id',
            'sortable' => false,
        ));

        $this->addColumn('name',array(
            'header' => Mage::helper('mercuriel_autofilled')->__('Name'),
            'width' => 50,
            'index' => 'id',
            'sortable' => false,
        ));

        $this->addColumn('attribute_set_name',array(
            'header' => Mage::helper('mercuriel_autofilled')->__('Attribute Set Name'),
            'width' => 50,
            'index' => 'id',
            'sortable' => false,
        ));

        return parent::_prepareColumns();
    }
}