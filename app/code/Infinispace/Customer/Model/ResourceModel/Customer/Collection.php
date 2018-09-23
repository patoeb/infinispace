<?php
 
namespace Infinispace\Customer\Model\ResourceModel\Customer;
 
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
 
class Collection extends AbstractCollection
{
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Infinispace\Customer\Model\Customer',
            'Infinispace\Customer\Model\ResourceModel\Customer'
        );
    }
}