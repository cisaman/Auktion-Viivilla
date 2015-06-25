<?php
// $utils = new Utils;
// echo $utils->passwordDecrypt('221UTHZPfBt+jqHEhlKok6Noso78LP3G0ukBLan/CwDVy+azhZfy+mHISguch8AdNezEAqVcl2GX7vjDFiTrKxjuKnU6ahXRJ4FYCI6lwHIIJFlofUgEnBFmhj26d94y|EpTFAmem6PUkxSR/mLW/OYcoU2JfTQ9E1JlpWSbRkqo=');
?>

<!DOCTYPE html>
<html>
    <head>
        <?php
        $cs = Yii::app()->clientScript;
        $cs->scriptMap = array(
            'jquery.js' => Yii::app()->request->baseUrl . '/bootstrap/site/js/jquery.js',
        );
        $cs->registerCoreScript('jquery');
        ?>        

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="language" content="en" />
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="format-detection" content="telephone=no"/>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>        
        <link rel="icon" href="<?php echo Yii::app()->params['site_url']; ?>/bootstrap/site/images/favicon.ico" sizes="16x16"> 

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/css/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/css/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/css/owl.carousel.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/css/responsive.css" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/css/custom.css" />        
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/css/invoice.css" />        

        <script src="http://104.236.111.34:8080/socket.io/socket.io.js"></script>

        <script type="text/javascript">
            var socket = io.connect('http://104.236.111.34:8080');
            var action_id = "<?php echo Yii::app()->controller->action->id; ?>";
        </script>
    </head>

    <body>
        <section class="main-body">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 center-part">
                        <div class="header-part">

                            <div class="menus-top-part">
                                <!-- Static navbar -->
                                <nav class="navbar navbar-default" role="navigation">
                                    <div class="container-fluid">
                                        <div class="navbar-header">
                                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                                <span class="sr-only">Toggle navigation</span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>
                                        </div>
                                        <div id="navbar" class="navbar-collapse collapse">                                            
                                            <?php
                                            $this->widget('zii.widgets.CMenu', array(
                                                'encodeLabel' => false,
                                                'htmlOptions' => array('class' => 'nav navbar-nav'),
                                                'activeCssClass' => 'active',
                                                'activateParents' => TRUE,
                                                'items' => array(
                                                    // array(
                                                    //     'label' => 'Hem',
                                                    //     'url' => array('/site/index'),
                                                    //     'visible' => empty(Yii::app()->session['user_data']) ? TRUE : FALSE,
                                                    //     'active' => (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'index'),
                                                    // ),
                                                    array(
                                                        'label' => Yii::t('lang', 'aboutus'),
                                                        'url' => array('/site/about'),
                                                        'visible' => FALSE,
                                                        'active' => (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'about'),
                                                    ),
                                                    array(
                                                        'label' => Yii::t('lang', 'my_account') . ' / ' . Yii::t('lang', 'register'),
                                                        'url' => array('/site/register'),
                                                        'visible' => empty(Yii::app()->session['user_data']) ? TRUE : FALSE,
                                                        'active' => (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'register'),
                                                    ),
                                                    array(
                                                        'label' => Yii::t('lang', 'my_account'),
                                                        'url' => array('/site/myaccount'),
                                                        'visible' => empty(Yii::app()->session['user_data']) ? FALSE : TRUE,
                                                        'active' => (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'myaccount'),
                                                    ),
                                                    array(
                                                        'label' => Yii::t('lang', 'terms_conditions'),
                                                        'url' => array('/site/terms_conditions'),
                                                        'active' => (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'terms_conditions'),
                                                    ),
                                                    array(
                                                        'label' => Yii::t('lang', 'auction_package'),
                                                        'url' => array('/site/package'),
                                                        'visible' => FALSE,
                                                        //'visible' => empty(Yii::app()->session['user_data']) ? TRUE : FALSE,
                                                        'active' => (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'package'),
                                                    ), array(
                                                        'label' => Yii::t('lang', 'contactus'),
                                                        'url' => array('/site/contact'),
                                                        'active' => (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'contact'),
                                                    ),
                                                ),
                                            ));
                                            ?>
                                        </div>                                        
                                    </div>
                                </nav>
                            </div>

                            <div class="center-head">
                                <div class="logo">
                                    <a href="/">
                                        <img src="<?php echo Yii::app()->baseUrl ?>/bootstrap/site/images/logo.png" alt="logo" />
                                    </a>
                                </div>

                                <div class="form-group">
                                    <form action="/searchterm" method="get">
                                        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                                        <input class="form-control search-input ui-autocomplete-input changefont" placeholder="Nyckelord + Enter" name="keyword" value="<?php echo @$_GET['keyword'] ?>" type="text" autocomplete="off"/>
                                        <input id="search_btn" type="submit" value="" >
                                    </form>
                                </div>

                                <?php if (empty(Yii::app()->session['user_data'])) { ?>
                                    <div class="right-login">
                                        <div class="login hidden-xs">
                                            <div class="user">                                            
                                                <a href="<?php echo Yii::app()->createAbsoluteUrl('site/register'); ?>">
                                                    <?php echo Yii::t('lang', 'register'); ?>
                                                </a>
                                            </div>
                                            <div class="log-in">
                                                <a href="javascript:void(0);"><?php echo Yii::t('lang', 'login'); ?></a>
                                            </div>
                                        </div>
                                        <?php
                                        $buyersmodel = new BuyersLoginForm;
                                        $this->renderPartial('_login', array('model' => $buyersmodel, 'hide_title' => 0));
                                        ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="right-login">
                                        <div class="login hidden-xs">
                                            <div class="user">                                            
                                                <a href="<?php echo Yii::app()->createAbsoluteUrl('site/myaccount'); ?>"><?php echo Yii::t('lang', 'my_account'); ?></a>
                                            </div>
                                            <div class="log-in">
                                                <a href="<?php echo Yii::app()->createAbsoluteUrl('site/logout'); ?>"><?php echo Yii::t('lang', 'logout'); ?></a>
                                            </div>
                                        </div>                                        
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="menus-part">
                            <!-- Static navbar -->
                            <nav class="navbar navbar-default" role="navigation">
                                <div class="container-fluid" style="background: #eee;">
                                    <div class="navbar-header">
                                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>
                                    <div id="navbar" class="navbar-collapse collapse">
                                        <ul class="nav navbar-nav secondmenu">
                                            <li>
                                                <a href="http://viivilla.se/bad/" target="_blank" title="Badrum"><?php echo Yii::t('lang', 'bathroom'); ?></a>
                                            </li>
                                            <li>
                                                <a href="http://viivilla.se/inredning/" target="_blank" title="Inredning">Inredning</a>
                                            </li>
                                            <li>
                                                <a href="http://viivilla.se/kok/" target="_blank" title="Kök"><?php echo Yii::t('lang', 'kitchen'); ?></a>
                                            </li>
                                            <li>
                                                <a href="http://viivilla.se/tradgard/" target="_blank" title="Trädgård"><?php echo Yii::t('lang', 'garden'); ?></a>
                                            </li>
                                            <li>
                                                <a href="http://viivilla.se/bygg/" target="_blank" title="Bygg">Bygg</a>
                                            </li>
                                            <li>
                                                <a href="http://viivilla.se/energi/" target="_blank" title="Energi"><?php echo Yii::t('lang', 'energy'); ?></a>
                                            </li>
                                            <li>
                                                <a href="http://viivilla.se/gor-det-sjalv/" target="_blank" title="Gör det själv"><?php echo Yii::t('lang', 'do_it_yourself'); ?></a>
                                            </li>
                                            <li>
                                                <a href="http://viivilla.se/husliv/" target="_blank" title="Husliv"><?php echo Yii::t('lang', 'husliv'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle changefont" data-toggle="dropdown">
                                            <?php echo Yii::t('lang', 'our_services'); ?> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a title="Auktion" target="_blank" href="http://auktion.viivilla.se/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Auktion">
                                                    <span>Auktion</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Beställ tidning" target="_blank" href="http://viivilla.se/bestall-tidning/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Beställ tidning">
                                                    <span>Beställ tidning</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Blogg" target="_blank" href="http://blogg.viivilla.se/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Blogg">
                                                    <span>Blogg</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Expert" target="_blank" href="http://viivilla.se/experter/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Expert">
                                                    <span>Expert</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Foto" target="_blank" href="http://foto.viivilla.se/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Foto">
                                                    <span>Foto</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Forum" target="_blank" href="http://viivilla.se/forum/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Forum">
                                                    <span>Forum</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Leverantörer" target="_blank" href="http://viivilla.se/leverantorer/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Leverantörer">
                                                    <span>Leverantörer</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Prenumerera" target="_blank" href="http://viivilla.se/prenumerera/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Prenumerera">
                                                    <span>Prenumerera</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Produkter" target="_blank" href="http://viivilla.se/produkter/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Produkter">
                                                    <span>Produkter</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Tävlingar" target="_blank" href="http://viivilla.se/tavlingar/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Tävlingar">
                                                    <span>Tävlingar</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Tidningsarkiv" target="_blank" href="http://viivilla.se/tidningsarkiv/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Tidningsarkiv">
                                                    <span>Tidningsarkiv</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Villapanelen" target="_blank" href="http://viivilla.se/sidor/villapanelen/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Villapanelen">
                                                    <span>Villapanelen</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a title="Webb-TV" target="_blank" href="http://viivilla.se/tv/">
                                                    <img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/other_link_icon.png?preset=width50" alt="Webb-TV">
                                                    <span>Webb-TV</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>                                    
                                </div>
                            </nav>
                        </div>                                               

                        <div class="banner-part hidden-xs">

                        </div>

                        <?php if (Yii::app()->controller->action->id != 'index') { ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 betcrunb-part">
                                <?php if (isset($this->breadcrumbs)): ?>
                                    <?php
                                    $this->widget('zii.widgets.CBreadcrumbs', array(
                                        'homeLink' => CHtml::link('Hem', array('/site/index')) . ' >',
                                        'links' => $this->breadcrumbs,
                                        'tagName' => 'ul',
                                        'separator' => ' ',
                                        'activeLinkTemplate' => '<li class="crumb-active"><a href="{url}">{label}</a></li>',
                                        'inactiveLinkTemplate' => '<li><span>{label}</span></li>',
                                        'htmlOptions' => array('class' => 'crumb-link')
                                    ));
                                    ?>
                                <?php endif ?>
                            </div>
                        <?php } ?>

                        <?php echo $content; ?>                        


                        <?php if (Yii::app()->controller->action->id != 'index') { ?>
                            <!--second slider start-->
                            <div class="col-lg-12 col-md-12 col-sm-12 slider-part" style="margin: 30px 0px;">
                                <div class="row">
                                    <div class="slider-head">
                                        <h3 style="text-transform: none;" class="changefont"><?php echo Yii::t('lang', 'auctions_ending_soon'); ?></h3>
                                    </div>
                                    <div class="slide-show">
                                        <div id="owl-demo1" class="owl-carousel owl-theme">
                                            <?php
                                            $product = new Product();
                                            $recent = $product->getProducts('product_expiry_date', 'ASC', 10, 0);

                                            foreach ($recent as $product) {
                                                ?>
                                                <div class="item">
                                                    <a href="<?php echo Yii::app()->createAbsoluteUrl('site/product/', array('id' => $product['p_id'], 'title' => $product['p_slug'])); ?>">
                                                        <img src="<?php echo $product['p_image']; ?>" alt="<?php echo $product['p_name']; ?>"/>
                                                        <span class="img-top">
                                                            <h4>
                                                                <?php echo (Yii::app()->user->getState('lang') == 'en') ? Yii::t('lang', 'currency') : '' ?>
                                                                <span class="price_<?php echo $product['p_id']; ?>"><?php echo $product['p_price']; ?></span>
                                                                <?php echo (Yii::app()->user->getState('lang') == 'sv') ? Yii::t('lang', 'currency') : '' ?>                        
                                                            </h4>
                                                        </span>
                                                    </a>
                                                    <p>
                                                        <a href="<?php echo Yii::app()->createAbsoluteUrl('site/product/', array('id' => $product['p_id'], 'title' => $product['p_slug'])); ?>"><?php echo $product['p_name']; ?></a>
                                                    </p>
                                                    <ul class="list-part pid_r_<?php echo $product['p_id']; ?>" key="pid_r_<?php echo $product['p_id']; ?>" data="<?php echo $product['p_new_expiry']; ?>">
                                                        <li><span class="pid_d"></span><span><?php echo Yii::t('lang', 'days'); ?></span></li>
                                                        <li><span class="pid_h"></span><span><?php echo Yii::t('lang', 'hours'); ?></span></li>
                                                        <li><span class="pid_m"></span><span><?php echo Yii::t('lang', 'minutes'); ?></span></li>
                                                        <li><span class="pid_s"></span><span><?php echo Yii::t('lang', 'seconds'); ?></span></li>
                                                    </ul>            
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="customNavigation">
                                            <a class="btn prev"><img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/prev.png"></a>
                                            <a class="btn next"><img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/next.png"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--second slider end-->
                        <?php } ?>

                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12  bottom-image-last">
                        <div class="row">
                            <div class="tree-house"></div>
                        </div>
                    </div>

                </div>
            </div>            
        </section>

        <section class="footer-part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 center-footer">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-2 footer-one">
                                <a href="http://www.bonnierpublications.se/" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/images/bp_footer_logo.png" alt="logo"></a>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 footer-one">
                                <ul class="footer-link">                               
                                    <li><a target="_blank" title="Badrum" href="http://viivilla.se/bad/"><?php echo Yii::t('lang', 'bathroom'); ?></a></li>
                                    <li><a target="_blank" title="Inredning" href="http://viivilla.se/inredning/">Inredning</a></li>
                                    <li><a target="_blank" title="Kök" href="http://viivilla.se/kok/"><?php echo Yii::t('lang', 'kitchen'); ?></a></li>
                                    <li><a target="_blank" title="Trädgård" href="http://viivilla.se/tradgard/"><?php echo Yii::t('lang', 'garden'); ?></a></li>
                                    <li><a target="_blank" title="Bygg" href="http://viivilla.se/bygg/">Bygg</a></li>
                                    <li><a target="_blank" title="Energi" href="http://viivilla.se/energi/"><?php echo Yii::t('lang', 'energy'); ?></a></li>
                                    <li><a target="_blank" title="Gör det själv" href="http://viivilla.se/gor-det-sjalv/"><?php echo Yii::t('lang', 'do_it_yourself'); ?></a></li>
                                    <li><a target="_blank" title="Husliv" href="http://viivilla.se/husliv/"><?php echo Yii::t('lang', 'husliv'); ?></a></li>
                                </ul>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 footer-one">
                                <ul class="footer-link">
                                    <li><a target="_blank" title="Auktion" href="http://auktion.viivilla.se/">Auktion</a></li>
                                    <li><a target="_blank" title="Villapanelen" href="http://viivilla.se/sidor/villapanelen/">Villapanelen</a></li>
                                    <li><a target="_blank" title="Experter" href="http://viivilla.se/sidor/experter/">Experter</a></li>
                                    <li><a target="_blank" title="Tidningsarkiv" href="http://viivilla.se/sidor/tidningsarkiv/">Tidningsarkiv</a></li>
                                    <li><a target="_blank" title="Tävlingar" href="http://viivilla.se/sidor/tavlingar/">Tävlingar</a></li>
                                    <li><a target="_blank" title="Länktips" href="http://viivilla.se/sidor/lanktips/">Länktips</a></li>
                                    <li><a target="_blank" title="Registrering" href="http://viivilla.se/sidor/registrering/">Registrering</a></li>
                                </ul>

                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 footer-one">
                                <ul class="footer-link">
                                    <li><a target="_blank" title="Om Vi i Villa" href="http://viivilla.se/sidor/om-vi-i-villa/"><?php echo Yii::t('lang', 'we_are_in_the_villa'); ?></a></li>
                                    <li><a target="_blank" title="Annonsera" href="http://viivilla.se/sidor/annonsera/"><?php echo Yii::t('lang', 'advertise'); ?></a></li>
                                    <li><a target="_blank" title="Kontakta oss" href="http://viivilla.se/sidor/kontakta-oss/"><?php echo Yii::t('lang', 'contactus'); ?></a></li>
                                    <li><a target="_blank" title="Copyright" href="http://viivilla.se/sidor/copyright/"><?php echo Yii::t('lang', 'copyright'); ?></a></li>
                                    <li><a target="_blank" title="Cookies" href="http://viivilla.se/sidor/cookies/"><?php echo Yii::t('lang', 'cookies'); ?></a></li>
                                    <li><a target="_blank" title="Press" href="http://viivilla.se/press/"><?php echo Yii::t('lang', 'press'); ?></a></li>
                                </ul>

                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 footer-one">
                                <ul class="social-link">
                                    <li><a target="_blank" title="Facebook" href="https://www.facebook.com/viivilla"><i class="fa fa-facebook"></i>Facebook</a></li>
                                    <li><a target="_blank" title="Instagram" href="http://instagram.com/viivilla_sverige"><i class="fa fa-instagram"></i>Instagram</a></li>
                                    <li><a target="_blank" title="<?php echo Yii::t('lang', 'subscribe_for_newsletter'); ?>" href="http://viivilla.se/sidor/nyhetsbrev/"><i class="fa fa-envelope"></i><?php echo Yii::t('lang', 'subscribe_for_newsletter'); ?></a></li>
                                </ul>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/js/bootstrap.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/js/owl.carousel.js"></script>
        <script src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/site/js/bootbox.js"></script>       
        <script src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/site/js/custom.js"></script>        

        <script src="http://momentjs.com/downloads/moment.js"></script>
        <script src="http://momentjs.com/downloads/moment-timezone.js"></script>

        <!--  For Bid Time of Products  -->
        <script type="text/javascript">
            setTime = 0;
            var clk = [];
            var calcNewYear = [];
            moment.tz.setDefault("Europe/Stockholm");
            cur_date = parseInt(new Date().getTime() / 1000);

            //if(setTime == 0) {
            //setTime = socket.emit('server_time', {setTime: setTime});
            //}

            //socket.on('client_time', function(data) {
            //cur_date = data;
            //setTime = 1;
            //console.log('a');                
            //});

            function getServerTime() {
                try {
                    xhr.abort();
                } catch (e) {

                }
                xhr = $.ajax({
                    url: '<?php echo Utils::GetBaseUrl(); ?>/site/getServerTime',
                    async: true,
                    success: function (res) {
                        cur_date = res;
                    }
                });
                //console.clear();
            }

//            socket.on('receive_server_time', function (mydata) {
//                cur_date = mydata;
//            });
            setInterval(function () {
                getServerTime();
            }, 1000);

            function createNewClock(id) {
                if ($.inArray(id, clk) < 0) {

                    calcNewYear[id] = setInterval(function () {
                        exp = parseInt($('.' + id).attr('data'));

                        var diff = parseInt(exp - cur_date);

                        if (diff < 0) {
                            getExpiredMsg(id);
                            clearInterval(calcNewYear[id]);
                            clk.splice($.inArray(id, clk), 1);
                            return false;
                        } else {
                            $('.bidexpmsg_' + id).remove();
                            $('#productBox_' + id).remove();
                            $('.' + id).show();
                            $(".hideBoxWhenExpired_" + id).fadeIn('slow');
                        }

                        seconds = Math.floor(diff);
                        minutes = Math.floor(seconds / 60);
                        hours = Math.floor(minutes / 60);
                        days = Math.floor(hours / 24);

                        hours = hours - (days * 24);
                        minutes = minutes - (days * 24 * 60) - (hours * 60);
                        seconds = seconds - (days * 24 * 60 * 60) - (hours * 60 * 60) - (minutes * 60);


                        if (days < 10) {
                            $('.' + id + ' .pid_d').text('0' + days);
                        } else {
                            $('.' + id + ' .pid_d').text(days);
                        }
                        if (hours < 10) {
                            $('.' + id + ' .pid_h').text('0' + hours);
                        } else {
                            $('.' + id + ' .pid_h').text(hours);
                        }
                        if (minutes < 10) {
                            $('.' + id + ' .pid_m').text('0' + minutes);
                        } else {
                            $('.' + id + ' .pid_m').text(minutes);
                        }
                        if (seconds < 10) {
                            $('.' + id + ' .pid_s').text('0' + seconds);
                        } else {
                            $('.' + id + ' .pid_s').text(seconds);
                        }
                        // --exp;
                        // $('.' + id).attr('data', exp);
                    }, 1000);
                    clk.push(id);
                }
            }

            function getExpiredMsg(id) {
                $('.bidexpmsg_' + id).remove();
                var data = '<div id="bidexpmsg_' + id + '" class="bid_expired bidexpmsg_' + id + '"><?php echo Yii::t('lang', 'bid_time_over'); ?></div>';
                $('.' + id).after(data).animate({}, 1000);
                $('.' + id).hide();
                $(".hideBoxWhenExpired_" + id).fadeOut('slow');
                $('#productBox_' + id).remove();
                $('#bidConfirmModal').modal('hide');
            }
        </script>

        <script type="text/javascript" async>
            socket.on('client_receive', function (data) {
                var product_id = data.product_id;
                apply_price123(product_id);
<?php if (Yii::app()->controller->action->id == 'product') { ?>
                    getUpBid();
<?php } ?>
            });
        </script>

        <script type="text/javascript" async>
            var data = location.pathname.split('/');

            function apply_price123(product_id) {
                if (action_id == 'index') {
                    var link = $("#maincontent .active").find("a").attr("href");
                    if (link != null && link != '') {
                        var matches = link.match(/\d+/g);
                    }
                    if (matches != null && link != undefined) {
                        link = link.replace('index', 'get_allprice');
                        link = link + "&by=ajax";
                    } else {
                        link = "/get_allprice?by=ajax&page=1";
                    }
                } else {
                    link = "/get_allprice?by=ajax&page=1";
                }
                link = "/get_allprice?by=ajax&page=1";

                try {
                    xhr.abort();
                } catch (e) {

                }

                xhr = $.ajax({
                    url: link,
                    type: "get",
                    datatype: "json",
                    success: function (res) {
                        res_p = $.parseJSON(res);
                        $.each(res_p, function (index, value) {

                            if (product_id == value.p_id) {

                                $('.pid_r_' + value.p_id).attr('data', value.p_new_expiry);

                                $(".price_" + value.p_id).text(value.p_price);
                                $(".nextprice_" + value.p_id).attr('placeholder', value.p_nextprice);

                                createNewClock('pid_r_' + value.p_id);

                                //For Product Details & Show History Page
                                $('.textBidDiff_' + value.p_id).val(value.p_nextprice);
                                $('.textBid_' + value.p_id).attr("placeholder", value.p_nextprice);
                                $(".textPrice_" + value.p_id).text(value.p_price);

                                if (action_id == 'product') {
                                    if (data[2] != undefined) {
                                        if (value.p_id == data[2]) {
                                            getNicknameOfHigherBiddder(data[2], value.p_price);
                                        }
                                    }
                                }
                            }

                        });
                    },
                });
            }

            function get_expiry(product_id) {
                $.ajax({
                    async: false,
                    url: '<?php echo Utils::GetBaseUrl(); ?>/site/get_exp',
                    type: 'POST',
                    data: {pid: product_id},
                    success: function (result) {
                        setTime = result;
                    }
                });
            }
        </script>

        <script type="text/javascript" async>
            $(document).ready(function () {
                $(".right-toggle").hide();
                $(".log-in").show();

                $('.log-in').click(function () {
                    $(".right-toggle").slideToggle();
                });
            });
        </script>               

        <!-- For Slider on HomePage -->
        <script type="text/javascript">
            $(document).ready(function () {
                var owl = $("#owl-demo, #owl-demo1");

                owl.owlCarousel({
                    autoPlay: 2000, //Set AutoPlay to 3 seconds
                    pagination: false,
                    stopOnHover: true,
                    lazyLoad: true,
                    items: 3, //10 items above 1000px browser width
                    itemsDesktop: [1000, 3], //5 items between 1000px and 901px
                    itemsDesktopSmall: [900, 3], // 3 items betweem 900px and 601px
                    itemsTablet: [600, 2], //2 items between 600 and 0;
                    itemsMobile: [360, 1], // itemsMobile disabled - inherit from itemsTablet option                   
                });

                // Custom Navigation Events
                $(".next").click(function () {
                    owl.trigger('owl.next');
                });
                $(".prev").click(function () {
                    owl.trigger('owl.prev');
                });
            });
        </script>        

        <style type="text/css">
            .bid_expired {background: none repeat scroll 0 0 rgb(239, 63, 68);color: #fff;font-weight: bold;margin-bottom: 6px;padding: 8px 0;text-align: center;vertical-align: middle;}            
            .dropdown-menu li {border-top: 0px dotted #cccccc !important;}
            .slider-part-1{margin-top: 20px;background-color: rgb(239, 239, 239);}
            #list_all > h3 {margin-top: 10px !important;}
            .pagination{margin: 0px !important;}           
            .owl-wrapper {text-align: center !important;}
            .list-part{padding: 0 10px !important;}
        </style>

        <script type="text/javascript" async>
            $(document).ready(function () {
                $(".time-list").each(function () {
                    var id = $(this).attr("key");
                    createNewClock(id);
                });

                $(".list-part").each(function () {
                    var id = $(this).attr("key");
                    createNewClock(id);
                });
            });
        </script>   

        <div id="loading">
            <img id="loading-image" src="http://opengraphicdesign.com/wp-content/uploads/2009/01/loader64.gif" alt="Loading..." />
        </div>  
        <style type="text/css">
            #loading {width: 100%;height: 100%;top: 0px;left: 0px;position: fixed;display: block;opacity: 0.8;background-color: #fff;z-index: 99;text-align: center;}
            #loading-image {position: absolute;top: 40%;left: 50%;z-index: 100;}
        </style>   
        <script language="javascript" type="text/javascript" async>
            $('#loading').hide();
        </script>
       
        <!-- Google Tag Manager -->
        <noscript>
        <iframe src="//www.googletagmanager.com/ns.html?id=GTM-W9BD4L" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        <script>
            (function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
                var f = d.getElementsByTagName(s)[0], j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src = '//www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-W9BD4L');
        </script>
        <!-- End Google Tag Manager -->

        <!-- Googles kod för remarketing-taggen -->
        <!-- Remarketing-taggar får inte vara kopplade till personligt identifierande information eller placeras på sidor relaterade till känsliga kategorier. Läs mer information och anvisningar om hur du ställer in taggen på: http://google.com/ads/remarketingsetup -->
        <script type="text/javascript">
            var google_tag_params = {
                ecomm_prodid: 'REPLACE_WITH_VALUE',
                ecomm_pagetype: 'REPLACE_WITH_VALUE',
                ecomm_totalvalue: 'REPLACE_WITH_VALUE',
            };
        </script>

        <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 960992644;
            var google_custom_params = window.google_tag_params;
            var google_remarketing_only = true;
            /* ]]> */
        </script>
        <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js"></script>
        <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/960992644/?value=0&amp;guid=ON&amp;script=0"/>
        </div>
        </noscript>
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o), m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-47519445-1', 'auto');
            ga('send', 'pageview');
        </script>

    </body>
</html>