<?php
/**
 * Copyright © 2015 iCube. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Infinispace\InstallBlockFooter\Setup;
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
    
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->createFooter1();
        $this->createFooter2();
        $this->createFooter3();
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

    public function createFooter1()
    {
        //Footer 1
        $cmsBlockContent = <<<EOD
<div class="single_footer">
    <h2 style="color:#be8631; font-weight: bold;">Infinispace</h2>
    <p>Lorem Ipsum is simply dummy text of the
    printing and typesetting industry. Lorem
    Ipsum has been the industry's standard
    dummy text ever since the 1500s</p>
    <div class="social_link">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-google-plus"></i></a>
        <a href="#"><i class="fa fa-pinterest"></i></a>
    </div>
</div>
EOD;
        $cmsBlock = $this->createBlock()->load('infinispace-footer1', 'identifier');
        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => 'Footer 1',
                'identifier' => 'infinispace-footer1',
                'content' => $cmsBlockContent,
                'is_active' => 1,
                'stores' => 0,
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->save();
        }
    }

    public function createFooter2(){
        //Footer 2
        $cmsBlockContent = <<<EOD
<div class="single_footer">
    <h3>Quick Links</h3>
    <div class="single_tweet">
        <ul>
            <li class="active"><a href="#home">Home</a></li>
            <li><a href="#product">Product</a></li>
            <li><a href="#shop">Shop</a></li>
            <li><a href="#facilites">Facilites</a></li>
            <li><a href="#team">Team</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </div>
</div>
EOD;
        $cmsBlock = $this->createBlock()->load('infinispace-footer2', 'identifier');
        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => 'Footer 2',
                'identifier' => 'infinispace-footer2',
                'content' => $cmsBlockContent,
                'is_active' => 1,
                'stores' => 0,
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->save();
        }
    }

    public function createFooter3(){
        //Footer 3
        $cmsBlockContent = <<<EOD
<div class="single_footer">
    <h3>Contact Us</h3>
    <div class="single_address">
        <p><i class="fa fa-map-marker"></i>Address: Jl Ngaglik Sleman Yogyakarta</p>
    </div>
    <div class="single_address">
        <p><i class="fa fa-phone"></i>WA: (123) 456-789</p>
    </div>
    <div class="single_address">
        <p><i class="fa fa-envelope"></i>Email: hello@infinispace.co</p>
    </div>
</div>
EOD;
        $cmsBlock = $this->createBlock()->load('infinispace-footer3', 'identifier');
        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => 'Footer 3',
                'identifier' => 'infinispace-footer3',
                'content' => $cmsBlockContent,
                'is_active' => 1,
                'stores' => 0,
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->save();
        }
    }

}