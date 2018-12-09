<?php
/**
 * Copyright © 2015 iCube. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Infinispace\InstallHomePage\Setup;
use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Cms\Model\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
    }
 
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $newPageContent = <<<EOD
<style type="text/css">
    .page-title-wrapper {
        display: none;
    }

    .page-main {
        padding: 0 !important;
        margin: 0 !important;
        max-width: 100% !important;
    }

    .custom_nav li a{
        color:#FFF;
    }
</style>

<div class="clearfix"></div>
{{block class="Magento\Cms\Block\Block" block_id="infinispace-slider"}}
{{block class="Magento\Cms\Block\Block" block_id="infinispace-membership"}}
{{block class="Magento\Cms\Block\Block" block_id="infinispace-facilities"}}
{{block class="Magento\Cms\Block\Block" block_id="infinispace-ourteam"}}
{{block class="Magento\Cms\Block\Block" block_id="infinispace-aboutus"}}
{{block class="Magento\Cms\Block\Block" block_id="infinispace-gallery"}}
<!-- Contact Area End here -->
<div class="map_area wow fadeInUp">
    <div class="container-fluid">
        <div class="row">
            <div id="map"></div>
        </div>
    </div>
</div>

EOD;
        $setup->startSetup();

            $newPage = $this->_pageFactory->create()->load(
                'home',
                'identifier'
            );
            if ($newPage->getId()) {
                $newPage->setContent($newPageContent);
                $newPage->save();
            }

        $setup->endSetup();
    }
}