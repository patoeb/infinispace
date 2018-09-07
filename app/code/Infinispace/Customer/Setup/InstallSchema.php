<?php 
namespace Infinispace\Customer\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $setup->getConnection()->newTable(
            $setup->getTable('infinispace_customer')
        )->addColumn(
            'customer_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Customer ID'
        )->addColumn(
            'hotspot_username',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Hotspot Username'
        )->addColumn(
            'hotspot_password',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Hotspot Password'
        )->addColumn(
            'mac_address',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Mac Address'
        )->addColumn(
            'type',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'Subscription Type'
        )->addColumn(
            'sub_days',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            0,
            ['nullable' => true],
            'Subscription Day'
        )->addColumn(
            'active',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            0,
            ['nullable' => true],
            'Membership Status'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT,
            ['nullable' => true],
            'Created At'
        )->addColumn(
            'expired_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            NULL,
            ['nullable' => true],
            'Expired At'
        )->setComment(
            'Membership and Customer Hotspot Mapping'
        );

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }

}
