<?php
class Mercuriel_Autofill_Block_Adminhtml_Autofill_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
    public function __construct(){
        parent::__construct();
        $this->setId('autofill_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('mercuriel_autofill')->__('Autofill Information'));
    }

    protected function _beforeToHtml(){
        $this->addTab('form_section', array(
            'label'  => Mage::helper('mercuriel_autofill')->__('Attribute Set Information'),
            'title'  => Mage::helper('mercuriel_autofill')->__('Attribute Set Information'),
            'content'    => $this->getLayout()->createBlock('mercuriel_autofill/adminhtml_autofill_edit_tabs_form')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
}