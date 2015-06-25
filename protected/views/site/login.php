<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'login');

$this->breadcrumbs = array(
    Yii::t('lang', 'login'),
);
?>

<div class="col-lg-12 col-md-12 col-sm-12 product-page login-main">
    <div class="row">
        <div class="login-page-detail">
            <div class="login-header">
                <h1><?php echo Yii::t('lang', 'login'); ?></h1>
            </div>
            <div class="login-here">
                <?php $this->renderPartial('_login', array('model' => $model, 'hide_title' => 1)); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('html, body').animate({
            scrollTop: $('.login-here').offset().top - 70
        }, 1500);
    });
</script>