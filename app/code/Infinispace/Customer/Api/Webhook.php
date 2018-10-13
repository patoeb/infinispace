<?php


namespace Infinispace\Customer\Api;

interface Webhook
{

    /**
     * GET for processingCustomer api
     * @param string $active
     * @return string
     */
    public function getProcessingCustomer($active);

    /**
     * SET Active Customer
     * @param string $username
     * @param string $value
     * @return string
     */
    public function setActiveCustomer($username,$value);

     /**
     * SET Status Customer
     * @param string $username
     * @param string $status
     * @return string
     */
    public function setStatusCustomer($username,$status);

     /**
     * SET Mac Address Customer
     * @param string $username
     * @param string $macAddress
     * @return string
     */
    public function setMacAddress($username,$macAddress);

    /**
     * Remove Customer
     * @param string $username
     * @return string
     */
    public function removeCustomer($username);
}
