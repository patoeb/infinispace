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
        date_default_timezone_set('Asia/Jakarta');

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/' . 'order-observer.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $today = date("Y-m-d H:i:s");
        $invoice = $observer->getEvent()->getInvoice();
        $order = $invoice->getOrder();
        $orderItems = $order->getAllItems();

        $totalHours = 0;
        $totalDays = 0;
        $orderHours = 0;
        $orderDays = 0;
        $subType = NULL;
        $subFlag = FALSE;

        foreach($orderItems as $item){
            $productId = $item->getProductId();
            $product = $this->_productRepository->getById($productId);
            if($product->getTypeId() == 'virtual'){
                $subFlag = TRUE;
                $orderHours = $product->getSubHours() * $item->getQtyOrdered();
                $orderDays = $product->getSubDays() * $item->getQtyOrdered();
                $totalHours = $totalHours + $orderHours;
                $totalDays = $totalDays + $orderDays;
            }
        }

        // if($totalDays >= 1) {
        //     $subType = 'bypass';
        //     $totalHours = 0;
        // } elseif($totalHours > 0 && $totalDays == 0){
        //     $subType = 'timer';
        // }

        $subType = 'bypass';

        $customer = $this->_customerRepositoryInterface->getById($order->getCustomerId());
        $infiniCustomer = $this->_infiniCustomer->create();
        $collection = $infiniCustomer->getCollection();
        $collection = $collection->addFieldToFilter('customer_id',array('eq' => $order->getCustomerId()));

        if(count($collection->getData()) > 0){
            foreach($collection as $key => $customer) {
                $currentDays = $customer->getSubDays();
                $currentHours = $customer->getSubHours();
                $subcribtionType = $customer->getSubType();

                // Upgrade half ke full day
                if($currentHours == 4 && $currentDays == 0 && $totalDays == 1){ 
                    $totalHours = 0;
                    $totalDays = $totalDays + $currentDays;
                    $customer->setExpiredAt(date("Y-m-d H:i:s",strtotime($customer->getExpiredAt() .'+'.$totalDays.' day midnight')));
                }else{
                    $totalDays = $totalDays + $currentDays;
                    $totalHours = $totalHours + $currentHours;

                    $customer->setExpiredAt(date("Y-m-d H:i:s",strtotime($customer->getExpiredAt()." + {$orderDays} days")));
                    $customer->setExpiredAt(date("Y-m-d H:i:s",strtotime($customer->getExpiredAt()." + {$orderHours} hours")));
                }

                $customer->setSubHours($totalHours);
                $customer->setSubDays($totalDays);

                $customer->setUpdatedAt($today);

                $customer->save();
            }
        }else {
            $logger->info($customer->getCustomAttribute('hotspot_username')->getValue());
            $infiniCustomer->setCustomerId($order->getCustomerId());
            $infiniCustomer->setHotspotUsername($customer->getCustomAttribute('hotspot_username')->getValue());
            $infiniCustomer->setHotspotPassword($customer->getCustomAttribute('hotspot_password')->getValue());
            $infiniCustomer->setSubType($subType);
            $infiniCustomer->setSubDays($totalDays);
            $infiniCustomer->setSubHours($totalHours);
            $infiniCustomer->setActive(FALSE);
            $infiniCustomer->setStatus('free');
            $infiniCustomer->save();
        }
        
    }
}
