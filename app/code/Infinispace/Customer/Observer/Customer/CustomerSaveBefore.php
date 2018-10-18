<?php

namespace Infinispace\Customer\Observer\Customer;

class CustomerSaveBefore implements \Magento\Framework\Event\ObserverInterface
{
    protected $_customerCollectionFactory;

    public function __construct(
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory
    ) {
        $this->_customerCollectionFactory = $customerCollectionFactory;
    }

    /**
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getCustomer();
        $customerCollection= $this->_customerCollectionFactory->create();
        $customerCollection->addAttribuTeToFilter('hotspot_username',$customer->getData('hotspot_username'));
        
        if ($customer->getId()) {   
            $customerCollection->addAttribuTeToFilter('entity_id',array('neq' => (int)$customer->getId()));   
        }   
        
        if($customerCollection->getSize() > 0){
            throw new \Magento\Framework\Exception\AlreadyExistsException(
                __('Hotspot Username Already Exists')
            );
        }
    }
}