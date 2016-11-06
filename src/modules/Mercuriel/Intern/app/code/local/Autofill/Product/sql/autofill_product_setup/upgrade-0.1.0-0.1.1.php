<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 06/11/2016
 * Time: 08:25
 */
$installer = $this;

$installer->startSetup();

$installer->getConnection()
    ->addColumn($installer->getTable('autofill_product/autofill_product'),'name',
        array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable'  => false,
        'length'    => 255,
        'after'     => 'id',
        'comment'   => 'Name'
    ));

$installer->getConnection()
    ->addColumn($installer->getTable('autofill_product/autofill_product'),'attribute_set_name', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable'  => false,
        'length'    => 255,
        'after'     => 'name',
        'comment'   => 'Attribute Set Name'
    ));

$installer->endSetup();