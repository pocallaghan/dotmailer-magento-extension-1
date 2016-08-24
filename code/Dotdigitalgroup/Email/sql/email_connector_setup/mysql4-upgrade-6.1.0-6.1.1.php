<?php

/** @var Mage_Eav_Model_Entity_Setup $installer */

$installer = $this;
$installer->startSetup();

/**
 * modify email_campaign table
 */
$campaignTable = $installer->getTable('ddg_automation/campaign');

//add columns
$installer->getConnection()->addColumn(
    $campaignTable, 'send_id', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => false,
        'default' => '',
        'comment' => 'Campaign Send Id'
    )
);
$installer->getConnection()->addColumn(
    $campaignTable, 'send_status', array(
        'type' => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'nullable' => false,
        'default' => 0,
        'comment' => 'Send Status'
    )
);

//update table with historical send values
$select = $installer->getConnection()->select();

//join
$select->joinLeft(
    array('oc' => $campaignTable),
    "oc.id = nc.id",
    array(
        'send_status' => new Zend_Db_Expr(Dotdigitalgroup_Email_Model_Campaign::SENT)
    )
)
    ->where('oc.is_sent =?', 1);

//update query from select
$updateSql = $select->crossUpdateFromSelect(array('nc' => $campaignTable));

//run query
$installer->getConnection()->query($updateSql);

//remove column
$installer->getConnection()->dropColumn($campaignTable, 'is_sent');

$installer->endSetup();