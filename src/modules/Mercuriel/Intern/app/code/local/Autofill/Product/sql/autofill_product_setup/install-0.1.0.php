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
    ->newTable($installer->getTable('autofill_product/autofill_product'))


    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Id')

    ->addColumn('attribut_set_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Attribute Set Id')

    ->addColumn('attribute_group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Attribute Group Id')

    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Attribute Id')

    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
    ), 'Value');

$installer->getConnection()->createTable($table);

$installer->endSetup();