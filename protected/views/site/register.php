<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'my_account') . ' / ' . Yii::t('lang', 'register');

$this->breadcrumbs = array(
    Yii::t('lang', 'register'),
);
?>

<div class="col-lg-12 col-md-12 col-sm-12 product-page login-main">
    <div class="row">
        <div class="login-page-detail">
            <div class="login-header">
                <h1 class="changefont"><?php echo Yii::t('lang', 'new_account'); ?></h1>
            </div>            
            <div class="register-here">
                <?php $this->renderPartial('_register', array('model' => $model)); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        $(".lower-field").hide();
        $(".download").show();

        $('.download').click(function() {
            $(".lower-field").slideToggle();
        });

    });

</script>