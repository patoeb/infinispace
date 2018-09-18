<?php
 
namespace Infinispace\Customer\Model\ResourceModel;
 
use Magento\Framework\Model\ResourceModel\Db\AbstractDb; 

class Customer extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('infinispace_customer', 'id');
    }
}