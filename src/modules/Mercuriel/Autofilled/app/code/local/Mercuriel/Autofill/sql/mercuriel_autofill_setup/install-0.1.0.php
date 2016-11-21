<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/11/2016
 * Time: 5:50 PM
 */ 
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('mercuriel_autofill/att_set_default'))
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
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Attribute Id')
    ->addColumn('default_value', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Default Value')
    ->addColumn('autofill_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Autofill Id')
;
$installer->getConnection()->createTable($table);


$table = $installer->getConnection()
    ->newTable($installer->getTable('mercuriel_autofill/autofill'))
    ->addColumn('autofill_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Autofill Id')
    ->addColumn('autofill_value', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Autofill Value')
    ->addColumn('autofill_set_name', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Autofill Set Name')
;

$installer->getConnection()->createTable($table);

$installer->endSetup();