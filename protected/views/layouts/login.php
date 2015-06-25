<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="language" content="en" />
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>        

        <!-- GLOBAL STYLES -->
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <!-- PAGE LEVEL PLUGIN STYLES -->

        <!-- THEME STYLES -->
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/style.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins.css" rel="stylesheet">

        <!-- THEME DEMO STYLES -->
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/demo.css" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/html5shiv.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/respond.min.js"></script>
        <![endif]-->
        
        <link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/custom.css" rel="stylesheet">
        
    </head>

    <body class="login">

        <div class="container">
            <div class="row">
                <?php echo $content; ?>
            </div>
        </div>

        <!-- GLOBAL SCRIPTS -->
        <!--<script src="<?php //echo Yii::app()->request->baseUrl ?>/bootstrap/js/jquery.min.js"></script>-->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/bootstrap/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <!-- HISRC Retina Images -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/hisrc/hisrc.js"></script>

        <!-- PAGE LEVEL PLUGIN SCRIPTS -->

        <!-- THEME SCRIPTS -->
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/flex.js"></script>

    </body>
</html>
