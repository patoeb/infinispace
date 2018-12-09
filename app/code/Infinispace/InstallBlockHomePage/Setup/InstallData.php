<?php
/**
 * Copyright © 2015 iCube. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Infinispace\InstallBlockHomePage\Setup;
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
        $this->createSlider();
        $this->createMembership();
        $this->createFacilities();
        $this->createOurTeam();
        $this->createAboutus();
        $this->createGallery();
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

    public function createSlider()
    {
        //Slider
        $cmsBlockContent = <<<EOD
<div id="home" class="banner_main">
    <div class="overlay"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="home_slide">
                <div class="single_slide"><img src="{{view url='img/slider1.jpg'}}" alt="" />
                    <div class="slide_text wow fadeInUp">
                        <h1>Grow up Your Business With Us</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <a class="btn_download" href="#">Sign Up</a>
                    </div>
                </div>
                <div class="single_slide"><img src="{{view url='img/slider2.jpg'}}" alt="" />
                    <div class="slide_text wow fadeInUp">
                        <h1>Grow up Your Business With Us</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <a class="btn_download" href="#">Sign Up</a>
                    </div>
                </div>
                <div class="single_slide"><img src="{{view url='img/slider3.jpg'}}" alt="" />
                    <div class="slide_text wow fadeInUp">
                        <h1>Grow up Your Business With Us</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <a class="btn_download" href="#">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="down_arrow"><a href="#about"> <i class="fa fa-angle-down"></i> </a></div>
</div>
<p></p>
EOD;
        $cmsBlock = $this->createBlock()->load('infinispace-slider', 'identifier');
        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => 'Slider',
                'identifier' => 'infinispace-slider',
                'content' => $cmsBlockContent,
                'is_active' => 1,
                'stores' => 0,
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->save();
        }
    }

    public function createMembership(){
        //Membership
        $cmsBlockContent = <<<EOD
<!-- Price Area Start Here -->
<div id="product" class="section_padding">
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-12">
                <div class="sec_head">
                    <h2>Membership</h2>
                    <span></span>
                    <p>All membership are individual based</p>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 wow fadeInUp">
                <div class="single_price">
                    <div class="price_top">
                        <h1><span>IDR</span>20,000 <span>/month</span></h1>
                    </div>
                    <h3>HALF DAY</h3>
                    <ul>
                        <li>Get a 4 hours straight access to our space</li>
                        <li>Unlimited high speed internet access</li>
                        <li>Free Pantry</li>
                        <li>No Locker</li>
                        <li>No Summer breeze garden in the space</li>
                    </ul>
                    <div class="price_bottom"><a class="price_btn" href="#">Buy Now</a></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 wow fadeInRight">
                <div class="single_price">
                    <div class="price_top">
                    <h1><span>IDR</span>35,000 <span>/month</span></h1>
                    </div>
                    <h3>Summer breeze garden in the space Daily</h3>
                    <ul>
                    <li>It’s our daily rate to come in our space</li>
                    <li>Unlimited high speed internet access</li>
                    <li>Free pantry and use the stuff</li>
                    <li>Locker</li>
                    <li>Summer breeze garden in the space</li>
                    </ul>
                    <div class="price_bottom"><a class="price_btn" href="#">Buy Now</a></div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 wow fadeInRight">
                <div class="single_price">
                    <div class="price_top">
                        <h1><span>IDR</span>900,000 <span>/month</span></h1>
                    </div>
                    <h3>MONTHLY</h3>
                    <ul>
                        <li>30 Days straight to our space</li>
                        <li>Unlimited high speed internet access</li>
                        <li>Free pantry and use the stuff</li>
                        <li>Locker</li>
                        <li>Summer breeze garden in the space</li>
                    </ul>
                    <div class="price_bottom"><a class="price_btn" href="#">Buy Now</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<p></p>
EOD;
        $cmsBlock = $this->createBlock()->load('infinispace-membership', 'identifier');
        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => 'Membership',
                'identifier' => 'infinispace-membership',
                'content' => $cmsBlockContent,
                'is_active' => 1,
                'stores' => 0,
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->save();
        }
    }

    public function createFacilities(){
        //Facilities
        $cmsBlockContent = <<<EOD
<!-- Choose Area Start Here -->
<div id="facilities" class="section_padding">
    <div class="container">
        <div class="row text-center">
            <div class="col-sm-12 text-center">
                <div class="sec_head">
                    <h2>Facilities</h2>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 wow fadeInLeft">
                <div class="single_service"><img src="{{view url='img/facilities.jpg'}}" alt="" />
                    <div class="service_text">
                        <h2>Common Space</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 wow fadeInUp">
                <div class="single_service"><img src="{{view url='img/facilities2.jpg'}}" alt="" />
                    <div class="service_text">
                        <h2>Garden</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 wow fadeInRight">
                <div class="single_service"><img src="{{view url='img/facilities3.jpg'}}" alt="" />
                    <div class="service_text">
                        <h2>Meeting Room</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 wow fadeInRight">
                <div class="single_service"><img src="{{view url='img/facilities4.jpg'}}" alt="" />
                    <div class="service_text">
                        <h2>Balcony</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 wow fadeInRight">
                <div class="single_service"><img src="{{view url='img/facilities5.jpg'}}" alt="" />
                    <div class="service_text">
                        <h2>Locker</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 wow fadeInRight">
                <div class="single_service"><img src="{{view url='img/facilities6.jpg'}}" alt="" />
                    <div class="service_text">
                        <h2>Pantry</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 wow fadeInRight">
                <div class="single_service"><img src="{{view url='img/facilities7.jpg'}}" alt="" />
                    <div class="service_text">
                        <h2>Wifi</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 wow fadeInRight">
                <div class="single_service"><img src="{{view url='img/facilities8.jpg'}}" alt="" />
                    <div class="service_text">
                        <h2>Parking Spot</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
EOD;
        $cmsBlock = $this->createBlock()->load('infinispace-facilities', 'identifier');
        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => 'Facilities',
                'identifier' => 'infinispace-facilities',
                'content' => $cmsBlockContent,
                'is_active' => 1,
                'stores' => 0,
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->save();
        }
    }

    public function createOurTeam(){
        //Our Team
        $cmsBlockContent = <<<EOD
<!-- Choose Area End Here -->
<div id="team" class="section_padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center wow fadeInUp">
                <div class="sec_head">
                    <h2>Our Team</h2>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="row wow fadeInUp">
            <div id="team_slide">
                <div class="single_team">
                    <div class="team_img"><img src="{{view url='img/team1.jpg'}}" alt="" />
                        <div class="team_info">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi ipsa dignissimos neque architecto, hic quis.</p>
                            <div class="team_social"><a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-pinterest"></i></a> <a href="#"><i class="fa fa-google"></i></a></div>
                        </div>
                    </div>
                    <div class="team_name">
                        <h4>Yoko Santoso</h4>
                        <p>Co-Founder</p>
                    </div>
                </div>
                <div class="single_team">
                    <div class="team_img"><img src="{{view url='img/team2.jpg'}}" alt="" />
                        <div class="team_info">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi ipsa dignissimos neque architecto, hic quis.</p>
                            <div class="team_social"><a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-pinterest"></i></a> <a href="#"><i class="fa fa-google"></i></a></div>
                        </div>
                    </div>
                    <div class="team_name">
                        <h4>Celestinus Hendra</h4>
                        <p>Co-Founder</p>
                    </div>
                </div>
                <div class="single_team">
                    <div class="team_img"><img src="{{view url='img/team3.jpg'}}" alt="" />
                        <div class="team_info">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi ipsa dignissimos neque architecto, hic quis.</p>
                            <div class="team_social"><a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-pinterest"></i></a> <a href="#"><i class="fa fa-google"></i></a></div>
                        </div>
                    </div>
                    <div class="team_name">
                        <h4>Hendricus Endra Dwi</h4>
                        <p>IT Sifu</p>
                    </div>
                </div>
                <div class="single_team">
                    <div class="team_img"><img src="{{view url='img/team3.jpg'}}" alt="" />
                        <div class="team_info">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi ipsa dignissimos neque architecto, hic quis.</p>
                            <div class="team_social"><a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-pinterest"></i></a> <a href="#"><i class="fa fa-google"></i></a></div>
                        </div>
                    </div>
                    <div class="team_name">
                        <h4>Hendricus Endra Dwi</h4>
                        <p>IT Sifu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
EOD;
        $cmsBlock = $this->createBlock()->load('infinispace-ourteam', 'identifier');
        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => 'Our Team',
                'identifier' => 'infinispace-ourteam',
                'content' => $cmsBlockContent,
                'is_active' => 1,
                'stores' => 0,
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->save();
        }
    }

    public function createAboutus(){
        //About Us
        $cmsBlockContent = <<<EOD
<div id="aboutus" class="section_padding">
    <div class="container">
        <div class="single_about">
            <div class="row">
                <div class="col-sm-12 text-center wow fadeInUp">
                    <div class="sec_head">
                        <h2>About Us</h2>
                        <span></span>
                    </div>
                </div>
                <div class="col-md-6 wow fadeInLeft">
                    <div class="single_about_text">
                        <h1>Infini Space Is</h1>
                        <p>Phasellus facilisis mauris vel velit molestie pellentesque. Donec rutrum, tortor ut elementum venenatis, purus magna bibendum nisl, Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras elementum id metus ac tempus. Praesent ut mauris eget velit volutpat posuere nec ut elit</p>
                    </div>
                </div>
                <div class="col-md-5 col-md-offset-1 wow fadeInRight">
                    <div class="single_about_img"><img src="{{view url='img/about-us.jpg'}}" alt="" /></div>
                </div>
            </div>
        </div>
    </div>
</div>
EOD;
        $cmsBlock = $this->createBlock()->load('infinispace-aboutus', 'identifier');
        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => 'About Us',
                'identifier' => 'infinispace-aboutus',
                'content' => $cmsBlockContent,
                'is_active' => 1,
                'stores' => 0,
            ];
            $this->createBlock()->setData($cmsBlock)->save();
        } else {
            $cmsBlock->setContent($cmsBlockContent)->save();
        }
    }

    public function createGallery(){
        //Gallery
        $cmsBlockContent = <<<EOD
<div id="gallery" class="section_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 wow fadeInLeft">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel"><!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li class="active" data-target="#carousel-example-generic" data-slide-to="0"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol><!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="{{view url='img/gallery.jpg'}}" alt="img/gallery.jpg" />
                            <div class="carousel-caption">Lore ipsum dolor sit amet</div>
                        </div>
                        <div class="item">
                            <img src="{{view url='img/gallery2.jpg'}}" alt="img/gallery2.jpg" />
                            <div class="carousel-caption">Lore ipsum dolor sit amet</div>
                        </div>
                        <div class="item">
                            <img src="{{view url='img/gallery3.jpg'}}" alt="img/gallery3.jpg" />
                            <div class="carousel-caption">Lore ipsum dolor sit amet</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
EOD;
        $cmsBlock = $this->createBlock()->load('infinispace-gallery', 'identifier');
        if (!$cmsBlock->getId()) {
            $cmsBlock = [
                'title' => 'Gallery',
                'identifier' => 'infinispace-gallery',
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