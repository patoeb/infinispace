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
     * @return string
     */
    public function setActiveCustomer($username);
}
