<html>
    <head>
        <meta charset="UTF-8">
        <title>Processing Payment...</title>
        <?php
//        $cs = Yii::app()->clientScript;
//        $cs->scriptMap = array(
//            'jquery.js' => Yii::app()->request->baseUrl . '/bootstrap/site/js/jquery.js',
//        );
//        $cs->registerCoreScript('jquery');
        ?>            

    </head>
    <body>
    <center>
        <h3>Please wait, your order is being processed...</h3>
    </center>    
    <form method="post" id="frm_post" name="form" action="<?php echo $data['url']; ?>">
        <?php
        foreach ($data['data'] as $name => $value) {
            echo "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
        }
        ?>
    </form>    

    <div id="preview1" class="preview"></div>
    <div id="preview2" class="preview"></div>      

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

    <?php if ($_SERVER['HTTP_HOST'] == 'localhost') { ?>
        <script type="text/javascript" src="http://localhost/auction_build_4_05_2015/bootstrap/site/js/spin.js"></script>
        <script type="text/javascript" src="http://localhost/auction_build_4_05_2015/bootstrap/site/js/jquery.spin.js"></script>
    <?php } else { ?>
        <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/bootstrap/site/js/spin.js"></script>
        <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/bootstrap/site/js/jquery.spin.js"></script>
    <?php } ?>

    <style type="text/css">
        h3 {
            margin-top: 70px;
        }
        .spinner > div > div {
            width: 20px !important;
        }
    </style>

    <script type="text/javascript">
        $('#preview1').spin('strong', 'black');
        $('#preview2').spin({color: '#000'});
        document.getElementById('frm_post').submit();
    </script>
</body>
</html>