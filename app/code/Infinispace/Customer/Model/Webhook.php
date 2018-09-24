<?php


namespace Infinispace\Customer\Model;

class Webhook
{
    protected $_infiniCustomer;

    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Infinispace\Customer\Model\CustomerFactory $infiniCustomerFactory
    )
    {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->_infiniCustomer = $infiniCustomerFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getProcessingCustomer($active)
    {
        $collection = $this->_infiniCustomer->create()->getCollection();
        $collection = $collection->addFieldToFilter('active',array('eq' => $active));
        
        return $collection->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function setActiveCustomer($username)
    {
        date_default_timezone_set('Asia/Jakarta');
        $collection = $this->_infiniCustomer->create()->getCollection();
        $collection = $collection->addFieldToFilter('hotspot_username',array('eq' => $username));
        foreach($collection as $key => $customer) {
            $hours = $customer['sub_hours'];
            $days = $customer['sub_days'];
            $createdAt = date("Y-m-d H:i:s");
            $expiredAt = date("Y-m-d H:i:s",strtotime($createdAt .'+'.$days.' days'.'+'.$hours.' hours'));
            $customer->setActive(TRUE);
            $customer->setCreatedAt($createdAt);
            $customer->setExpiredAt($expiredAt);
            $customer->save();
        }        
    }
}
