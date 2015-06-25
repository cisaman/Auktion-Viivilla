<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'my_account');

$this->breadcrumbs = array(
    Yii::t('lang', 'my_account'),
);
?>

<div class="col-lg-12 col-md-12 col-sm-12 product-page login-main bidding-end">
    <div class="row">
        <div class="login-page-detail">
            <div class="login-header">                
                <h1><?php echo Yii::t('lang', 'member'); ?> <?php echo $user; ?></h1>
            </div>
            <div class="bidding-main">
                <div class="bidd-inner">
                    <div class="bottom-head">
                        <h2><?php echo Yii::t('lang', 'my_account'); ?></h2>
                    </div>
                    <div class="bid-history">
                        <ul class="history-list account-list">
                            <li id="account">
                                <div class="cal-history-left">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </div>
                                <div class="cal-history-right">
                                    <span class="account-main">
                                        <h1><?php echo Yii::t('lang', 'my_profile'); ?></h1>
                                        <!--a class="log-in-box" href="<?php echo Yii::app()->createAbsoluteUrl('author/' . $id . '/' . $slug); ?>" id="viewprofile">
                                        <?php echo Yii::t('lang', 'view_profile'); ?>
                                        </a-->                                        
                                    </span>
                                    <a href="javascript:void(0);"><?php echo Yii::t('lang', 'account_history_msg'); ?></a>
                                </div>
                            </li>
                            <hr>                            
                            <li id="payment" class="show">
                                <div class="cal-history-left">
                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                </div>
                                <div class="cal-history-right">
                                    <span class="account-main">
                                        <h1><?php echo Yii::t('lang', 'my_payment_history'); ?></h1>
                                    </span>                                    
                                    <a href="javascript:void(0);"><?php echo Yii::t('lang', 'payment_history_msg'); ?></a>
                                </div>
                            </li>
                            <hr>
                            <li id="history" class="show">
                                <div class="cal-history-left">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </div>
                                <div class="cal-history-right">
                                    <span class="account-main">
                                        <h1><?php echo Yii::t('lang', 'my_bidding_history'); ?></h1>
                                    </span>
                                    <a href="javascript:void(0);"><?php echo Yii::t('lang', 'bidding_history_msg'); ?></a>
                                </div>
                            </li>
                            <hr>
                            <li id="changepassword" class="show">
                                <div class="cal-history-left">
                                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                                </div>
                                <div class="cal-history-right">
                                    <span class="account-main">
                                        <h1><?php echo Yii::t('lang', 'changepassword'); ?></h1>
                                    </span>                                    
                                    <a href="javascript:void(0);">Här kan du se din Byt lösenord</a>
                                </div>
                            </li>
                        </ul>

                        <div class="acct-log">                            
                            <?php echo CHtml::link(Yii::t('lang', 'logout'), Yii::app()->createAbsoluteUrl('site/logout'), array('id' => 'btnLogout', 'class' => 'log-in-box')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .acct-log{
        margin-top: 10px !important;
    }
    #account:hover, .show:hover{
        cursor: pointer !important;
    }
    .cal-history-right h1{
        text-transform: none !important;
    }
</style>

<script type="text/javascript">
    $('#account').click(function() {
        window.location.href = '<?php echo Utils::GetBaseUrl() ?>/min-profil';
    });

    $('#payment').click(function() {
        window.location.href = '<?php echo Utils::GetBaseUrl() ?>/mina-betalningar';
    });

    $('#history').click(function() {
        window.location.href = '<?php echo Utils::GetBaseUrl() ?>/mina-bud';
    });

    $('#changepassword').click(function() {
        window.location.href = '<?php echo Utils::GetBaseUrl() ?>/changepassword';
    });

    $('#viewprofile').click(function(e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
        return false;
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('html, body').animate({
            scrollTop: $('.bidd-inner').offset().top - 70
        }, 1500);
    });
</script>