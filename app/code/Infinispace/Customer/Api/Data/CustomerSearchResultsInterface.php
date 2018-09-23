<?php


namespace Infinispace\Customer\Api\Data;

interface CustomerSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Customer list.
     * @return \Infinispace\Customer\Api\Data\CustomerInterface[]
     */
    public function getItems();

    /**
     * Set customer_id list.
     * @param \Infinispace\Customer\Api\Data\CustomerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}