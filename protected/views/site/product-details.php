<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'product') . ' - ' . $product['p_name'];

$session_id = 0;
if (!empty(Yii::app()->session['user_data'])) {
    $session_id = Yii::app()->session['user_data']['buyers_id'];
}

$this->breadcrumbs = array(
    strtolower(Yii::t('lang', 'product')),
    $product['p_name']
);
?>

<div class="col-lg-12 col-md-12 col-sm-12 product-page">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 sidebar-border">
            <div class="row">
                <div class="sidebar-left">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="changefont">
                                        <?php echo Yii::t('lang', 'bidding_options'); ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">                            
                                    <div class="sidebar-info">
                                        <div class="text-center" id="high_bid"></div>

                                        <?php if ($product['p_expiry'] <= 0) { ?>
                                            <div class="timing-part" style="margin: 0">
                                                <div class="bid_expired changefont" style="margin: 0;font-weight: normal;font-size: 16px;border-radius: 4px;">
                                                    <?php echo Yii::t('lang', 'bid_time_over'); ?>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="timing-part">
                                                <ul class="time-list pid_r_<?php echo $product['p_id']; ?>" key="pid_r_<?php echo $product['p_id']; ?>" data="<?php echo $product['p_expiry_date']; ?>">
                                                    <li><span class="pid_d"></span><span><?php echo Yii::t('lang', 'days') ?></span></li>
                                                    <li><span class="pid_h"></span><span><?php echo Yii::t('lang', 'hours') ?></span></li>
                                                    <li><span class="pid_m"></span><span><?php echo Yii::t('lang', 'minutes') ?></span></li>
                                                    <li><span class="pid_s"></span><span><?php echo Yii::t('lang', 'seconds') ?></span></li>
                                                </ul>            
                                            </div>
                                            <div class="log-inside hideBoxWhenExpired_pid_r_<?php echo $product['p_id']; ?>">
                                                <div class="side-log" id="highbidder_nickname_block" style="display: none;">
                                                    <span class="head-side" style="text-align: center;">
                                                        <span id="highbidder_nickname" class="left-head changefont" style="font-size: 14px;"></span>
                                                    </span>
                                                </div>

                                                <div class="side-log">
                                                    <div class="row" style="margin-bottom: 8px;">
                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                            <!--                                                            <div class="col-md-4 col-sm-6 col-xs-4" style="padding: 0px;">-->
                                                            <!--                                                                <p style="font-size: 16px; font-weight: bold; margin: 0px 0px 0px 4px; line-height: 34px;">-->
                                                            <span id="textPrice" style="display: none;"><?php echo $product['p_price']; ?></span>
                                                            <!--                                                                </p>-->
                                                            <!--                                                            </div>-->
                                                            <div class="col-md-6 col-sm-12 col-xs-6" style="padding: 0px;">
                                                                <div class="input-group" style="margin-right: 10px;">
                                                                    <input type="hidden" class="form-control" id="textBidDiff" value="<?php echo $product['p_biddiff']; ?>">
                                                                    <input type="text" class="form-control numeric" id="textBid" placeholder="<?php echo $product['p_biddiff']; ?>" style="padding: 4px; text-align: center; font-weight: bold;">
                                                                    <span class="input-group-addon" style="padding: 4px 8px;">Kr</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 col-xs-6" style="padding: 0px;">
                                                                <button type="button" class="log-in-box" id="btnBid" style="padding: 6px;width: 100%;margin: 0;">Lägg bud</button>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </div>

                                                <div id="reserve_msg_1" class="text-center"></div>
                                                <div id="reserve_msg_2" class="text-center"></div>

                                                <?php if (!empty($product['p_shipping_price'])) { ?>
                                                    <div class="detail-one" style="padding-bottom: 10px; margin-bottom: 10px;">
                                                        <ul class="seller">
                                                            <li>
                                                                <span class="sell-left"><?php echo Yii::t('lang', 'shipping_price') ?></span>
                                                                <span class="sell-right"><?php echo $product['p_shipping_price']; ?> Kr</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                <?php } ?>

                                                <?php if (!empty($product['p_buynow_price'])) { ?>
                                                    <div class="side-log" style="margin-bottom: 0px">
                                                        <div class="row" style="margin-bottom: 8px;">
                                                            <div class="col-md-12 col-sm-12 col-xs-12">                                                                
                                                                <span class="poistive" style="padding-bottom: 0">
                                                                    <a href="javascript:void(0);" class="log-in-box" data-toggle="modal" data-target="#bidModal" style="width: 100%; padding: 8px 15px;">
                                                                        <?php echo Yii::t('lang', 'buy_now') ?> <?php echo $product['p_buynow_price']; ?> Kr
                                                                    </a>
                                                                    <form name='frm_paypal' id='frm_paypal' action='<?php echo Yii::app()->createAbsoluteUrl('payment/pay'); ?>' method='post'>
                                                                        <input type='hidden' name='bn' value='PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest' />
                                                                        <input type='hidden' name='item_id' value='<?php echo $product['p_id']; ?>'>
                                                                        <input type='hidden' name='item_name' value='<?php echo $product['p_name']; ?>'>
                                                                        <input type='hidden' name='shipping' value='<?php echo $product['p_shipping_price']; ?>'>
                                                                        <input type='hidden' name='amount' value='<?php echo $product['p_buynow_price']; ?>'>                             
                                                                        <input type='hidden' name='user_id' value='<?php echo $session_id; ?>'/>
                                                                    </form>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>                                                
                                            </div>
                                        <?php } ?>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <?php if ($product['p_expiry'] <= 0) { ?>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed changefont" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <?php echo Yii::t('lang', 'bidding_history'); ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body">                                   
                                        <div class="binding-tbl">
                                            <div class="bind-in">
                                                <table border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                        <?php
                                                        $bid_history = json_decode(Bid::showWinnersWithPrice($product['p_id']));
                                                        
                                                        if ($bid_history->status == 1) {
                                                            foreach ($bid_history->result as $his) {
                                                                ?>
                                                                <tr>
                                                                    <td class="left-col" style="text-transform:none;width: 55%;">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <b style="color: rgb(66, 139, 202) ! important; font-size: 14px;">
                                                                                    Vinnare <?php echo $his->winner_number; ?>
                                                                                </b>
                                                                            </div>
                                                                            <div class="col-sm-6 pull-right">
                                                                                <span style="background: none repeat scroll 0% 0% rgb(119, 119, 119); color: rgb(255, 255, 255); padding: 3px 6px; font-size: 11px; border-radius: 10px; width: 100%; display: block; text-align: center;">
                                                                                    <?php echo $his->winner_created; ?>
                                                                                </span>
                                                                            </div>
                                                                            <div class="col-sm-12" style="margin-top: 5px;">
                                                                                <span style="color: rgb(110, 105, 99); font-size: 14px;text-transform:none;">
                                                                                    <b><?php echo substr(Buyers::model()->getUsername($his->winner_userid), 0, 14); ?></b> med <b><?php echo $his->winner_price; ?> Kr</b>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td style="text-align: center;"><?php echo Yii::t('lang', 'no_bid_history'); ?>!</td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="author-part">
                        <div class="bottom-head">
                            <h2 class="changefont"><?php echo Yii::t('lang', 'seller'); ?></h2>
                        </div>
                        <div class="author-detail">
                            <div class="detail-one">
                                <div style="margin: 0px auto; padding: 0px 15px; text-align: center;">
                                    <img src="<?php echo $product['u_image']; ?>" alt="<?php echo $product['u_name']; ?>">
                                </div> 
                                <h1 style="text-align: center; font-weight: bold; font-size: 16px; margin: 10px 0px 0px;">
                                    <?php echo $product['u_name']; ?>
                                </h1>
                            </div>

                            <?php if (count($product['u_products']) > 0) { ?>
                                <div class="detail-one">
                                    <ul class="list-group" style="text-align: center;">
                                        <li class="list-group-item">
                                            <h2 class="changefont"><?php echo Yii::t('lang', 'other_products_from_same_seller'); ?></h2>
                                        </li>
                                        <?php foreach ($product['u_products'] as $p) { ?>
                                            <li class="list-group-item">
                                                <a href="<?php echo Yii::app()->createAbsoluteUrl('auktion/' . $p['p_id'] . '/' . $p['p_slug']); ?>" class="changefont">
                                                    <?php echo $p['p_name']; ?>
                                                </a>
                                                <div class="clearfix"></div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } else { ?>
                                <div class="detail-one">
                                    <ul class="list-group" style="text-align: center;">
                                        <li class="list-group-item">
                                            <h2 class="changefont"><?php echo Yii::t('lang', 'other_products_from_same_seller'); ?></h2>
                                        </li>                                                                                
                                    </ul>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-md-8 col-sm-8 product-main">
            <div class="main-product">
                <div class="bottom-head">
                    <h2 class="changefont"><?php echo $product['p_name']; ?></h2>
                </div>               

                <?php if (!empty($product['p_images'])) { ?>
                    <div class="product-slider">                    
                        <div id="sync1" class="owl-carousel">                        
                            <?php foreach ($product['p_images'] as $img) { ?>
                                <div class="item">
                                    <a href="javascript:void(0);">
                                        <img src="<?php echo $img ?>" alt="" />
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div id="sync2" class="owl-carousel" >
                            <?php foreach ($product['p_thumbs'] as $img) { ?>
                                <div class="item">
                                    <a href="javascript:void(0);">
                                        <img src="<?php echo $img ?>" alt="" />
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="tab-part">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#home" aria-controls="home" role="tab" data-toggle="tab" class="changefont"><?php echo Yii::t('lang', 'description'); ?></a>
                            </li>                            
                            <li role="presentation">
                                <a href="#contact" aria-controls="contact" id="contact_tab" role="tab" data-toggle="tab" class="changefont"><?php echo Yii::t('lang', 'contactus'); ?></a>
                            </li>                            
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="home">                                
                                <div class="tab-content-inner" style="font-family: arial !important;">
                                    <h2 class="changefont"><?php echo $product['p_name']; ?></h2>
                                    <?php if (!empty($product['p_winners']) && $product['p_winners'] != 0) { ?>
                                        <h5 class="changefont">- <?php echo $product['p_winners']; ?> Vinnare!</h5>
                                        <div><?php echo Pages::model()->findByPk(7)->page_content; ?></div>
                                    <?php } ?>
                                    <?php echo $product['p_desc']; ?>
                                </div>
                            </div>                            
                            <div role="tabpanel" class="tab-pane" id="contact">
                                <div class="contact-tab">
                                    <div class="bottom-head">
                                        <h2>Kontakta kundservice</h2>
                                    </div>
                                    <div class="contact-tb-input">
                                        <form id="product_mail">
                                            <div class="input-field-one">
                                                <input type="text" id="yname" class="fill-part" placeholder="<?php echo Yii::t('lang', 'your_name'); ?>">
                                                <input type="text" id="ymail" class="fill-part" placeholder="<?php echo Yii::t('lang', 'your_email'); ?>">
                                            </div>
                                            <div class="input-field-one">
                                                <input type="text" id="yphone" class="fill-part" placeholder="<?php echo Yii::t('lang', 'phone'); ?>">
                                                <span class="in-box">
                                                    <span class="info-in"><?php echo Yii::t('lang', 'captach_question_1'); ?></span>
                                                    <?php
                                                    $rand1 = rand(1, 9);
                                                    $rand2 = rand(1, 9);
                                                    ?>
                                                    <input id="ycaptcha" type="text" data="<?php echo $rand1 + $rand2; ?>" class="fill-part" placeholder=" <?php echo $rand1; ?>+<?php echo $rand2; ?> ">
                                                </span>
                                            </div>
                                            <div class="input-field-one">
                                                <textarea rows="2" id="ymsg" placeholder="<?php echo Yii::t('lang', 'your_message'); ?>"></textarea>
                                            </div>
                                        </form>
                                        <div class="input-btn">
                                            <button type="button" id="send_mail_to" class="log-in-box"><?php echo Yii::t('lang', 'send_message'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="bidModal" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title text-center" id="standardModalLabel">
                    <span style="text-transform: capitalize;">Bekräfta ditt köp</span>                    
                </h4>
            </div>
            <div class="modal-body">
                <div id="agreeMsg1" class="text-center"></div>
                <table align="center" class="bidtable">
                    <tr>
                        <th><?php echo Yii::t('lang', 'product') ?></th>
                        <td>: <a href="javascript:void(0);"><?php echo $product['p_name']; ?></a></td>
                    </tr>
                    <tr>
                        <th>Pris</th>
                        <td>: <a href="javascript:void(0);"><?php echo $product['p_buynow_price']; ?> Kr</a></td>
                    </tr>
                    <?php if (!empty($product['p_shipping_price'])) { ?>
                        <tr>
                            <th>Frakt</th>
                            <td>: <a href="javascript:void(0);"><?php echo $product['p_shipping_price']; ?> Kr</a></td>
                        </tr>
                    <?php } ?>
                </table>                
                <hr style="margin: 5px;">
                <p class="text-center">
                    <input type="checkbox" id="btnCheck"/> Jag har läst <a title="köpvillkoren" target="_new" href="<?php echo Yii::app()->createAbsoluteUrl('site/terms_conditions') ?>">köpvillkoren</a>.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Avbryt</button>
                <button type="button" class="btn btn-success" id="btnAgree">Godkänn köp</button>
            </div>
        </div>        
    </div>    
</div>
<!-- Modal -->


<!-- Modal -->
<div class="modal fade" id="bidConfirmModal" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title text-center" id="standardModalLabel">
                    <?php echo Yii::t('lang', 'bid_confirmation'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <div id="agreeMsg2" class="text-center"></div>
                <table align="center" class="bidtable">
                    <tr>
                        <th width="100px"><?php echo Yii::t('lang', 'product'); ?></th>
                        <td>: <a href="javascript:void(0);"><?php echo $product['p_name']; ?></a></td>
                    </tr>
                    <tr>
                        <th><?php echo Yii::t('lang', 'bid_value'); ?></th>
                        <td>: <span id="setBidValue"></span> Kr</td>
                    </tr>
                </table>                
                <hr style="margin: 5px;">                
                <p class="text-center">
                    <input type="checkbox" id="btnCheck2"/> Jag har läst <a title="auktionsvillkoren" target="_new" href="<?php echo Yii::app()->createAbsoluteUrl('site/terms_conditions') ?>">auktionsvillkoren</a>.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnNoBidConfirm">Avbryt</button>
                <button type="button" class="btn btn-success" id="btnYesBidConfirm">Godkänn bud</button>
            </div>
        </div>        
    </div>    
</div>
<!-- Modal -->


<!-- Modal -->
<div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title text-center" id="standardModalLabel"><?php echo Yii::t('lang', 'message'); ?></h4>
            </div>
            <div class="modal-body">
                <p id="modalMsg" class="text-center"></p>
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-success" id="btnmsgModal" data=""><?php echo Yii::t('lang', 'ok'); ?></button>
            </div>
        </div>        
    </div>    
</div>
<!-- Modal -->


<div class="modal fade" id="showHistoryModal" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title text-center" id="standardModalLabel"><?php echo Yii::t('lang', 'bidding_history'); ?></h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped text-center showTable">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Date Time</th>
                    </tr>
                    <?php
                    $bid_result = Bid::model()->findAllByAttributes(array('bid_productID' => $product['p_id']), array('order' => 'bid_created DESC'));
                    if (count($bid_result) > 0) {
                        $cc = 1;
                        foreach ($bid_result as $rec) {
                            ?>
                            <tr>
                                <td><?php echo $cc++; ?></td>
                                <td><?php echo Buyers::model()->getUsername($rec->bid_buyersID); ?></td>
                                <td><?php echo $rec->bid_value; ?> Kr</td>
                                <td><?php echo $rec->bid_created; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
            </div>            
        </div>        
    </div>    
</div>


<script>

    var product_reserve_price = '<?php echo $product['p_reserve_price'] ?>';

    $(document).ready(function() {


        var sync1 = $("#sync1");
        var sync2 = $("#sync2");
        sync1.owlCarousel({
            autoPlay: 2000, //Set AutoPlay to 3 seconds
            pagination: false,
            stopOnHover: true,
            lazyLoad: true,
            singleItem: true,
            slideSpeed: 1000,
            navigation: true,
            afterAction: syncPosition,
            responsiveRefreshRate: 200,
        });
        sync2.owlCarousel({
            autoPlay: 2000, //Set AutoPlay to 3 seconds
            pagination: false,
            stopOnHover: true,
            lazyLoad: true,
            items: 5,
            itemsDesktop: [1199, 5],
            itemsDesktopSmall: [979, 5],
            itemsTablet: [768, 4],
            itemsMobile: [479, 2],
            responsiveRefreshRate: 100,
            navigation: true,
            afterInit: function(el) {
                el.find(".owl-item").eq(0).addClass("synced");
            },
        });
        function syncPosition(el) {
            var current = this.currentItem;
            $("#sync2")
                    .find(".owl-item")
                    .removeClass("synced")
                    .eq(current)
                    .addClass("synced")
            if ($("#sync2").data("owlCarousel") !== undefined) {
                center(current)
            }

        }
        $("#sync2").on("click", ".owl-item", function(e) {
            e.preventDefault();
            var number = $(this).data("owlItem");
            sync1.trigger("owl.goTo", number);
        });
        $("#send_mail_to").click(function() {
            var messages = [];
            var yname = $("#yname").val();
            var ymail = $("#ymail").val();
            var yphone = $("#yphone").val();
            var ycaptcha = $("#ycaptcha").val();
            var ymsg = $("#ymsg").val();
            var captcha_val = $("#ycaptcha").attr("data");
            if ($.trim(yname) == '') {
                messages.push("<p>Vänligen ange ditt namn</p>");
            }
            if ($.trim(ymail) == '') {
                messages.push("<p>Vänligen ange din e-mail</p>");
            }
            if ($.trim(ymail) != '' && !ymail.match(/^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/)) {
                messages.push("<p>Vänligen ange en giltig e-mail</p>");
            }
            if ($.trim(yphone) == '') {
                messages.push("<p>Vänligen ange ditt telefonnummer</p>");
            }
            if ($.trim(captcha_val) !== $.trim(ycaptcha)) {
                messages.push("<p>Vänligen ange rätt summa</p>");
            }
            if ($.trim(ymsg) == "") {
                messages.push("<p>Vänlige skriv ditt meddelande</p>");
            }
            if (messages != '') {
                $('#modalMsg').html(messages);
                $('#msgModal').modal('show');
                return false;
            }
            var product_id = <?php echo $product['p_id']; ?>;
            $.ajax({
                url: '<?php echo Utils::GetBaseUrl(); ?>/site/product_mail',
                data: ({yname: yname, ymail: ymail, yphone: yphone, ymsg: ymsg, pid: product_id}),
                type: "post",
                success: function() {
                    $("#yname").val('');
                    $("#ymail").val('');
                    $("#yphone").val('');
                    $("#ymsg").val('');
                    $("#ycaptcha").val('');
                    $('#modalMsg').html("<?php echo Yii::t('lang', 'message_sent_successfully'); ?>");
                    $('#msgModal').modal('show');
                }
            })
        });
        function center(number) {
            var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
            var num = number;
            var found = false;
            for (var i in sync2visible) {
                if (num === sync2visible[i]) {
                    var found = true;
                }
            }

            if (found === false) {
                if (num > sync2visible[sync2visible.length - 1]) {
                    sync2.trigger("owl.goTo", num - sync2visible.length + 2)
                } else {
                    if (num - 1 === -1) {
                        num = 0;
                    }
                    sync2.trigger("owl.goTo", num);
                }
            } else if (num === sync2visible[sync2visible.length - 1]) {
                sync2.trigger("owl.goTo", sync2visible[1])
            } else if (num === sync2visible[0]) {
                sync2.trigger("owl.goTo", num - 1)
            }
        }

    });</script>

<script>
    $(document).ready(function() {
        $("#redirect_url").val(window.location.href);
        $("#pro_list").owlCarousel({
            autoPlay: 2000, //Set AutoPlay to 3 seconds
            pagination: false,
            stopOnHover: true,
            lazyLoad: true,
            items: 3,
            itemsDesktop: [1199, 2],
            itemsDesktopSmall: [979, 2],
            itemsTablet: [768, 2],
            itemsTabletSmall: [480, 1],
            navigation: true,
        });
        $('#bidConfirmModal').modal('hide');
        $('#btnBid').click(function() {

            $('#agreeMsg2').removeClass('alert alert-danger');
            $('#agreeMsg2').html('');

            if ($('#textBid').val().length != 0) {
                var textBidDiff = parseInt($('#textBidDiff').val());
                var textBid = parseInt($('#textBid').val());
                if (textBid >= textBidDiff) {
                    $('#setBidValue').html(textBid);
                    $('#btnCheck2').prop('checked', false);
                    $('#bidConfirmModal').modal('show');
                } else {
                    $('#modalMsg').html("<?php echo Yii::t('lang', 'difference_amount_message'); ?>!");
                    $('#msgModal').modal('show');
                }
            } else {
                $('#modalMsg').html("<?php echo Yii::t('lang', 'please_input_bid_amount'); ?>!");
                $('#msgModal').modal('show');
            }
        });
        $('#btnYesBidConfirm').click(function() {

            var isChecked = $('#btnCheck2').prop('checked');
            if (isChecked) {
                $('#bidConfirmModal').modal('hide');
                var product_id = <?php echo $product['p_id']; ?>;
                var user_id = <?php echo $product['p_userid']; ?>;
                var session_user_id = <?php echo $session_id; ?>;
                var textBid = parseInt($('#textBid').val());
                //var textBidDiff = parseInt($('#textBidDiffPrice').text());                 var textBidDiff = parseInt($('#textBid').attr('placeholder'));

                if (session_user_id == 0) {
                    $('#modalMsg').html("<?php echo Yii::t('lang', 'cant_bid_login_msg'); ?>!");
                    $('#btnmsgModal').attr('data', '1');
                    $('#msgModal').modal('show');
                } else {
                    if (user_id == session_user_id) {
                        $('#modalMsg').html("<?php echo Yii::t('lang', 'cant_bid_own_product'); ?>!");
                        $('#msgModal').modal('show');
                    } else {
                        $('#loading').show();
                        
                        $.ajax({
                            async: false,
                            url: '<?php echo Utils::GetBaseUrl(); ?>/site/bid',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {pid: product_id, uid: session_user_id, val: textBid},
                            success: function(result) {

                                if (result['check_status'] != '') {
                                    $('#modalMsg').html(result['check_status']);
                                    $('#loading').hide();
                                    $('#msgModal').modal('show');
                                    return false;
                                }

                                getNicknameOfHigherBiddder(product_id, result['val']);
                                if (result['address'] != '') {
                                    $('#modalMsg').html(result['address']);
                                    $('#btnmsgModal').attr('data', '10');
                                    $('#loading').hide();
                                    $('#msgModal').modal('show');
                                } else {

                                    $('#textBid').attr('placeholder', result['dif']);
                                    $('#textBidDiff').val(result['dif']);
                                    $('#textPrice').text(result['val']);
                                    if (result['out_bid'] != '') {
                                        $('#high_bid').addClass('alert alert-danger');
                                        $('#high_bid').html(result['out_bid']);
                                    } else {
//                                        $('#high_bid').removeClass('alert alert-danger');
//                                        $('#high_bid').html('');
                                    }

                                    setInterval(function() {
                                        $('#high_bid').removeClass('alert alert-danger');
                                        $('#high_bid').html('');
                                    }, 10000);

                                    socket.emit('server_receive', {product_id : product_id});

                                    $('#modalMsg').html(result['status']);
                                    
                                    if (result['c_val'] == '101') {
                                        $('#btnmsgModal').attr('data', '2');
                                    }
                                    
                                    $('#loading').hide();
                                    $('#msgModal').modal('show');

                                    if (result['c_val'] != '101') {
                                        if (product_reserve_price != null || product_reserve_price != '') {
                                            if (product_reserve_price > textBid) {
                                                var data = '<i class="fa fa-times" style="color: red;"></i> <?php echo Yii::t('lang', 'reserve_price_not_met_msg'); ?>.';
                                                $('#reserve_msg_1').html(data);
                                            } else {
                                                var data = '<i class="fa fa-check" style="color: green;"></i> <?php echo Yii::t('lang', 'reserve_price_met_msg'); ?>.';
                                                $('#reserve_msg_1').html(data);
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
            } else {
                $('#agreeMsg2').addClass('alert alert-danger');
                $('#agreeMsg2').html('<?php echo Yii::t('lang', 'please_check_the'); ?> <?php echo Yii::t('lang', 'terms_conditions'); ?>.');
            }
        });
        $('#btnAgree').click(function() {
            var isChecked = $('#btnCheck').prop('checked');
            if (isChecked) {
                if (<?php echo $session_id; ?> == 0) {
                    $("#bidModal").modal("hide");
                    if (confirm("<?php echo Yii::t('lang', 'cant_buy_auction_msg'); ?>")) {
                        //window.location.href = "<?php //echo Yii::app()->createAbsoluteUrl('login');                                                                                                                                                         ?>";
                        $('html, body').animate({
                            scrollTop: $('.right-login').offset().top - 10
                        }, 1000);
                        $(".log-in").find("a").click();
                    }
                    return false;
                }
                $('#agreeMsg1').removeClass('alert alert-danger');
                $('#agreeMsg1').html('');
                $('#bidModal').modal('hide');
                $("#frm_paypal").submit();
            } else {
                $('#agreeMsg1').addClass('alert alert-danger');
                $('#agreeMsg1').html('<?php echo Yii::t('lang', 'please_check_the'); ?> <?php echo Yii::t('lang', 'terms_conditions'); ?>.');
            }
        });
        $('#btnmsgModal').click(function() {
            $('#msgModal').modal('hide');
            if ($(this).attr('data') == '1') {
                $('html, body').animate({
                    scrollTop: $('.right-login').offset().top - 10
                }, 1000);
                $(".log-in").find("a").click();
            } else if ($(this).attr('data') == '2') {
                window.location.href = '<?php echo Utils::GetBaseUrl() ?>/visa-historik/4';
            } else if ($(this).attr('data') == '10') {
                window.location.href = '<?php echo Utils::GetBaseUrl() ?>/profile';
            } else {
                $(this).attr('data', '');
            }
            $('#textBid').val('');
            $('#textBid').focus();
        });
    });</script>

<script type="text/javascript">
    setTime = 0;
    $(document).ready(function() {
        $('.contact_seller').click(function() {
            $('#contact_tab').tab('show');
            $('html, body').animate({
                scrollTop: $("#contact_tab").offset().top - 30
            }, 1000);
        });
    });
</script>

<style type="text/css">
    .bid_expired {background: none repeat scroll 0 0 rgb(239, 63, 68);color: #fff;font-size: 20px;font-weight: bold;padding: 10px;text-align: center;vertical-align: middle;}
    #home{overflow: hidden;}    
    .product-page{margin: 0px !important;}
    .upper-group{width: 55% !important;}    
    .rupees{width:30% !important;}
    .input-field{width:68% !important;}
    .left-col{width: 35%;font-size: 12px !important;}
    .right-col{width: 55%;}
    .bidtable{margin-bottom: 10px;}
    .bidtable td {padding: 2px 10px;}
    .left-head{font-size: 16px;}
    /*#sync2 .item{height: 78px !important;}*/
    #showBidHistory {background: none repeat scroll 0% 0% transparent; color: rgb(119, 119, 119); font-size: 16px ! important; font-weight: bolder ! important;}
    #showBidHistory:hover {color: #428bca !important;}
    .showTable td {padding: 4px !important;}
    #sync2 .item { height:auto !important; line-height:20px !important;}
    #sync2 > div.owl-wrapper-outer { margin:0px !important;}
    #sync2 > div.owl-wrapper-outer > div > div > div > a > img  { padding:2px !important;}
    .tab-content-inner > ul {list-style: inside none disc !important;}
</style>

<script type="text/javascript">

    $('#showBidHistory').click(function() {
        $('#showHistoryModal').modal('show');
    });

    $(document).ready(function() {
        $('html, body').animate({
            scrollTop: $('.sidebar-left').offset().top - 50
        }, 1500);
    });
    flag_check = true;
    flag_out = true;
    xhr = "";
   
    function getUpBid() {
        var product_id = <?php echo $product['p_id']; ?>;
        if (xhr != "") {
            // console.log(xhr);
            xhr.abort;
        }
        xhr = $.ajax({url: '<?php echo Utils::GetBaseUrl(); ?>/site/get_updbid',
            type: 'POST',
            dataType: 'JSON',
            data: {pid: product_id},
            success: function(result) {
                //console.log(result.bid_diff)
                $('#textBidDiff').val(result.bid_diff);
                $('#textBid').attr("placeholder", result.bid_diff);
                getNicknameOfHigherBiddder(product_id, result.bid_val);

                if (result.product_expiry_date < 0) {
                    flag_check = false;
                } else {
                    flag_out = false;
                }
                if (flag_check === false && result.product_expiry_date > 0) {
                    window.location.reload();
                }
                if (flag_out === false && result.product_expiry_date < 0) {
                    window.location.reload();
                }
                $("#textPrice").text(result.bid_val);
            }
        });
    }
    /* ----------------------------------------------------------------------------------------------------------------------------------------------
     Block Alphabets
     ----------------------------------------------------------------------------------------------------------------------------------------------*/
    /* Block Alphabets, Eg. for Contact Field */
    jQuery('.numeric').keydown(function(e) {
        // If you want decimal(.) please use 190 in inArray.
        // Allow: backspace, delete, tab, escape, enter.
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                // Allow: Ctrl+A
                        (e.keyCode == 65 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
    /*----------------------------------------------------------------------------------------------------------------------------------------------*/

    var value = $('#textPrice').text();

    getNicknameOfHigherBiddder(<?php echo $product['p_id']; ?>, value);

    function getNicknameOfHigherBiddder(p_id, val) {
        $.ajax({
            url: '<?php echo Utils::GetBaseUrl() ?>/site/highBidder/',
            data: {pid: p_id},
            type: 'POST',
            success: function(res) {
                if (res != '0') {
                    $('#highbidder_nickname').html('<strong>' + res + '</strong> har ledande bud: <strong>' + val + ' Kr</strong>');
                    $('#highbidder_nickname_block').show();
                }
            }
        });
    }

    var session_user_id = <?php echo $session_id; ?>;
    if (session_user_id != '' && session_user_id != null) {
        getReservePriceMsg(<?php echo $product['p_id']; ?>, session_user_id);
    }

    function getReservePriceMsg(p_id, u_id) {
        $.ajax({
            url: '<?php echo Utils::GetBaseUrl() ?>/site/getReservePriceMsg/',
            data: {pid: p_id, uid: u_id},
            type: 'POST',
            success: function(res) {
                if (res != "0") {
                    if (parseInt(product_reserve_price) >= parseInt(res)) {
                        var data = '<i class="fa fa-times" style="color: red;"></i> <?php echo Yii::t('lang', 'reserve_price_not_met_msg'); ?>.';
                        $('#reserve_msg_1').html(data);
                    } else {
                        var data = '<i class="fa fa-check" style="color: green;"></i> <?php echo Yii::t('lang', 'reserve_price_met_msg'); ?>.';
                        $('#reserve_msg_1').html(data);
                    }
                }

//                if (res > 0) {
//                    if (textBid >= reserve_price) {
//                        var data1 = '<div class="side-log">';
//                        data1 += '<div class="side-log" style="margin-bottom: 0px;text-align: center;">';
//                        data1 += "<?php echo Yii::t('lang', 'your_max_bid_is'); ?> " + textBid + " Kr <?php echo Yii::t('lang', 'and_the_sellers_reserve_price_is'); ?> " + reserve_price + " Kr. <br/><?php echo Yii::t('lang', 'max_bid_last_string_text'); ?>";
//                        data1 += '</span></div>';
//                        var data2 = '<i class="fa fa-check" style="color: green;"></i> <?php echo Yii::t('lang', 'reserve_price_met_msg'); ?>.';
//                        $('#reserve_price_msg_2').html(data1);
//                        $('#reserve_price_msg_1').html(data2);
//                    }
//                }
            }
        });
    }




</script>


