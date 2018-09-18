<?php
 
namespace Infinispace\Customer\Model;
 
use Magento\Framework\Model\AbstractModel;
 
class Customer extends AbstractModel
{
    protected $_eventPrefix = 'infinispace_customer';

    /**
     * Define resource model
     */
    protected function _construct()
    {
        // $this->_init('Infinispace\Customer\Model\ResourceModel\Customer');
        $this->_init(\Infinispace\Customer\Model\ResourceModel\Customer::class);
    }

     /**
     * Get customer_id
     * @return string
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Infinispace\Customer\Api\Data\CustomerInterface
     */
    public function setCustomerId($customerId)
    {
        return $this->setData('customer_id', $customerId);
    }

    /**
     * Get hotspot_username
     * @return string
     */
    public function getHotspotUsername()
    {
        return $this->getData(self::HOTSPOT_USERNAME);
    }

    /**
     * Set hotspot_username
     * @param string $hotspotUsername
     * @return \Infinispace\Customer\Api\Data\CustomerInterface
     */
    public function setHotspotUsername($hotspotUsername)
    {
        return $this->setData('hotspot_username', $hotspotUsername);
    }

    /**
     * Get hotspot_password
     * @return string
     */
    public function getHotspotPassword()
    {
        return $this->getData(self::HOTSPOT_PASSWORD);
    }

    /**
     * Set hotspot_password
     * @param string $hotspotPassword
     * @return \Infinispace\Customer\Api\Data\CustomerInterface
     */
    public function setHotspotPassword($hotspotPassword)
    {
        return $this->setData('hotspot_password', $hotspotPassword);
    }
}