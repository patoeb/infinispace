<?php


namespace Infinispace\Integration\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IntegrationUpdate extends Command
{

    protected $mikrotik;
    protected $_storeScope;
    protected $_scopeConfig;

	public function __construct(
        \Infinispace\Integration\Helper\Mikrotik $mikrotik,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		array $commands = []
	){
        $this->mikrotik = $mikrotik;
        $this->_storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $this->_scopeConfig = $scopeConfig;
		parent::__construct();
	}

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        date_default_timezone_set('Asia/Jakarta');

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/' . 'integration.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $processingCustomerUrl = $this->getMagentoUrl().'/rest/V1/infinispace-customer/processingcustomer?active=';
        $accessKey = $this->getAccessKey();
        $ipMikrotik = $this->getIpMikrotik();
        $userMikrotik = $this->getUserMikrotik();
        $passwordMikrotik = $this->getPasswordMirkotik();
        $debug = $this->getDebugValue();
        
        echo "Get Inactive Customer \r\n";
        $ch = curl_init($processingCustomerUrl.'0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cache-Control: no-cache", "Content-Type: application/json", "Authorization: Bearer ".$accessKey));
        
        $result = curl_exec($ch);
        $logger->info('Inactice Customer: '.$result);
        $result = json_decode($result,true);

        echo "Registering Free User \r\n";
        if(count($result) > 0){
            foreach($result as $key => $customer){
                $this->mikrotik->debug = $debug;
                if ($this->mikrotik->connect($ipMikrotik, $userMikrotik, $passwordMikrotik)) {
                    $this->mikrotik->write('/ip/hotspot/user/add',false);
                    $this->mikrotik->write('=limit-uptime=15m',false);
                    $this->mikrotik->write('=server=all',false);
                    $this->mikrotik->write('=name='.$customer['hotspot_username'],false);
                    $this->mikrotik->write('=password='.$customer['hotspot_password'],true);
                    $READ = $this->mikrotik->read();
                    $this->mikrotik->disconnect();

                    $this->setActiveCustomer($customer['hotspot_username'],TRUE);
                }else{
                    $logger->info("Can't connect to Mikrotik");
                    break;
                }
            }
        }

        echo "Checking Connected Free User \r\n";
        if ($this->mikrotik->connect($ipMikrotik, $userMikrotik, $passwordMikrotik)) {
            $this->mikrotik->write('/ip/hotspot/cookie/print',true);
            $READ = $this->mikrotik->read(false);
            $data = $this->mikrotik->parseResponse($READ);
            $this->mikrotik->disconnect();
        }

        $logger->info("Connected Free User");
        $logger->info($data);

        $ch = curl_init($processingCustomerUrl.'1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cache-Control: no-cache", "Content-Type: application/json", "Authorization: Bearer ".$accessKey));
        
        $result = curl_exec($ch);
        $result = json_decode($result,true);

        echo "Get Bypass User \r\n";
        $bypassCustomer = array();
        if(count($result) > 0){
            foreach($result as $key => $customer){
                if($customer['sub_type'] === 'bypass' && $customer['status'] != 'bypassed') {
                    array_push($bypassCustomer,$customer['hotspot_username']);
                }
            }
        }

        $logger->info($bypassCustomer);

        echo "Register bypass User \r\n";
        foreach ($data as $key => $value) {
            if(in_array($value['user'],$bypassCustomer)) {
                if ($this->mikrotik->connect($ipMikrotik, $userMikrotik, $passwordMikrotik)) {
                    $this->mikrotik->write('/ip/hotspot/ip-binding/add',false);
                    $this->mikrotik->write('=type=bypassed',false);
                    $this->mikrotik->write('=comment='.$value['user'],false);
                    $this->mikrotik->write("=mac-address=".$value['mac-address'],true);
                    $READ = $this->mikrotik->read();
                    $this->mikrotik->disconnect();

                    // set status customer to bypassed
                    $this->setStatusCustomer($value['user'],'bypassed');
                    
                    // set Mac address and created and expired
                    $this->setMacAddress($value['user'],$value['mac-address']);
                }
            }
        }

        
        $ch = curl_init($processingCustomerUrl.'1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cache-Control: no-cache", "Content-Type: application/json", "Authorization: Bearer ".$accessKey));
        
        $result = curl_exec($ch);
        $logger->info($result);
        $result = json_decode($result,true);

        echo "Daily Checking Expired User \r\n";
        $expiredCustomer = array();
        if(count($result) > 0){
            foreach($result as $key => $customer){
                $expiredTime = $customer['expired_at'];
                $today = date("Y-m-d H:i:s");
                if((strtotime($today) > strtotime($expiredTime)) && $expiredTime != NULL) {
                    $this->setStatusCustomer($customer['hotspot_username'],'expired');
                    $this->setActiveCustomer($customer['hotspot_username'],FALSE);
                    array_push($expiredCustomer,$customer['hotspot_username']);
                }
            }

            if ($this->mikrotik->connect($ipMikrotik, $userMikrotik, $passwordMikrotik)) {
                $this->mikrotik->write('/ip/hotspot/ip-binding/print',true);
                $READ = $this->mikrotik->read(false);
                $dataBinding = $this->mikrotik->parseResponse($READ);
                $this->mikrotik->disconnect();
            }

            $logger->info($dataBinding);

            if ($this->mikrotik->connect($ipMikrotik, $userMikrotik, $passwordMikrotik)) {
                $this->mikrotik->write('/ip/hotspot/user/print',true);
                $READ = $this->mikrotik->read(false);
                $dataUser = $this->mikrotik->parseResponse($READ);
                $this->mikrotik->disconnect();
            }

            $logger->info($dataUser);

            if ($this->mikrotik->connect($ipMikrotik, $userMikrotik, $passwordMikrotik)) {
                $this->mikrotik->write('/ip/hotspot/cookie/print',true);
                $READ = $this->mikrotik->read(false);
                $dataCookies = $this->mikrotik->parseResponse($READ);
                $this->mikrotik->disconnect();
            }

            $logger->info($dataCookies);
        }

        echo "Removing Expired User \r\n";
        if(count($expiredCustomer) > 0){
            $logger->info("Expired Customer:". $expiredCustomer);
            echo "Removing Expired User from IP-Binding List \r\n";
            foreach ($dataBinding as $key => $value) {
                if(array_key_exists('comment',$value)){
                    if(in_array($value['comment'],$expiredCustomer)) {
                        if ($this->mikrotik->connect($ipMikrotik, $userMikrotik, $passwordMikrotik)) {
                            $this->mikrotik->write('/ip/hotspot/ip-binding/remove',false);
                            $this->mikrotik->write('=numbers='.$key,true);
                            $READ = $this->mikrotik->read();
                            $this->mikrotik->disconnect();
                        }
                    }
                }
            }

            echo "Removing Expired User from User List \r\n";
            foreach ($dataUser as $key => $value) {
                if(in_array($value['name'],$expiredCustomer)) {
                    $this->removeCustomer($value['name']);
                    if ($this->mikrotik->connect($ipMikrotik, $userMikrotik, $passwordMikrotik)) {
                        $this->mikrotik->write('/ip/hotspot/user/remove',false);
                        $this->mikrotik->write('=numbers='.$key,true);
                        $READ = $this->mikrotik->read();
                        $this->mikrotik->disconnect();
                    }
                }
            }

            echo "Removing Expired User from Cookie List \r\n";
            foreach ($dataCookies as $key => $value) {
                if(in_array($value['user'],$expiredCustomer)) {
                    if ($this->mikrotik->connect($ipMikrotik, $userMikrotik, $passwordMikrotik)) {
                        $this->mikrotik->write('/ip/hotspot/cookie/remove',false);
                        $this->mikrotik->write('=numbers='.$key,true);
                        $READ = $this->mikrotik->read();
                        $this->mikrotik->disconnect();
                    }
                }
            }
        }
        
    }

    public function setMacAddress($username,$macAddress){
        $accessKey = $this->getAccessKey();
        $setMacAddressUrl = $this->getMagentoUrl().'/rest/V1/infinispace-customer/setmacaddress';
        $data = array(
            'username' => $username,
            'macAddress' => $macAddress
        );

        $data = json_encode($data);
        $ch = curl_init($setMacAddressUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cache-Control: no-cache", "Content-Type: application/json", "Authorization: Bearer ".$accessKey));
        curl_exec($ch);
    }

    public function setStatusCustomer($username,$status){
        $accessKey = $this->getAccessKey();
        $setStatusCustomerUrl = $this->getMagentoUrl().'/rest/V1/infinispace-customer/setstatuscustomer?';
        $ch = curl_init($setStatusCustomerUrl.'username='.$username.'&status='.$status);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cache-Control: no-cache", "Content-Type: application/json", "Authorization: Bearer ".$accessKey));
        curl_exec($ch);
    }

    public function setCreatedAtCustomer($username,$created){
        $accessKey = $this->getAccessKey();
        $setStatusCustomerUrl = $this->getMagentoUrl().'/rest/V1/infinispace-customer/setstatuscustomer?';
        $ch = curl_init($setStatusCustomerUrl.'username='.$username.'&status='.$status);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cache-Control: no-cache", "Content-Type: application/json", "Authorization: Bearer ".$accessKey));
        curl_exec($ch);
    }

    public function setExpiredAtCustomer($username,$expired){
        $accessKey = $this->getAccessKey();
        $setStatusCustomerUrl = $this->getMagentoUrl().'/rest/V1/infinispace-customer/setstatuscustomer?';
        $ch = curl_init($setStatusCustomerUrl.'username='.$username.'&status='.$status);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cache-Control: no-cache", "Content-Type: application/json", "Authorization: Bearer ".$accessKey));
        curl_exec($ch);
    }

    public function setActiveCustomer($username,$value){
        $accessKey = $this->getAccessKey();
        $setActiveCustomerUrl = $this->getMagentoUrl().'/rest/V1/infinispace-customer/setactivecustomer?';
        $ch = curl_init($setActiveCustomerUrl.'username='.$username.'&value='.$value);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cache-Control: no-cache", "Content-Type: application/json", "Authorization: Bearer ".$accessKey));
        curl_exec($ch);
    }

    public function removeCustomer($username){
        $accessKey = $this->getAccessKey();
        $removeCustomerUrl = $this->getMagentoUrl().'/rest/V1/infinispace-customer/removecustomer?username=';
        $ch = curl_init($removeCustomerUrl.$username);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cache-Control: no-cache", "Content-Type: application/json", "Authorization: Bearer ".$accessKey));
        curl_exec($ch);
    }

    public function getAccessKey() 
    {
        return $this->_scopeConfig->getValue('mikrotik/magento_settings/access_token', $this->_storeScope);
    }

    public function getMagentoUrl() 
    {
        return $this->_scopeConfig->getValue('mikrotik/magento_settings/base_url', $this->_storeScope);
    }

    public function getIpMikrotik() 
    {
        return $this->_scopeConfig->getValue('mikrotik/mikrotik_settings/ip_address', $this->_storeScope);
    }

    public function getUserMikrotik() 
    {
        return $this->_scopeConfig->getValue('mikrotik/mikrotik_settings/username', $this->_storeScope);
    }

    public function getPasswordMirkotik() 
    {
        return $this->_scopeConfig->getValue('mikrotik/mikrotik_settings/password', $this->_storeScope);
    }

    public function getDebugValue() 
    {
        return $this->_scopeConfig->getValue('mikrotik/mikrotik_settings/debug', $this->_storeScope);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("infinispace:integration-update");
        $this->setDescription("Get active user and Update to Mikrotik");

        parent::configure();
    }
}