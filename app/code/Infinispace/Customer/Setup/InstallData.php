<?php


namespace Infinispace\Customer\Setup;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;

class InstallData implements InstallDataInterface
{

    private $customerSetupFactory;

    /**
     * Constructor
     *
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'hotspot_username', [
            'type' => 'varchar',
            'label' => 'Hotspot Username',
            'input' => 'text',
            'source' => '',
            'required' => true,
            'visible' => true,
            'position' => 333,
            'system' => false,
            'backend' => ''
        ]);
        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'hotspot_username')
        ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'customer_account_create',
                'customer_account_edit'
            ]
        ]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'hotspot_password', [
            'type' => 'varchar',
            'label' => 'Hotspot Password',
            'input' => 'text',
            'source' => '',
            'required' => true,
            'visible' => true,
            'position' => 334,
            'system' => false,
            'backend' => ''
        ]);
        
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'hotspot_password')
        ->addData(['used_in_forms' => [
                'adminhtml_customer',
                'customer_account_create',
                'customer_account_edit'
            ]
        ]);
        $attribute->save();
    }
}
