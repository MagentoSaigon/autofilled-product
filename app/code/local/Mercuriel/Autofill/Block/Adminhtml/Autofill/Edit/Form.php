<?php
class Mercuriel_Autofill_Block_Adminhtml_Autofill_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id', $this->getRequest()->getParam('id'))),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));
        $form->setUseContainer(true);

        $this->setForm($form);
        if(Mage::getSingleton('adminhtml/session')->getFormData()){
            Mage::getSingleton('adminhtml/session')->setFormData(null);
        }
        elseif(Mage::registry('autofill_data')){
            $data = Mage::registry('autofill_data')->getData();
        }
        if($data) {

            $fieldset = $form->addFieldset('autofill_group_form', array(
                'legend' => Mage::helper('mercuriel_autofill')->__('General Information')
            ));
            $entityType = Mage::getModel('catalog/product')->getResource()->getEntityType();
            $fieldset->addField('attribute_set_id', 'select', array(
                'label' => Mage::helper('catalog')->__('Attribute Set'),
                'title' => Mage::helper('catalog')->__('Attribute Set'),
                'name'  => 'attribute_set_id',
                'values'=> Mage::getResourceModel('eav/entity_attribute_set_collection')
                    ->setEntityTypeFilter($entityType->getId())
                    ->load()
                    ->toOptionArray(),
                'required'=> true
            ));
            $fieldset->addField('autofill_set_name', 'text', array(
                'label' => Mage::helper('mercuriel_autofill')->__('Autofill Set Name'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'autofill_set_name'
            ));
            $fieldset->addField('autofill_set_id', 'hidden', array(
                'name'  => 'autofill_set_id'
            ));

            $fieldset1 = $form->addFieldset('autofill_value', array(
                'legend' => Mage::helper('mercuriel_autofill')->__("Autofill Group Value")
            ));
            $autofillValues = Mage::getModel('mercuriel_autofill/autofillValue')->getCollection()
                ->addFieldToFilter('autofill_set_id', $data['autofill_set_id']);
            foreach($autofillValues as $autofillValue){
                $data[Mage::getModel('eav/entity_attribute')
                    ->load($autofillValue->getAttributeId())
                    ->getAttributeCode()] = $autofillValue['value'];
            }

            $attributes = Mage::helper('mercuriel_autofill')->getAttributeCollection($data['attribute_set_id']);


            // Get all the attribute which have the set id is attribute set id, group name is general
            foreach ($attributes as $autofillValue) {
                switch ($autofillValue['frontend_input']) {
                    case 'hidden':
                    case 'price':
                    case 'datetime':
                    case 'date':
                    case 'weight':
                    case '':
                        break;
//                    case 'boolean':
//                        $fieldset1->addField($autofillValue['attribute_code'], 'select', array(
//                            'label' => Mage::helper('mercuriel_autofill')->__($autofillValue['frontend_label']),
//                            'class' => '',
//                            'name' => $autofillValue['attribute_code'],
//                            'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray()
//                        ));
//
//                        break;
                    case 'select':
                        $a = array(
                            'label' => Mage::helper('mercuriel_autofill')->__($autofillValue['frontend_label']),
                            'class' => '',
                            'name' => $autofillValue['attribute_code']
                        );
                            $a['values'] =  Mage::getSingleton('eav/config')->getAttribute(Mage_Catalog_Model_Product::ENTITY, $autofillValue['attribute_code'])->getSource()->getAllOptions();
                        $fieldset1->addField($autofillValue['attribute_code'], 'select', $a);
                        break;
                    default:
                        $fieldset1->addField($autofillValue['attribute_code'], $autofillValue['frontend_input'], array(
                            'label' => Mage::helper('mercuriel_autofill')->__($autofillValue['frontend_label']),
                            'class' => '',
                            'name' => $autofillValue['attribute_code'],
                        ));
                }

            }

            $form->setValues($data);
        }
        else{
            $fieldset = $form->addFieldset('autofill_set_form', array(
                'legend' => Mage::helper('mercuriel_autofill')->__('General Information')
            ));
            $entityType = Mage::getModel('catalog/product')->getResource()->getEntityType() ;
            $fieldset->addField('attribute_set_id', 'select', array(
                'label' => Mage::helper('catalog')->__('Attribute Set'),
                'title' => Mage::helper('catalog')->__('Attribute Set'),
                'name'  => 'set',
                'value' => $entityType->getDefaultAttributeSetId(),
                'values'=> Mage::getResourceModel('eav/entity_attribute_set_collection')
                    ->setEntityTypeFilter($entityType->getId())
                    ->load()
                    ->toOptionArray(),
                'required'=> true
            ));
            $fieldset->addField('autofill_set_name', 'text', array(
                'label'     => Mage::helper('mercuriel_autofill')->__('Auto-fill Set Name'),
                'title'     => Mage::helper('mercuriel_autofill')->__('Auto-fill Set Name'),
                'name'      => 'autofill_set_name',
                'required'  => true
            ));

        }
        return parent::_prepareForm(); // TODO: Change the autogenerated stub
    }

}