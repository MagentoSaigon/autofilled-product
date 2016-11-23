<?php

$installer = $this;
$this->startSetup();
//$autofillSetTableName = $this->getTable('mercuriel_autofill/autofill_set');
if($installer->getConnection()->isTableExists('autofill_set')) {
    $this->getConnection()->dropTable('autofill_set');
}

$autofillSetTable = $installer->getConnection()
    ->newTable($installer->getTable('mercuriel_autofill/autofill_set'))
    ->addColumn('autofill_set_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'primary'   =>  true,
        'nullable'  =>  false,
        'unsigned'  =>  true,
        'identity'  =>  true,
    ), 'Id')
    ->addColumn('attribute_set_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'Attribute Set Id')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable' => false
    ), 'Autofill Set Name')
    ->addForeignKey($this->getFkName('mercuriel_autofill/autofill_set', 'attribute_set_id', 'eav_attribute_set', 'attribute_set_id'),
       'attribute_set_id', 'eav_attribute_set', 'attribute_set_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
$installer->getConnection()->createTable($autofillSetTable);

$autofillValueTableName = $this->getTable('mercuriel_autofill/autofill_value');
if($installer->getConnection()->isTableExists($autofillValueTableName)) {
    $this->run('DROP TABLE autofill_value');
}
$autofillValueTable = $installer->getConnection()
    ->newTable($autofillValueTableName)
    ->addColumn('autofill_value_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  =>  true,
        'primary'   =>  true,
        'nullable'  =>  false
    ), 'Autofill Value Id')
    ->addColumn('autofill_set_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  =>  false
    ), 'Autofill Set Id')
    ->addColumn('attribute_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  =>  false
    ), 'Attribute Id')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable'  =>  false
    ))
    ->addForeignKey($this->getFkName('mercuriel_autofill/autofill_value', 'autofill_set_id', 'mercuriel_autofill/autofill_set', 'autofill_set_id'),
        'autofill_set_id', 'autofill_set', 'autofill_set_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE )
    ->addForeignKey($this->getFkName('mercuriel_autofill/autofill_value', 'attribute_id', 'eav_attribute', 'attribute_id'),
        'attribute_id', 'eav_attribute', 'attribute_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE )
    ->addIndex($this->getConnection()->getIndexName('autofill_value', array('autofill_set_id','attribute_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('autofill_set_id','attribute_id'),
        array('type'=> Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE));
$installer->getConnection()->createTable($autofillValueTable);
$installer->endSetup();