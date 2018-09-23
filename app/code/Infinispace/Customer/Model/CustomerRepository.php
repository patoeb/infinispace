<?php


namespace Infinispace\Customer\Model;

use Infinispace\Customer\Api\Data\CustomerSearchResultsInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Infinispace\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Infinispace\Customer\Api\CustomerRepositoryInterface;
use Infinispace\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Framework\Api\SortOrder;
use Infinispace\Customer\Model\ResourceModel\Customer as ResourceCustomer;
use Magento\Framework\Exception\CouldNotSaveException;

class CustomerRepository implements CustomerRepositoryInterface
{

    protected $dataObjectHelper;

    protected $customerFactory;

    protected $customerCollectionFactory;

    protected $resource;

    protected $searchResultsFactory;

    protected $dataCustomerFactory;

    protected $dataObjectProcessor;

    private $storeManager;

    /**
     * @param ResourceCustomer $resource
     * @param CustomerFactory $customerFactory
     * @param CustomerInterfaceFactory $dataCustomerFactory
     * @param CustomerCollectionFactory $customerCollectionFactory
     * @param CustomerSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceCustomer $resource,
        CustomerFactory $customerFactory,
        CustomerInterfaceFactory $dataCustomerFactory,
        CustomerCollectionFactory $customerCollectionFactory,
        CustomerSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->customerFactory = $customerFactory;
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataCustomerFactory = $dataCustomerFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Infinispace\Customer\Api\Data\CustomerInterface $customer
    ) {
        /* if (empty($customer->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $customer->setStoreId($storeId);
        } */
        try {
            $this->resource->save($customer);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the customer: %1',
                $exception->getMessage()
            ));
        }
        return $customer;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($customerId)
    {
        $customer = $this->customerFactory->create();
        $this->resource->load($customer, $customerId);
        if (!$customer->getId()) {
            throw new NoSuchEntityException(__('Customer with id "%1" does not exist.', $customerId));
        }
        return $customer;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->customerCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $fields[] = $filter->getField();
                $condition = $filter->getConditionType() ?: 'eq';
                $conditions[] = [$condition => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Infinispace\Customer\Api\Data\CustomerInterface $customer
    ) {
        try {
            $this->resource->delete($customer);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Customer: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($customerId)
    {
        return $this->delete($this->getById($customerId));
    }
}