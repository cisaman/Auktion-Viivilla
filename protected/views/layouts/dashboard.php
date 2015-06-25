<?php
if (Yii::app()->session['user_data']['user_role_id'] == 3) {
    Yii::app()->request->redirect('/');
}

$user_id = Yii::app()->session['admin_data']['admin_id'];
$role_id = Yii::app()->session['admin_data']['admin_role_id'];

$profile = Sellers::model()->getSellersProfile($user_id);
$firstname = $profile['sellers_fname'];
$lastname = $profile['sellers_lname'];
$photo = $profile['sellers_image'];
$role = Yii::app()->user->name;

if (!empty($photo)) {
    $photo = Utils::UserThumbnailImagePath() . $photo;
} else {
    $photo = Utils::NoImagePath();
}

$controller = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/js/jquery.js"></script>        

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="language" content="en" />
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>        

        <!-- PACE LOAD BAR PLUGIN - This creates the subtle load bar effect at the top of the page. -->
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/pace/pace.css" rel="stylesheet">
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/pace/pace.js"></script>

        <!-- GLOBAL STYLES - Include these on every page. -->
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- PAGE LEVEL PLUGIN STYLES -->
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/messenger/messenger.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/messenger/messenger-theme-flat.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/morris/morris.css" rel="stylesheet">

        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/datatables/datatables.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/css/invoice.css" />        
        
        <!-- THEME STYLES - Include these on every page. -->
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/style.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins.css" rel="stylesheet">

        <!-- THEME DEMO STYLES - Use these styles for reference if needed. Otherwise they can be deleted. -->
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/demo.css" rel="stylesheet">


        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/custom.css" rel="stylesheet">

        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div id="wrapper">

            <!-- begin TOP NAVIGATION -->
            <nav class="navbar-top" role="navigation">

                <!-- begin BRAND HEADING -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".sidebar-collapse">
                        <i class="fa fa-bars"></i> Menu
                    </button>
                    <div class="navbar-brand">
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('dashboard/index'); ?>">
                            <span style="color: #fff;font-size: 22px;font-family: Ubuntu, Helvetica Neue, Helvetica, Arial, sans-serif"><i class="fa fa-gears"></i> Auktion Viivilla</span>
                            <!--img src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/img/flex-admin-logo.png" data-1x="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/img/flex-admin-logo@1x.png" data-2x="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/img/flex-admin-logo@2x.png" class="hisrc img-responsive" alt=""-->
                        </a>
                    </div>
                </div>
                <!-- end BRAND HEADING -->

                <div class="nav-top">                    
                    <ul class="nav navbar-left">
                        <li class="tooltip-sidebar-toggle">
                            <a href="#" id="sidebar-toggle" data-toggle="tooltip" data-placement="right" title="Click here to Sidebar Toggle.">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>                      
                    </ul>                    
                    <ul class="nav navbar-right">
                        <li class="dropdown">
                            <a href="<?php echo Yii::app()->createAbsoluteUrl('site/index'); ?>" target="new" class="tasks-link">
                                <i class="fa fa-location-arrow"></i> View Site
                            </a>                            
                        </li>

                        <li class="dropdown">
                            <a data-toggle="dropdown" class="messages-link dropdown-toggle" href="#">
                                <i class="fa fa-envelope"></i>
                                <span class="number"><?php echo Contact::model()->count('contact_status=1'); ?></span> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-scroll dropdown-messages">
                                <li class="dropdown-header">
                                    <i class="fa fa-envelope"></i> <?php echo Contact::model()->count('contact_status=1'); ?> New Messages
                                </li>                                
                                <li id="" style="width: auto; max-height: 300px;overflow-y: scroll;overflow-x: hidden;">
                                    <ul class="list-unstyled">
                                        <?php $contacts = Contact::model()->findAllByAttributes(array('contact_status' => 1), array('order' => 'contact_created DESC')); ?>
                                        <?php if (count($contacts) > 0) { ?>
                                            <?php foreach ($contacts as $contact) { ?>
                                                <li>
                                                    <a href="<?php echo Yii::app()->createAbsoluteUrl('contact/view/' . $contact->contact_id); ?>">
                                                        <div class="row">                                                    
                                                            <div class="col-xs-12">
                                                                <p class="text-blue"><strong><?php echo $contact->contact_name ?></strong>:
                                                                    <span class="pull-right small">
                                                                        <i class="fa fa-clock-o"></i> <?php echo $contact->contact_created; ?>
                                                                    </span>
                                                                </p>
                                                                <p><?php echo $contact->contact_subject ?></p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <div class="row">                                                    
                                                        <div class="col-xs-12">
                                                            <p class="text-red text-center">
                                                                No messages found.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li class="dropdown-footer">                                    
                                    <a href="<?php echo Yii::app()->createAbsoluteUrl('contact/index'); ?>">
                                        Read All Messages
                                    </a>
                                </li>
                            </ul>                            
                        </li>

                        <li class="dropdown">
                            <a href="javascript:void(0);" class="alerts-link dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-language"></i> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a href="javascript:void(0);" class="lang" alt="en">
                                        <i class="fa fa-send"></i> English
                                    </a>
                                </li>                                
                                <li class="divider"></li>
                                <li>
                                    <a href="javascript:void(0);" class="lang" alt="sv">
                                        <i class="fa fa-send"></i> Swedish
                                    </a>
                                </li>                                
                            </ul>                           
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user"></i>  <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">                                
                                <li>
                                    <a href="<?php echo Yii::app()->createAbsoluteUrl('dashboard/profile'); ?>">
                                        <i class="fa fa-user"></i> <?php echo Yii::t('lang', 'my_profile'); ?>
                                    </a>
                                </li>
                                <!--li class="divider"></li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <i class="fa fa-gear"></i> Settings
                                    </a>
                                </li-->
                                <li>
                                    <a class="logout_open" href="#logout">
                                        <i class="fa fa-sign-out"></i> <?php echo Yii::t('lang', 'logout'); ?>
                                        <strong><?php echo $firstname . ' ' . $lastname; ?></strong>
                                    </a>
                                </li>
                            </ul>                           
                        </li>

                    </ul>                   

                </div>                
            </nav>

            <nav class="navbar-side" role="navigation">
                <div class="navbar-collapse sidebar-collapse collapse">

                    <ul id="side" class="nav navbar-nav side-nav">
                        <li class="side-user hidden-xs">
                            <img class="img-circle" src="<?php echo $photo; ?>" alt="" style="height: 150px;width: 150px;">
                            <p class="welcome">
                                <i class="fa fa-key"></i> <?php echo Yii::t('lang', 'logged_in_as'); ?> <span><?php echo $role; ?></span>
                            </p>
                            <p class="name tooltip-sidebar-logout">
                                <?php echo $firstname; ?>
                                <span class="last-name"><?php echo $lastname; ?></span> <a style="color: inherit" class="logout_open" href="#logout" data-toggle="tooltip" data-placement="top" title="Logout"><i class="fa fa-sign-out"></i></a>
                            </p>
                            <div class="clearfix"></div>
                        </li>                        
                        <li>                            
                            <a class="<?php echo ($controller == 'dashboard' && $action == 'index') ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('dashboard/index'); ?>">
                                <i class="fa fa-dashboard"></i> <?php echo Yii::t('lang', 'dashboard'); ?>
                            </a>
                        </li>
                        <?php if($role_id == 1) { ?>
                            <li>
                                <a class="<?php echo ($controller == 'sellers' && in_array($action, array('index', 'create', 'update', 'delete', 'view'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('sellers/index'); ?>">
                                    <i class="fa fa-calendar"></i> <?php echo Yii::t('lang', 'sellers'); ?>
                                </a>
                            </li>   
                        <?php } ?>
                        <?php if($role_id == 1) { ?>
                            <li>
                                <a class="<?php echo ($controller == 'buyers' && in_array($action, array('index', 'create', 'update', 'delete', 'view'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('buyers/index'); ?>">
                                    <i class="fa fa-calendar"></i> <?php echo Yii::t('lang', 'buyers'); ?>
                                </a>
                            </li>  
                        <?php } ?> 
                        <li>
                            <a class="<?php echo ($controller == 'product' && in_array($action, array('index', 'create', 'update', 'delete', 'view', 'show'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('product/index'); ?>">
                                <i class="fa fa-calendar"></i> <?php echo Yii::t('lang', 'products'); ?>
                            </a>
                        </li> 
                        <?php if($role_id == 1) { ?>
                        <!--li>
                            <a class="<?php echo ($controller == 'product' && in_array($action, array('biddinghistory'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('product/biddinghistory'); ?>">
                                <i class="fa fa-calendar"></i> <?php echo Yii::t('lang', 'bidding_history'); ?>
                            </a>
                        </li-->
                        <li class="panel">
                            <a href="javascript:;" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#historyBox">
                                <i class="fa fa-inbox"></i> Bidding History<i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="collapse nav" id="historyBox">
                                <li>
                                    <a class="<?php echo ($controller == 'product' && $action == 'ongoingauctions') ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/product/ongoingauctions'); ?>">
                                        <i class="fa fa-angle-double-right"></i> Ongoing Auctions
                                    </a>                                    
                                </li>                                
                                <li>
                                    <a class="<?php echo ($controller == 'product' && $action == 'closedauctions') ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/product/closedauctions'); ?>">
                                        <i class="fa fa-angle-double-right"></i> Closed Auctions
                                    </a>                                    
                                </li>
                                 <li>
                                    <a class="<?php echo ($controller == 'product' && $action == 'paidauctions') ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/product/paidauctions'); ?>">
                                        <i class="fa fa-angle-double-right"></i> Paid Auctions
                                    </a>                                    
                                </li>
                                <li>
                                    <a class="<?php echo ($controller == 'product' && $action == 'unpaidauctions') ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/product/unpaidauctions'); ?>">
                                        <i class="fa fa-angle-double-right"></i> Unpaid Auctions
                                    </a>                                    
                                </li>
                                <li>
                                    <a class="<?php echo ($controller == 'product' && $action == 'allauctions') ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/product/allauctions'); ?>">
                                        <i class="fa fa-angle-double-right"></i> All Auctions
                                    </a>                                    
                                </li>
                            </ul>
                        </li>  
                        <?php } ?> 
                        <?php if($role_id == 1) { ?>
                        <li>
                            <a class="<?php echo ($controller == 'product' && in_array($action, array('transactionhistory'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('product/transactionhistory'); ?>">
                                <i class="fa fa-calendar"></i> <?php echo Yii::t('lang', 'transaction_history'); ?>
                            </a>
                        </li>  
                        <?php } ?> 
                        <li class="panel">
                            <a href="javascript:void(0);" data-parent="#side" data-toggle="collapse" class="accordion-toggle" data-target="#setup">
                                <i class="fa fa-inbox"></i> Inställning<i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="collapse nav" id="setup">
                                <li>
                                    <a class="<?php echo ($controller == 'category' && in_array($action, array('index', 'create', 'update', 'delete', 'view'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/category/index'); ?>">
                                        <i class="fa fa-angle-double-right"></i> <?php echo Yii::t('lang', 'categories'); ?>
                                    </a>                                    
                                </li>                                
                                <li>
                                    <a class="<?php echo ($controller == 'pages' && in_array($action, array('index', 'create', 'update', 'delete', 'view'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/pages/index'); ?>">
                                        <i class="fa fa-angle-double-right"></i> <?php echo Yii::t('lang', 'pages'); ?>
                                    </a>                                    
                                </li>
                                 <?php if($role_id == 1) { ?>
                                <li>
                                    <a class="<?php echo ($controller == 'faqs' && in_array($action, array('index', 'create', 'update', 'delete', 'view'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/faqs/index'); ?>">
                                        <i class="fa fa-angle-double-right"></i> <?php echo Yii::t('lang', 'faqs'); ?>
                                    </a>                                    
                                </li>
                                <?php } ?> 
                                 <?php if($role_id == 1) { ?>
                                <li>
                                    <a class="<?php echo ($controller == 'lang' && in_array($action, array('index', 'create', 'update', 'delete', 'view'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/lang/index'); ?>">
                                        <i class="fa fa-angle-double-right"></i> <?php echo Yii::t('lang', 'languages'); ?>
                                    </a>                                    
                                </li>
                                <?php } ?> 
                                 <?php if($role_id == 1) { ?>
                                <li>
                                    <a class="<?php echo ($controller == 'template' && in_array($action, array('index', 'create', 'update', 'delete', 'view'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/template/index'); ?>">
                                        <i class="fa fa-angle-double-right"></i> <?php echo Yii::t('lang', 'templates'); ?>
                                    </a>                                    
                                </li>
                                <?php } ?> 
                                 <?php if($role_id == 1) { ?>
                                <li>
                                    <a class="<?php echo ($controller == 'invoice' && in_array($action, array('index', 'create', 'update', 'delete', 'view'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/invoice/index'); ?>">
                                        <i class="fa fa-angle-double-right"></i> <?php echo Yii::t('lang', 'invoice_templates'); ?>
                                    </a>                                    
                                </li>
                                <?php } ?> 
                            </ul>
                        </li>
                        <li>
                            <a class="<?php echo ($controller == 'contact' && in_array($action, array('index', 'view'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/contact/index'); ?>">
                                <i class="fa fa-calendar"></i> <?php echo Yii::t('lang', 'messages'); ?>
                            </a>
                        </li>  
                        <li>
                            <a class="<?php echo ($controller == 'dashboard' && in_array($action, array('profile'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/dashboard/profile'); ?>">
                                <i class="fa fa-calendar"></i> <?php echo Yii::t('lang', 'my_profile'); ?>
                            </a>
                        </li>  
                        <li>
                            <a class="<?php echo ($controller == 'log' && in_array($action, array('index'))) ? 'active' : ''; ?>" href="<?php echo Yii::app()->createAbsoluteUrl('/log/index'); ?>">
                                <i class="fa fa-list"></i> Log History
                            </a>
                        </li>  
                    </ul>
                </div>                
            </nav>

            <div id="page-wrapper">
                <div class="page-content">                   
                    <?php echo $content; ?>
                </div>
            </div>           

        </div>        


        <!-- GLOBAL SCRIPTS -->
        <!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script-->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/bootstrap/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/popupoverlay/jquery.popupoverlay.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/popupoverlay/defaults.js"></script>

        <!-- Log Out Notification Box -->
        <div id="logout">
            <div class="logout-message">
                <img class="img-circle img-logout" src="<?php echo $photo; ?>" alt="" style="height: 150px;width: 150px;">
                <h3>
                    <i class="fa fa-sign-out text-green"></i> Ready to go?
                </h3>
                <p>Select "Log Out" below if you are ready<br> to end your current session.</p>
                <ul class="list-inline">
                    <li>
                        <a href="<?php echo Yii::app()->createAbsoluteUrl('dashboard/logout'); ?>" class="btn btn-green">
                            <strong>Log Out</strong>
                        </a>
                    </li>
                    <li>
                        <button class="logout_close btn btn-green">Cancel</button>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /#logout -->
        <!-- Log Out Notification jQuery -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/popupoverlay/logout.js"></script>
        <!-- HISRC Retina Images -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/hisrc/hisrc.js"></script>

        <!-- PAGE LEVEL PLUGIN SCRIPTS -->
        <!-- HubSpot Messenger -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/messenger/messenger.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/messenger/messenger-theme-flat.js"></script>
        <!-- Date Range Picker -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/daterangepicker/moment.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/daterangepicker/daterangepicker.js"></script>        
        <!-- Flot Charts -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/flot/jquery.flot.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/flot/jquery.flot.resize.js"></script>
        <!-- Sparkline Charts -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- Moment.js -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/moment/moment.min.js"></script>
        <!-- jQuery Vector Map -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/jvectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/demo/map-demo-data.js"></script>
        <!-- Easy Pie Chart -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/easypiechart/jquery.easypiechart.min.js"></script>
        <!-- DataTables -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/datatables/jquery.dataTables.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/datatables/datatables-bs3.js"></script>

        <!-- THEME SCRIPTS -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/flex.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/demo/dashboard-demo.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/demo/advanced-tables-demo.js"></script>

        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/hisrc/hisrc.js"></script>       


        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/admin.js"></script>


        <!----------------------- Language Selector Settings  ------------------------------>
        <style type="text/css">
            .lang{display: block;}
        </style>
        <script type="text/javascript">

            var controller = '<?php echo $controller ?>';
            var action = '<?php echo $action ?>';
            var arr = ["category", "pages", "faqs", "lang", "template", "invoice"];
            var arr2 = ["ongoingauctions", "closedauctions", "paidauctions", "unpaidauctions", "allauctions"];

            $(document).ready(function() {

                $('.lang').click(function() {
                    var code = $(this).attr('alt');

                    if (code === '') {
                        code = 'sv';
                    }

                    $.get('<?php echo Utils::GetBaseUrl(); ?>/site/language', {code: code}, function(data) {
                        location.reload();
                    });
                });

                if ($.inArray(controller, arr) !== -1) {
                    $('#setup').removeClass('collapse nav');
                    $('#setup').addClass('nav in');
                }

                if(controller == 'product' && $.inArray(action, arr2) !== -1) {
                    $('#historyBox').removeClass('collapse nav');
                    $('#historyBox').addClass('nav in');
                }

            });
        </script>
        <!----------------------- Language Selector Settings  ------------------------------>

        <style type="text/css">
            .collapse.nav.in a{
                background: none repeat scroll 0 0 #16a085 !important;
            }
        </style>       
        

    </body>
</html>