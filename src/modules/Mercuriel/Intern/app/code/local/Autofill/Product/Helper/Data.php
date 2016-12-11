<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016 
 * Date: 04/11/2016
 * Time: 23:28
 */ 
class Autofill_Product_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function convertFrontendInput($obj)
    {
        $params = array(
            'weight'  =>    'text',
            'text'    =>    'text',
            'textarea'=>    'editor',
            'select'  =>    'select',
            'date'    =>    'text',
            'multiselect' =>'multiselect'
        );
        return $params[$obj];
    }
}