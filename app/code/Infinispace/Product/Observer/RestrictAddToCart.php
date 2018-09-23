<?php
namespace Infinispace\Product\Observer;
  
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
  
class RestrictAddToCart implements ObserverInterface
{
    protected $_urlManager;
    protected $_checkoutSession;
    protected $_cart;
    protected $_messageManager;
    protected $_redirect;
    protected $_request;
    protected $_response;
    protected $_responseFactory;
    protected $_resultFactory;
    protected $_scopeConfig;
    protected $_product;

    public function __construct(
        \Magento\Framework\UrlInterface $urlManager,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\App\ResponseInterface $response,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\Product $product,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\Controller\ResultFactory $resultFactory
    ) {
        $this->_urlManager = $urlManager;
        $this->_checkoutSession = $checkoutSession;
        $this->_redirect = $redirect;
        $this->_cart = $cart;
        $this->_messageManager = $messageManager;
        $this->_request = $request;
        $this->_response = $response;
        $this->_responseFactory = $responseFactory;
        $this->_resultFactory = $resultFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->_product = $product;
    }
  
    /**
     * add to cart event handler.
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $controller = $observer->getControllerAction();
        $postValues = $this->_request->getPostValue();
        $cartQuote = $this->_cart->getQuote()->getData();
        $cartItemsCount = $this->_cart->getQuote()->getItemsCount();
        $cartItemsAll = $this->_cart->getQuote()->getAllItems();

        if ($cartItemsCount > 0) {
            $observer->getRequest()->setParam('product', false);
            $this->_messageManager->addError(__("Sorry, Only one Type Subscription Allowed"));
            
            return $this;
         }
  
        return $this;
    }
}