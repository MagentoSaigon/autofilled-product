<?php
/**
 * Created by PhpStorm.
 * User: tuan
 * Date: 14/11/2016
 * Time: 20:21
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$tableGroup = $installer->getConnection()
    ->newTable($installer->getTable('training_autofill/group_set'))
    ->addColumn('group_set_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'primary' => true,
        'nullable' => false,
        'unsigned' => true,
        'identity' => true,
    ), 'Id')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable' => false,
        'unsigned' => true,
    ), 'Name')
    ->addColumn('attribute_set_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
        'unsigned' => true,
    ), 'Attribute Set Id');
$installer->getConnection()->createTable($tableGroup);

$tableValue = $installer->getConnection()
    ->newTable($installer->getTable('training_autofill/auto_value'))
    ->addColumn('auto_value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'primary' => true,
        'nullable' => false,
        'unsigned' => true,
        'identity' => true,
    ), 'Value Id')
    ->addColumn('attribute_set_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable' => false,
        'unsigned' => true,
    ), 'Attribute Set Id')
    ->addColumn('att_set_auto_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable' => false,
        'unsigned' => true,
    ), 'Attribute Set Auto Name')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable' => false,
        'unsigned' => true,
    ), 'Value')
    ->addForeignKey($installer->getFkName(
        'training_autofill/auto_value', 'attribute_set_id',
        'training_autofill/group_set', 'attribute_set_id'),
        'attribute_set_id',
        'training_autofill/group_set',
        'attribute_set_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    );
$installer->getConnection()->createTable($tableValue);

$installer->endSetup();