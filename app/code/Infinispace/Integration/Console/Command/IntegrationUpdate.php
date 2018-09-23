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

	public function __construct(
		\Infinispace\Integration\Helper\Mikrotik $mikrotik,
		array $commands = []
	){
		$this->mikrotik = $mikrotik;
		parent::__construct();
	}

    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        // Get Customer Data using API

        // Enable/Disable Debug Mirkotik 
        $this->mikrotik->debug = TRUE;

        // Ambil mac address user yang sudah aktif / connect ke mikrotik 
        if ($this->mikrotik->connect('192.168.1.100', 'admin', '123qwe123')) {
            $this->mikrotik->write('/ip/hotspot/cookie/print',true);
            $READ = $this->mikrotik->read(false);
            $data = $this->mikrotik->parseResponse($READ);
            $this->mikrotik->disconnect();
        }

        foreach ($data as $key => $value) {
            if($value['user'] == 'user'){
                if ($this->mikrotik->connect('192.168.100.1', 'admin', '')) {
                    $this->mikrotik('/ip/hotspot/ip-binding/add',false);
                    $this->mikrotik('=type=bypassed',false);
                    $this->mikrotik("=mac-address=".$value['mac-address'],true);
                    $READ = $this->mikrotik->read();
                    $this->mikrotik->disconnect();
                    ob_clean();
                }
            }
        }
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