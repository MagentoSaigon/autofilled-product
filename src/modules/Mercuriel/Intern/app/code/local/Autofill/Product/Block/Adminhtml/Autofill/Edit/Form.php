<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 06/11/2016
 * Time: 10:04
 */
class Autofill_Product_Block_Adminhtml_Autofill_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );
        $form->setUseContainer(true);


        $this->setForm($form);

        $form->setHtmlIdPrefix('autofill_');

        return parent::_prepareForm();
    }
}