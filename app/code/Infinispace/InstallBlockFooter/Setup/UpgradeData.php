<?php
/**
 * Copyright © 2015 iCube. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Infinispace\InstallBlockFooter\Setup;

use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * Page factory
     * 
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var BlockFactory
     */
    protected $blockFactory;

    /**
     * Init
     * 
     * @param PageFactory $pageFactory
     */
    public function __construct(
        BlockFactory $modelBlockFactory,
        PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        $this->blockFactory = $modelBlockFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if(version_compare($context->getVersion(), '1.0.1', '<')) {
            $this->updateFooterBlock();
        }
    }

    /**
     * Create page
     * 
     * @return Page
     */
    public function createPage()
    {
        return $this->pageFactory->create();
    }

    /**
     * Create block
     * 
     * @return Page
     */
    public function createBlock()
    {
        return $this->blockFactory->create();
    }

    /**
     * Update Footer Block
     */
    public function updateFooterBlock()
    {
        $cmsBlockContent = <<<EOD
<div class="single_footer">
    <h3>Contact Us</h3>
    <div class="single_address">
        <p><i class="fa fa-map-marker"></i><span class="content">Address: Jl Ngaglik Sleman Yogyakarta</span></p>
    </div>
    <div class="single_address">
        <p><i class="fa fa-phone"></i><span class="content">WA: (123) 456-789</span></p>
    </div>
    <div class="single_address">
        <p><i class="fa fa-envelope"></i><span class="content">Email: hello@infinispace.co</span></p>
    </div>
</div>
EOD;
        $cmsBlock = $this->createBlock()->load('infinispace-footer3', 'identifier');

        $cmsBlockData = [
            'title' => 'Footer 3',
            'identifier' => 'infinispace-footer3',
            'content' => $cmsBlockContent,
            'is_active' => 1,
            'stores' => 0
        ];
        if(!$cmsBlock->getId()) {
            $this->createBlock->setData($cmsBlockData)->save();
        } else {
            $cmsBlock
            ->setTitle($cmsBlockData['title'])
            ->setContent($cmsBlockContent)
            ->setIsActive($cmsBlockData['is_active'])
            ->save();
        }
    }
}