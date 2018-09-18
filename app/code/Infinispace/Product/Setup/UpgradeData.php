<?php


namespace Infinispace\Product\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class UpgradeData implements UpgradeDataInterface
{

    private $eavSetupFactory;

    /**
     * Constructor
     *
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        if (version_compare($context->getVersion(), "1.0.1", "<")) {
        
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'sub_type',
                [
                    'type' => 'int',
                    'backend' => '',
                    'frontend' => '',
                    'label' => 'Subscription Type',
                    'input' => 'select',
                    'class' => '',
                    'source' => '',
                    'global' => 1,
                    'visible' => true,
                    'required' => true,
                    'user_defined' => true,
                    'default' => null,
                    'searchable' => true,
                    'filterable' => true,
                    'comparable' => false,
                    'visible_on_front' => true,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'apply_to' => '',
                    'system' => 1,
                    'group' => 'General',
                    'option' => array('values' => array("timer","bypass"))
                ]
            );

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'sub_days',
                [
                    'type' => 'varchar',
                    'backend' => '',
                    'frontend' => '',
                    'label' => 'Subscription Days',
                    'input' => 'text',
                    'class' => '',
                    'source' => '',
                    'global' => 1,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => true,
                    'default' => null,
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => false,
                    'unique' => false,
                    'apply_to' => '',
                    'system' => 1,
                    'group' => 'General',
                    'option' => array('values' => array(""))
                ]
            );
        }
    }
}