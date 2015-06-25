<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'my_payment_history');

$this->breadcrumbs = array(
    Yii::t('lang', 'my_payment_history'),
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
                        <h2><?php echo Yii::t('lang', 'my_payment_history'); ?></h2>
                    </div>
                    <div class="bid-history">

                        <?php if (Yii::app()->user->hasFlash('message')) { ?>
                            <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?>" id="paymentMsg">
                                <?php echo Yii::app()->user->getFlash('message'); ?>
                            </div>
                        <?php } ?>

                        <div class="row">
                            <div class="col-sm-12">
                                <?php if (count($model) > 0) { ?>
                                    <table class="table table-responsive table-bordered table-striped mytable">
                                        <?php $count = 1; ?>
                                        <?php foreach ($model as $p) { ?>
                                            <?php
                                            //print_r($p);

                                            $product = Product::model()->findByPk($p->payment_productID);
                                            $url = Utils::GetBaseUrl() . '/auktion/' . $product->product_id . '/' . strtolower(str_replace(' ', '-', $product->product_name));

                                            $images = explode(',', $product->product_attachments);
                                            $img_thumb = array();
                                            if (!empty($images)) {
                                                foreach ($images as $img) {
                                                    if ($img != '') {
                                                        $img_thumb[] = Utils::ProductImageThumbnailPath() . $img;
                                                    }
                                                }
                                            }

                                            //print_r($p);
                                            ?>
                                            <tr>
                                                <td width="50px" class="text-center"><?php echo $count++; ?></td>
                                                <td width="120px" class="text-center">
                                                    <a href="<?php echo $url ?>" target="_blank">
                                                        <img src="<?php echo $img_thumb[0]; ?>" style="width: 100px; border: 1px solid rgb(204, 204, 204); padding: 5px; height: 80px;" class="img-responsive"/>
                                                    </a>
                                                </td>
                                                <td>
                                                    <h4><a href="<?php echo $url ?>" target="_blank"><?php echo $product->product_name; ?></a></h4>
                                                </td>
                                                <td width="380px" class="text-center">
                                                    <a href="<?php echo $url ?>" target="_blank"  class="btn btn-sm btn-primary mya"><i class="fa fa-search"></i> Visa produkt</a>

                                                    <?php $path = Utils::GetBaseUrl() . 'site/invoice?info=' . $p->payment_id . '__d'; ?>

                                                    <a href="<?php echo $path; ?>" target="_blank" class="btn btn-sm btn-success mya mydownload" data="">
                                                        <i class="fa fa-download"></i> Ladda ner betalningsbekräftelse
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                <?php } else { ?>
                                    <h4 class="text-center text-red" style="color: rgb(228, 25, 33);"><?php echo Yii::t('lang', 'no_invoice_found'); ?></h4>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="acct-log">
                            <span class="pull-left">
                                <?php echo CHtml::link(Yii::t('lang', 'paid_auctions'), Yii::app()->createAbsoluteUrl('/visa-historik/3'), array('id' => 'btnHistory', 'class' => 'log-in-box')); ?>
                            </span>
                            <?php echo CHtml::link(Yii::t('lang', 'logout'), Yii::app()->createAbsoluteUrl('site/logout'), array('id' => 'btnLogout', 'class' => 'log-in-box')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .alert {
        font-size: 18px;
        //margin-top: 20px;
        text-align: center;
    }
</style>

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
    .mytable tr td{
        vertical-align: middle !important;
    }
    .mya:hover{
        color: #fff !important;
    }

</style>

<script type="text/javascript">
    $(document).ready(function () {

        $('html, body').animate({
            scrollTop: $('.bidd-inner').offset().top - 70
        }, 1500);

    });
</script>