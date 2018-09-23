<?php

namespace Infinispace\Integration\Observer\Sales;

class OrderInvoicePay implements \Magento\Framework\Event\ObserverInterface
{
    protected $_infiniCustomer;
    protected $_productRepository;

    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Infinispace\Customer\Model\CustomerFactory $infiniCustomerFactory
      ){
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->_productRepository = $productRepository;
        $this->_infiniCustomer = $infiniCustomerFactory;
      }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/' . 'customer-list.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $invoice = $observer->getEvent()->getInvoice();
        $order = $invoice->getOrder();
        $orderItems = $order->getAllItems();

        foreach($orderItems as $item){
            $productId = $item->getProductId();
        }
        
        $customer = $this->_customerRepositoryInterface->getById($order->getCustomerId());
        $product = $this->_productRepository->getById($productId);

        $infiniCustomer = $this->_infiniCustomer->create();
        $infiniCustomer->setCustomerId($order->getCustomerId());
        $infiniCustomer->setHotspotUsername($customer->getCustomAttribute('hotspot_username')->getValue());
        $infiniCustomer->setHotspotPassword($customer->getCustomAttribute('hotspot_password')->getValue());
        $subType = $product->getResource()->getAttribute('sub_type')->getFrontend()->getValue($product);
        $infiniCustomer->setSubType($subType);
        if($subType === 'timer'){
            $infiniCustomer->setSubHours($product->getSubHours());
            $infiniCustomer->setSubDays(0);
        }else{
            $infiniCustomer->setSubDays($product->getSubDays());
            $infiniCustomer->setSubHours(0);
        }
        $infiniCustomer->setActive(FALSE);
        $infiniCustomer->save();
        
    }
}
