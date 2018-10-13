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
    public function getProcessingCustomer($status)
    {
        $collection = $this->_infiniCustomer->create()->getCollection();
        $collection = $collection->addFieldToFilter('active',array('eq' => $status));
        
        return $collection->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function setActiveCustomer($username,$value)
    {
        date_default_timezone_set('Asia/Jakarta');

        $collection = $this->_infiniCustomer->create()->getCollection();
        $collection = $collection->addFieldToFilter('hotspot_username',array('eq' => $username));
        foreach($collection as $key => $customer) {
            $customer->setActive($value);
            $customer->save();
        }
        return 'success';       
    }

    /**
     * {@inheritdoc}
     */
    public function setStatusCustomer($username,$status)
    {
        date_default_timezone_set('Asia/Jakarta');

        $collection = $this->_infiniCustomer->create()->getCollection();
        $collection = $collection->addFieldToFilter('hotspot_username',array('eq' => $username));
        foreach($collection as $key => $customer) {
            $customer->setStatus($status);
            $customer->save();
            return 'success';
        }        
    }

    /**
     * {@inheritdoc}
     */
    public function setMacAddress($username, $macAddress)
    {
        date_default_timezone_set('Asia/Jakarta');

        $collection = $this->_infiniCustomer->create()->getCollection();
        $collection = $collection->addFieldToFilter('hotspot_username',array('eq' => $username));
        foreach($collection as $key => $customer) {
            $hours = $customer['sub_hours'];
            $days = $customer['sub_days'];
            $createdAt = date("Y-m-d H:i:s");
            if($days > 0 && $hours > 0){
                $expiredAt = date("Y-m-d H:i:s",strtotime($createdAt .'+'.$days.' days'.'+'.$hours.' hours'));
            }elseif($days > 0 && $hours == 0){
                $expiredAt = date("Y-m-d H:i:s",strtotime($createdAt .'+'.$days.' day midnight'));
            }
            $customer->setMacAddress($macAddress);
            $customer->setCreatedAt($createdAt);
            $customer->setExpiredAt($expiredAt);
            $customer->save();
            return 'success';
        }
    }

    public function removeCustomer($username){
        $collection = $this->_infiniCustomer->create()->getCollection();
        $collection = $collection->addFieldToFilter('hotspot_username',array('eq' => $username));
        foreach($collection as $key => $customer) {
            $customer->delete();
        }
        return 'success';
    }
}
