<!DOCTYPE html>
<html>
    <head>
        <script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/site/js/jquery.js"></script>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="language" content="en" />
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="format-detection" content="telephone=no"/>

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <style type="text/css">
            body{
                margin: 0 auto;
                padding: 0;
                text-align: center;
                margin-top: 100px;
                color: #005f8d;
            }
            h1{
                font-size: 44px;
            }
            div{
                font-size: 24px;
            }
            input[type=button]{
                border:none;
                background: green;
                color: #FFF;
                padding: 10px;
            }
        </style>

    </head>

    <body>

        <?php echo $content; ?>

    </body>
</html>