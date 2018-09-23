<?php


namespace Infinispace\Customer\Api;

interface ActiveCustomerManagementInterface
{

    /**
     * GET for activeCustomer api
     * @param string $param
     * @return string
     */
    public function getActiveCustomer($param);
}
