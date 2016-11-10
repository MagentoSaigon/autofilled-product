<?php
/**
 * Created by Phong Phan.
 * Copyright Mercuriel - 2016
 * Date: 05/11/2016
 * Time: 23:44
 */

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('autofill_product/autofill_info'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')

    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'AutoFill Name')

    ->addColumn('attribute_set_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Attribute Set Name');

$installer->getConnection()->createTable($table);

$table = $installer->getConnection()

    ->newTable($installer->getTable('autofill_product/autofill_product'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')

    ->addColumn('attribute_set_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Attribute Set Id')

    ->addColumn('attribute_group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Attribute Group Id')

    ->addColumn('attribute_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Attribute Code')

    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Attribute Id')

    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'Value')

    ->addColumn('info_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'AutoFill Info Id')

    ->addForeignKey(
        $installer->getFkName('autofill_product/autofill_product', 'info_id', 'autofill_product/autofill_info','id'),
        'info_id',
        $installer->getTable('autofill_product/autofill_info'),
        'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    );
$installer->getConnection()->createTable($table);




$installer->endSetup();