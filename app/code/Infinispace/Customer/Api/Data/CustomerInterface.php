<?php


namespace Infinispace\Customer\Api\Data;

interface CustomerInterface
{

    const HOTSPOT_PASSWORD = 'hotspot_password';
    const CUSTOMER_ID = 'customer_id';
    const HOTSPOT_USERNAME = 'hotspot_username';

    /**
     * Get customer_id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     * @param string $customerId
     * @return \Infinispace\Customer\Api\Data\CustomerInterface
     */
    public function setCustomerId($customerId);

    /**
     * Get hotspot_username
     * @return string|null
     */
    public function getHotspotUsername();

    /**
     * Set hotspot_username
     * @param string $hotspotUsername
     * @return \Infinispace\Customer\Api\Data\CustomerInterface
     */
    public function setHotspotUsername($hotspotUsername);

    /**
     * Get hotspot_password
     * @return string|null
     */
    public function getHotspotPassword();

    /**
     * Set hotspot_password
     * @param string $hotspotPassword
     * @return \Infinispace\Customer\Api\Data\CustomerInterface
     */
    public function setHotspotPassword($hotspotPassword);
}