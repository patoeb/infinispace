<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Infinispace\Customer\Block\Account\Dashboard;

use Magento\Framework\View\Element\Template;

/**
 * Dashboard Customer Info
 *
 * @api
 * @since 100.0.2
 */
class Info extends \Magento\Customer\Block\Account\Dashboard\Info
{
    public function getHotspotUsername()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerRepository = $objectManager->get('Magento\Customer\Api\CustomerRepositoryInterface');
        $customer = $customerRepository->getById($this->currentCustomer->getCustomerId());

        return $customer->getCustomAttribute('hotspot_username')->getValue();
    }

    public function getHotspotPassword()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerRepository = $objectManager->get('Magento\Customer\Api\CustomerRepositoryInterface');
        $customer = $customerRepository->getById($this->currentCustomer->getCustomerId());

        return $customer->getCustomAttribute('hotspot_password')->getValue();
    }
}
