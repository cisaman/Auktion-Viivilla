<?php $this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'account_verification'); ?>
<div class="col-lg-12 col-md-12 col-sm-12 betcrunb-part">
    <ul class="crumb-link">
        <li class="crumb-active"><a href="#">Viivilla.se</a></li>
        <li><a href="#">Verifiera ditt konto</a></li>
    </ul>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 product-page login-main" style="margin-bottom: 0px;">
    <div class="row">
        <div class="about-page">
            <h1 class="text-center">Verifiera ditt konto</h1>
            <div class="about-info">
            
                <?php if (Yii::app()->user->hasFlash('message')): ?>
                    <?php $type = Yii::app()->user->getFlash('type'); ?>
                    <div class="alert alert-<?php echo $type; ?>" id="successmsg" style="margin-bottom: 0px;font-size: 18px;font-weight: bold;">
                        <?php echo Yii::app()->user->getFlash('message'); ?>
                        <br/>
                        <?php if($type == 'success') { ?>
                            Du kommer automatiskt att omdirigeras till inloggningen, annars kan du <a href="<?php echo Yii::app()->createAbsoluteUrl('site/login') ?>">klicka här</a>.
                            <meta http-equiv="refresh" content="10;url=/login" />
                        <?php } else { ?>
                            Du kommer automatiskt att omdirigeras till kontakta oss, annars kan du <a href="<?php echo Yii::app()->createAbsoluteUrl('site/kontakta-oss') ?>">klicka här</a>.
                            <meta http-equiv="refresh" content="10;url=/kontakta-oss" />
                        <?php } ?>
                    </div>                    

                <?php else: ?>                   

                    <div class="alert alert-danger" id="successmsg" style="margin-bottom: 0px;font-size: 18px;font-weight: bold;">
                        You are automatically redirected to Home Page in 0 seconds or you can click <a href="<?php echo Yii::app()->createAbsoluteUrl('site/login') ?>">here</a>.
                    </div>
                    <meta http-equiv="refresh" content="0;url=/" />

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('html, body').animate({
            scrollTop: $('.about-page').offset().top - 70
        }, 1500);
    });
</script>