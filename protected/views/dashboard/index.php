<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'administrator') . ' ' . Yii::t('lang', 'dashboard');
?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">
            <h1></h1>
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-dashboard"></i> <?php echo Yii::t('lang', 'dashboard'); ?></h1></li>
            </ol>
        </div>
    </div>    
</div>
<!-- end PAGE TITLE AREA -->

<!-- begin DASHBOARD CIRCLE TILES -->
<div class="row">

    <div class="col-lg-12 col-sm-6">
        <h3 class="text-center" style="margin-top: 0px;"><?php echo Yii::t('lang', 'overview') ?></h3>
        <hr style="border: 1px solid rgb(204, 204, 204); width: 50%;">
    </div>

    <?php if (Yii::app()->user->name == 'Administrator') { ?>
        <div class="col-lg-2 col-sm-6">
            <a href="<?php echo Yii::app()->createAbsoluteUrl('sellers/index'); ?>">
                <div class="circle-tile">                
                    <div class="circle-tile-heading blue">
                        <i class="fa fa-users fa-fw fa-3x"></i>
                    </div>
                    <div class="circle-tile-content blue">
                        <div class="circle-tile-description text-faded">
                            <?php echo Yii::t('lang', 'sellers'); ?>
                        </div>
                        <div class="circle-tile-number text-faded">
                            <?php echo Sellers::model()->count('sellers_roleID!=1'); ?>
                            <span id="sparklineA"></span>
                        </div>
                        <span class="circle-tile-footer"><?php echo Yii::t('lang', 'more_info'); ?> <i class="fa fa-chevron-circle-right"></i></span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 col-sm-6">
            <a href="<?php echo Yii::app()->createAbsoluteUrl('buyers/index'); ?>">
                <div class="circle-tile">
                    <div class="circle-tile-heading dark-blue">
                        <i class="fa fa-users fa-fw fa-3x"></i>
                    </div>
                    <div class="circle-tile-content dark-blue">
                        <div class="circle-tile-description text-faded">
                            <?php echo Yii::t('lang', 'buyers'); ?>
                        </div>
                        <div class="circle-tile-number text-faded">
                            <?php echo Buyers::model()->count(); ?>
                            <span id="sparklineA"></span>
                        </div>
                        <span class="circle-tile-footer"><?php echo Yii::t('lang', 'more_info'); ?> <i class="fa fa-chevron-circle-right"></i></span>
                    </div>
                </div>
            </a>
        </div>            
    <?php } ?>

    <div class="col-lg-2 col-sm-6 <?php echo (Yii::app()->user->name == 'Sellers') ? 'col-lg-offset-4' : '' ?>">
        <a href="<?php echo Yii::app()->createAbsoluteUrl('category/index'); ?>">
            <div class="circle-tile">            
                <div class="circle-tile-heading red">
                    <i class="fa fa-tags fa-fw fa-3x"></i>
                </div>            
                <div class="circle-tile-content red">
                    <div class="circle-tile-description text-faded">
                        <?php echo Yii::t('lang', 'categories'); ?>
                    </div>
                    <div class="circle-tile-number text-faded">
                        <?php echo Category::model()->count(); ?>
                        <span id="sparklineC"></span>
                    </div>
                    <span class="circle-tile-footer"><?php echo Yii::t('lang', 'more_info'); ?> <i class="fa fa-chevron-circle-right"></i></span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-2 col-sm-6">
        <a href="<?php echo Yii::app()->createAbsoluteUrl('product/index'); ?>">
            <div class="circle-tile">            
                <div class="circle-tile-heading green">
                    <i class="fa fa-shopping-cart fa-fw fa-3x"></i>
                </div>            
                <div class="circle-tile-content green">
                    <div class="circle-tile-description text-faded">
                        <?php echo Yii::t('lang', 'products'); ?>
                    </div>
                    <div class="circle-tile-number text-faded">
                        <?php echo Product::model()->count(); ?>
                        <span id="sparklineC"></span>
                    </div>
                    <span class="circle-tile-footer"><?php echo Yii::t('lang', 'more_info'); ?> <i class="fa fa-chevron-circle-right"></i></span>
                </div>
            </div>
        </a>
    </div>

    <?php if (Yii::app()->user->name == 'Administrator') { ?>
        <div class="col-lg-2 col-sm-6">
            <a href="<?php echo Yii::app()->createAbsoluteUrl('pages/index'); ?>">
                <div class="circle-tile">                
                    <div class="circle-tile-heading red">
                        <i class="fa fa-tags fa-fw fa-3x"></i>
                    </div>                
                    <div class="circle-tile-content red">
                        <div class="circle-tile-description text-faded">
                            <?php echo Yii::t('lang', 'pages'); ?>
                        </div>
                        <div class="circle-tile-number text-faded">
                            <?php echo Pages::model()->count(); ?>
                            <span id="sparklineC"></span>
                        </div>
                        <span class="circle-tile-footer"><?php echo Yii::t('lang', 'more_info'); ?> <i class="fa fa-chevron-circle-right"></i></span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 col-sm-6">
            <a href="<?php echo Yii::app()->createAbsoluteUrl('contact/index'); ?>">
                <div class="circle-tile">                    
                    <div class="circle-tile-heading orange">
                        <i class="fa fa-phone fa-fw fa-3x"></i>
                    </div>
                    <div class="circle-tile-content orange">
                        <div class="circle-tile-description text-faded">
                            <?php echo Yii::t('lang', 'messages'); ?> 
                        </div>
                        <div class="circle-tile-number text-faded">
                            <?php echo Contact::model()->count(); ?>
                            <span id="sparklineC"></span>
                        </div>
                        <span class="circle-tile-footer"><?php echo Yii::t('lang', 'more_info'); ?> <i class="fa fa-chevron-circle-right"></i></span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-2 col-sm-6">
            <a href="<?php echo Yii::app()->createAbsoluteUrl('faqs/index'); ?>">
                <div class="circle-tile">                    
                    <div class="circle-tile-heading blue">
                        <i class="fa fa-question fa-fw fa-3x"></i>
                    </div>
                    <div class="circle-tile-content blue">
                        <div class="circle-tile-description text-faded">
                            <?php echo Yii::t('lang', 'faqs'); ?> 
                        </div>
                        <div class="circle-tile-number text-faded">
                            <?php echo Faqs::model()->count('faqs_status=1'); ?>
                            <span id="sparklineB"></span>
                        </div>
                        <span class="circle-tile-footer"><?php echo Yii::t('lang', 'more_info'); ?> <i class="fa fa-chevron-circle-right"></i></span>
                    </div>
                </div>
            </a>
        </div> 
        <div class="col-lg-2 col-sm-6">
            <a href="<?php echo Yii::app()->createAbsoluteUrl('template/index'); ?>">                
                <div class="circle-tile">
                    <div class="circle-tile-heading blue">
                        <i class="fa fa-mail-forward fa-fw fa-3x"></i>
                    </div>
                    <div class="circle-tile-content blue">
                        <div class="circle-tile-description text-faded">
                            <?php echo Yii::t('lang', 'templates'); ?> 
                        </div>
                        <div class="circle-tile-number text-faded">
                            <?php echo Template::model()->count('template_status=1'); ?>
                            <span id="sparklineB"></span>
                        </div>
                        <span class="circle-tile-footer"><?php echo Yii::t('lang', 'more_info'); ?> <i class="fa fa-chevron-circle-right"></i></span>
                    </div>
                </div>
            </a>
        </div> 
        <div class="col-lg-2 col-sm-6">
            <a href="<?php echo Yii::app()->createAbsoluteUrl('invoice/index'); ?>">
                <div class="circle-tile">                    
                    <div class="circle-tile-heading blue">
                        <i class="fa fa-list fa-fw fa-3x"></i>
                    </div>                    
                    <div class="circle-tile-content blue">
                        <div class="circle-tile-description text-faded">
                            <?php echo Yii::t('lang', 'invoice_templates'); ?> 
                        </div>
                        <div class="circle-tile-number text-faded">
                            <?php echo Invoice::model()->count('invoice_status=1'); ?>
                            <span id="sparklineB"></span>
                        </div>
                        <span class="circle-tile-footer"><?php echo Yii::t('lang', 'more_info'); ?> <i class="fa fa-chevron-circle-right"></i></span>
                    </div>
                </div>
            </a>
        </div> 
        <div class="col-lg-3 col-sm-6">
            <!--a href="<?php echo Yii::app()->createAbsoluteUrl('product/biddinghistory'); ?>"-->
            <a href="javascript:void(0);">
                <div class="circle-tile">                
                    <div class="circle-tile-heading dark-blue">
                        <i class="fa fa-legal fa-fw fa-3x"></i>
                    </div>                
                    <div class="circle-tile-content dark-blue">
                        <div class="circle-tile-description text-faded">
                            <?php echo Yii::t('lang', 'bidding_history'); ?>
                        </div>
                        <div class="circle-tile-number text-faded">                    
                            <br>
                            <span id="sparklineA"></span>
                        </div>
                        <span class="circle-tile-footer"><?php echo Yii::t('lang', 'more_info'); ?> <i class="fa fa-chevron-circle-right"></i></span>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-sm-6">
            <a href="<?php echo Yii::app()->createAbsoluteUrl('product/transactionHistory'); ?>">
                <div class="circle-tile">                
                    <div class="circle-tile-heading green">
                        <i class="fa fa-legal fa-fw fa-3x"></i>
                    </div>                
                    <div class="circle-tile-content green">
                        <div class="circle-tile-description text-faded">
                            <?php echo Yii::t('lang', 'transaction_history'); ?>
                        </div>
                        <div class="circle-tile-number text-faded">
                            <br/>
                        </div>
                        <span class="circle-tile-footer"><?php echo Yii::t('lang', 'more_info'); ?> <i class="fa fa-chevron-circle-right"></i></span>
                    </div>
                </div>
            </a>
        </div>
    <?php } ?>
</div>