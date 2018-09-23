<?php


namespace Infinispace\Customer\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface CustomerRepositoryInterface
{

    /**
     * Save Customer
     * @param \Infinispace\Customer\Api\Data\CustomerInterface $customer
     * @return \Infinispace\Customer\Api\Data\CustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Infinispace\Customer\Api\Data\CustomerInterface $customer
    );

    /**
     * Retrieve Customer
     * @param string $customerId
     * @return \Infinispace\Customer\Api\Data\CustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($customerId);

    /**
     * Retrieve Customer matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Infinispace\Customer\Api\Data\CustomerSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Customer
     * @param \Infinispace\Customer\Api\Data\CustomerInterface $customer
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Infinispace\Customer\Api\Data\CustomerInterface $customer
    );

    /**
     * Delete Customer by ID
     * @param string $customerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($customerId);
}