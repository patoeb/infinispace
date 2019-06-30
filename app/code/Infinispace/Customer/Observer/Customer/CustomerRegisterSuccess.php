<?php

namespace Infinispace\Customer\Observer\Customer;

class CustomerRegisterSuccess implements \Magento\Framework\Event\ObserverInterface
{
    protected $customerCollectionFactory;
    protected $addressDataFactory;
    protected $addressRepository;

    public function __construct(
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Magento\Customer\Api\Data\AddressInterfaceFactory $addressDataFactory
    ) {
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->addressRepository = $addressRepository;
        $this->addressDataFactory = $addressDataFactory;
    }

    /**
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();

        $customerId = $customer->getId();
        $firstName = "Infinispace";
        $lastName = "Membership";
        $countryId = "ID";
        $regionId = null;
        $regionName = null;
        $city = "Sleman";
        $postcode = "55291";
        $street = array('street' => 'Jl. Kabupaten');
        $telephone = "085743730807";

        $address = $this->addressDataFactory->create();
        $address->setFirstname($firstName)
            ->setLastname($lastName)
            ->setCountryId($countryId)
            ->setRegionId($regionId)
            ->setRegion($regionName)
            ->setCity($city)
            ->setPostcode($postcode)
            ->setCustomerId($customerId)
            ->setStreet($street)
            ->setTelephone($telephone)
            ->setIsDefaultBilling('1')
            ->setIsDefaultShipping('1');

        $this->addressRepository->save($address);
    }
}