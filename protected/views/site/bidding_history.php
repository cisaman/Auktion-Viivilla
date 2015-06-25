<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'my_bidding_history');

$this->breadcrumbs = array(
    Yii::t('lang', 'my_bidding_history'),
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
                        <h2><?php echo Yii::t('lang', 'my_bidding_history'); ?></h2>
                    </div>
                    <div class="bid-history">
                        <ul class="history-list account-list">
                            <li class="show" id="1" data="pågående-auktioner">
                                <div class="cal-history-left">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </div>
                                <div class="cal-history-right">
                                    <span class="account-main">
                                        <h1><?php echo Yii::t('lang', 'ongoing_auctions'); ?></h1>
                                    </span>
                                    <a href="javascript:void(0);"><?php echo Yii::t('lang', 'ongoing_auctions_msg'); ?></a>
                                </div>
                            </li>
                            <hr>
                            <li class="show" id="2" data="avslutade-auktioner">
                                <div class="cal-history-left">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </div>
                                <div class="cal-history-right">
                                    <span class="account-main">
                                        <h1><?php echo Yii::t('lang', 'closed_auctions'); ?></h1>
                                    </span>
                                    <a href="javascript:void(0);"><?php echo Yii::t('lang', 'closed_auctions_msg'); ?></a>
                                </div>
                            </li>
                            <hr>
                            <li class="show" id="4" data="obetalda-auktioner">
                                <div class="cal-history-left">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </div>
                                <div class="cal-history-right">
                                    <span class="account-main">
                                        <h1><?php echo Yii::t('lang', 'unpaid_auctions'); ?></h1>
                                    </span>
                                    <a href="javascript:void(0);"><?php echo Yii::t('lang', 'unpaid_auctions_msg'); ?></a>
                                </div>
                            </li>
                            <hr>
                            <li class="show" id="3" data="betalda-auktioner">
                                <div class="cal-history-left">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </div>
                                <div class="cal-history-right">
                                    <span class="account-main">
                                        <h1><?php echo Yii::t('lang', 'paid_auctions'); ?></h1>
                                    </span>
                                    <a href="javascript:void(0);"><?php echo Yii::t('lang', 'paid_auctions_msg'); ?></a>
                                </div>
                            </li>
                            <hr>
                            <li class="show" id="5" data="alla-auktioner">
                                <div class="cal-history-left">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                </div>
                                <div class="cal-history-right">
                                    <span class="account-main">
                                        <h1><?php echo Yii::t('lang', 'all_auctions'); ?></h1>
                                    </span>
                                    <a href="javascript:void(0);"><?php echo Yii::t('lang', 'all_auctions_msg'); ?></a>
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
    .show:hover{
        cursor: pointer !important;
    }
</style>

<script type="text/javascript">
    $('.show').click(function () {
        var id = $(this).attr('id');
        var history = $(this).attr('data');
        window.location.href = '<?php echo Utils::GetBaseUrl() ?>/' + history;

    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('html, body').animate({
            scrollTop: $('.bidd-inner').offset().top - 70
        }, 1500);
    });
</script>