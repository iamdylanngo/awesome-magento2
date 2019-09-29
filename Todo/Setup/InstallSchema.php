<?php

namespace Jundat\Todo\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public static $TABLE_NAME = 'jundat_todo';

    /**
     * Function install
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable(self::$TABLE_NAME)
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'nullable' => false,
                'primary' => true,
                'unsigned' => true
            ],
            'id'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            [],
            'Title'
        )->addColumn(
            'description',
            Table::TYPE_TEXT,
            500,
            [],
            'Description'
        )->addColumn(
            'deadline',
            Table::TYPE_TIMESTAMP,
            null,
            [ 'nullable' => true ],
            'Deadline'
        )->addColumn(
            'completed',
            Table::TYPE_BOOLEAN,
            null,
            [ 'nullable' => false, 'default' => false ],
            'Completed'
        )->addColumn(
            'create_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => Table::TIMESTAMP_INIT
            ],
            'Create At'
        )->addColumn(
            'update_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => false,
                'default' => Table::TIMESTAMP_INIT_UPDATE
            ],
            'Update At'
        );

        $installer->getConnection()->createTable($table);

        $installer->getConnection()->addIndex(
            $installer->getTable(self::$TABLE_NAME),
            $setup->getIdxName(
                $installer->getTable(self::$TABLE_NAME),
                ['title', 'description'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['title', 'description'],
            AdapterInterface::INDEX_TYPE_FULLTEXT
        );
        $installer->getConnection()->addIndex(
            $installer->getTable(self::$TABLE_NAME),
            $setup->getIdxName(
                $installer->getTable(self::$TABLE_NAME),
                ['deadline', 'completed'],
                AdapterInterface::INDEX_TYPE_INDEX
            ),
            ['deadline', 'completed'],
            AdapterInterface::INDEX_TYPE_INDEX
        );
        $installer->endSetup();
    }
}
