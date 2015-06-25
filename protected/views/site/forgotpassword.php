<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'forgot_password');

$this->breadcrumbs = array(
    Yii::t('lang', 'forgot_password'),
);
?>

<div class="col-lg-12 col-md-12 col-sm-12 product-page login-main">
    <div class="row">
        <div class="login-page-detail">
            <div class="register-here">
                <?php $this->renderPartial('_forgotpassword'); ?>
            </div>
        </div>
    </div>
</div>