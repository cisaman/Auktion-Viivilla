<div id="maincontent">

    <?php
    $this->pageTitle = Yii::app()->name . ' | Avslutade auktioner';

    $session_id = 0;
    if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
        $session_id = Yii::app()->session['user_data']['buyers_id'];
    }

    $this->breadcrumbs = array(
        'Avslutade auktioner',
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
                            <h2>
                                Avslutade auktioner
                                <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : 10; ?>
                                <div class="btn-group pull-right" style="top: -5px;">
                                    <a class="btn btn-default btn-sm" data-toggle="dropdown" href="#">
                                        <span class="glyphicon glyphicon-sort-by-order"></span> Records per page:
                                        <span class="label label-success order_title"></span>
                                    </a>
                                    <ul class="dropdown-menu recordsperpage">
                                        <li style="text-align:center;">Antal auktioner per sida</li>
                                        <li class="divider"></li>
                                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="name" data-value="5">5</a></li>
                                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="name" data-value="10">10</a></li>
                                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="name" data-value="15">15</a></li>
                                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="name" data-value="25">25</a></li>
                                        <li><a rel="nofollow" href="javascript:void(0);" class="order" data-name="name" data-value="50">50</a></li>
                                    </ul>
                                </div>
                            </h2>
                        </div>
                        <div class="bidd-part">
                            <?php if (count($result) > 0) { ?>
                                <?php foreach ($result as $p) { ?>
                                    <div class="part-detail" style="background: #fff;" id="productBox_pid_<?php echo $p['p_id']; ?>">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <div class="bid-left" style="width: 100%">
                                                    <div class="row">
                                                        <div class="col-sm-3 pid_each_<?php echo $p['p_id']; ?>">
                                                            <a href="<?php echo Yii::app()->createAbsoluteUrl('auktion/' . $p['p_id'] . '/' . $p['p_slug']); ?>" style="width: 100%;">
                                                                <img src="<?php echo $p['p_thumbs']; ?>" alt="product">
                                                            </a>
                                                        </div>

                                                        <div class="col-sm-5">
                                                            <div class="bid-info" style="margin: 0px;width:85%">

                                                                <div class="text-center" id="high_bid_<?php echo $p['p_id']; ?>"></div>

                                                                <h4><a href="<?php echo Yii::app()->createAbsoluteUrl('auktion/' . $p['p_id'] . '/' . $p['p_slug']); ?>" alt="<?php echo $p['p_name']; ?>"><?php echo $p['p_name']; ?></a></h4>
                                                                <!--p style="text-align:justify;-ms-word-break: break-all;word-break: break-all;"><?php echo $p['p_desc']; ?></p-->

                                                                <?php $myresult = json_decode($p['result']); ?>
                                                                <?php if ($p['p_expiry'] > 0) { ?>                                                                
                                                                    <h5><?php echo Yii::t('lang', 'bidding_ends_in'); ?></h5>
                                                                    <ul class="time-list pid_r_<?php echo $p['p_id']; ?>" key="pid_r_<?php echo $p['p_id']; ?>" data="<?php echo $p['p_expiry_date']; ?>">
                                                                        <li><span class="pid_d">00</span><span><?php echo Yii::t('lang', 'days'); ?></span></li>
                                                                        <li><span class="pid_h">00</span><span><?php echo Yii::t('lang', 'hours'); ?></span></li>
                                                                        <li><span class="pid_m">00</span><span><?php echo Yii::t('lang', 'minutes'); ?></span></li>
                                                                        <li><span class="pid_s">00</span><span><?php echo Yii::t('lang', 'seconds'); ?></span></li>
                                                                    </ul>                                                                
                                                                <?php } else { ?>

                                                                    <?php
                                                                    $key_array = array();
                                                                    foreach ($myresult->result as $key) {
                                                                        if ($session_id == $key->winner_userid) {
                                                                            $key_array = $key;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <?php if (!empty($key_array)) { ?>
                                                                        <h1 style="margin: 10px 0;">Du är vinnare #<?php echo $key_array->winner_number; ?></h1>
                                                                    <?php } else { ?>
                                                                        <h2 style="margin: 10px 0;">Tyvärr vann du inte, vi önskar dig bättre lycka nästa gång.</h2>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">                                                        

                                                            <?php if ($p['p_expiry'] < 0) { ?>

                                                                <?php if (isset($p['p_price']) && !empty($p['p_price'])) { ?>
                                                                    <div class="side-log" id="highbidder_nickname_block_<?php echo $p['p_id']; ?>">
                                                                        <span class="head-side" style="text-align: center;">
                                                                            <span id="highbidder_nickname_<?php echo $p['p_id']; ?>" class="left-head" style="font-size: 14px; font-weight: normal ! important; font-family: 'latoregular' !important;"></span>
                                                                        </span>
                                                                    </div>                                                                       
                                                                    <span class="num price_<?php echo $p['p_id']; ?>" style="display:none;"><?php echo $p['p_price']; ?></span>
                                                                <?php } ?>

                                                                <?php if ($p['p_shipping_price']) { ?>
                                                                    <div class="current-price" style="float: none;width: 100%;margin-top: 5px;">
                                                                        <span><?php echo Yii::t('lang', 'shipping_price') ?>:</span>
                                                                        <span class="num"><?php echo $p['p_shipping_price']; ?> Kr</span>
                                                                    </div>                                            
                                                                <?php } ?>     

                                                                <?php if (!empty($key_array)) { ?>
                                                                    <?php $amount = $key_array->winner_price; ?>
                                                                    <div class="current-price" style="border: medium none; background: none repeat scroll 0% 0% transparent; padding: 0px;width: 100%;">
                                                                        <form name='frm_paypal' id='frm_paypal' action='<?php echo Yii::app()->params['site_url']; ?>payment/pay' method='post'>
                                                                            <input type='hidden' name='bn' value='PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest' />
                                                                            <input type='hidden' name='item_id' value='<?php echo $p['p_id']; ?>'>
                                                                            <input type='hidden' name='item_name' value='<?php echo $p['p_name']; ?>'>
                                                                            <input type='hidden' name='shipping' value='<?php echo $p['p_shipping_price']; ?>'>
                                                                            <input type='hidden' name='amount' value='<?php echo $amount; ?>'>
                                                                            <input type='hidden' name='user_id' value='<?php echo $session_id; ?>'/>
                                                                            <input type='submit' style="margin-top: 10px; width: 100%;" class='log-in-box manage-btn display-hgt' value="Betala <?php echo $amount + $p['p_shipping_price']; ?> Kr"/>
                                                                        </form>
                                                                    </div>
                                                                <?php } else { ?>
                                                                    <button class="log-in-box chng-blue" type="button" onclick="window.location = '/'" style="width: 100%;padding: 8px;margin-top: 10px;">
                                                                        Ta mig till andra auktioner
                                                                    </button>
                                                                <?php } ?>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <!--div class="bid-right" style="width: 28%"-->
                                                <div class="bid-list" style="margin: 0px; width: 100%;">
                                                    <h2><?php echo Yii::t('lang', 'your_bids'); ?></h2>
                                                    <ul class="bid-user bid-user-list-<?php echo $p['p_id']; ?>">
                                                        <?php foreach ($p['bids'] as $b) { ?>
                                                            <li>
                                                                <span class="bid-num" style="width: 30%">
                                                                    <?php echo $b['b_value']; ?> Kr
                                                                </span>
                                                                <span class="bid-time" style="width: 65%">
                                                                    <a href="javascript:void(0);">                                                            
                                                                        <?php echo $b['b_created']; ?>
                                                                    </a>
                                                                </span>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>                                        
                                                </div>
                                                <!--/div-->
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <h4 class="text-center text-red"><?php echo Yii::t('lang', 'no_auction_found'); ?></h4>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-right">
                                    <?php
                                    $this->widget('CLinkPager', array(
                                        'header' => '',
                                        'firstPageLabel' => '<<',
                                        'prevPageLabel' => '<',
                                        'nextPageLabel' => '>',
                                        'lastPageLabel' => '>>',
                                        'pages' => $pages,
                                        'htmlOptions' => array('class' => 'pagination'),
                                        'selectedPageCssClass' => 'active',
                                        'previousPageCssClass' => 'prev',
                                        'nextPageCssClass' => 'next',
                                        'hiddenPageCssClass' => 'disabled',
                                        'maxButtonCount' => 5,
                                    ));
                                    ?>
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
<div class="modal fade" id="bidConfirmModal" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true">
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
                        <th><?php echo Yii::t('lang', 'product'); ?></th>
                        <td>: <a href="javascript:void(0);"><span id="setBidProductName"></span></a></td>
                    </tr>
                    <tr>
                        <th><?php echo Yii::t('lang', 'bid_value'); ?></th>
                        <td>: <a href="javascript:void(0);"><span id="setBidValue"></span> Kr</a></td>
                    </tr>
                </table>                
                <hr style="margin: 5px;">                
                <p class="text-center">
                    <input type="checkbox" id="btnCheck2"/> Jag har läst <a title="auktionsvillkoren" target="_new" href="<?php echo Yii::app()->createAbsoluteUrl('site/terms_conditions') ?>">auktionsvillkoren</a>.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnNoBidConfirm"><?php echo Yii::t('lang', 'no'); ?></button>
                <button type="button" class="btn btn-success" id="btnYesBidConfirm"><?php echo Yii::t('lang', 'yes'); ?></button>
            </div>
        </div>        
    </div>    
</div>
<!-- Modal -->


<!-- Modal -->
<div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true">
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

<style type="text/css">
    .bid-num{text-align: right;}
    .bid-time{text-align: center;}
    .text-red{color: rgb(228,25,33);}   
    .chng-blue{background-color: #428bca !important;}
    .bid-dollar {width: 185px !important;}
    .bid-user > li {width: 100% !important;}
    .recordsperpage li a {text-align: right;}
</style>

<script type="text/javascript">

    setTime = 0;
    $(document).ready(function () {
        function get_expiry() {
            var product_id = <?php echo!empty($p['p_id']) ? $p['p_id'] : 0; ?>;

            $.ajax({
                async: false,
                url: '<?php echo Utils::GetBaseUrl(); ?>/site/get_exp',
                type: 'POST',
                data: {pid: product_id},
                success: function (result) {
                    setTime = result;
                }
            });
        }

        var pid = '';

        $('#bidConfirmModal').modal('hide');
        $('button[id^="btnBid"]').click(function () {
            pid = $(this).attr('pid');

            if ($('#textBid' + pid).val().length != 0) {
                var textBidDiff = parseInt($('#textBid' + pid).attr('placeholder'));
                var textBid = parseInt($('#textBid' + pid).val());
                var productName = $(this).attr('pname');
                if (textBid >= textBidDiff) {
                    $('#setBidProductName').html(productName);
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


        $('#btnYesBidConfirm').click(function () {

            var isChecked = $('#btnCheck2').prop('checked');

            if (isChecked) {
                $('#bidConfirmModal').modal('hide');
                var product_id = $('#btnBid' + pid).attr('pid');
                var user_id = $('#btnBid' + pid).attr('uid');
                var session_user_id = $('#btnBid' + pid).attr('sessionid');
                var textBid = parseInt($('#textBid' + pid).val());

                if (session_user_id == 0) {
                    $('#modalMsg').html("<?php echo Yii::t('lang', 'cant_bid_login_msg'); ?>!");
                    $('#btnmsgModal').attr('data', '1');
                    $('#msgModal').modal('show');
                } else {
                    if (user_id == session_user_id) {
                        $('#modalMsg').html("<?php echo Yii::t('lang', 'cant_bid_own_product'); ?>!");
                        $('#msgModal').modal('show');
                    } else {
                        $.ajax({
                            async: false,
                            url: '<?php echo Utils::GetBaseUrl(); ?>/site/bid',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {pid: product_id, uid: session_user_id, val: textBid},
                            success: function (result) {
                                $('#textBid' + product_id).val('');

                                if (result['check_status'] != '') {
                                    $('#modalMsg').html(result['check_status']);
                                    $('#msgModal').modal('show');
                                    return false;
                                }

                                if (result['address'] != '') {
                                    $('#modalMsg').html(result['address']);
                                    $('#btnmsgModal').attr('data', '10');
                                    $('#msgModal').modal('show');
                                } else {
                                    $('#textBid').attr('placeholder', result['dif']);
                                    $('#textBidDiff').val(result['dif']);
                                    $('#textPrice').text(result['val']);

                                    socket.emit('server_receive', {product_id: product_id});

                                    if (result['out_bid'] != '') {
                                        $('#high_bid_' + product_id).addClass('alert alert-danger');
                                        $('#high_bid_' + product_id).html(result['out_bid']);
                                    } else {
                                        $('#high_bid_' + product_id).removeClass('alert alert-danger');
                                        $('#high_bid_' + product_id).html('');
                                    }

                                    setInterval(function () {
                                        $('#high_bid_' + product_id).removeClass('alert alert-danger');
                                        $('#high_bid_' + product_id).html('');
                                    }, 10000);

                                    var reserve_price = parseInt($('#reserve_price_value').text());

                                    if (textBid >= reserve_price) {
                                        var data1 = '<div class="side-log">';
                                        data1 += '<div class="side-log" style="margin-bottom: 0px;">';
                                        data1 += 'Your max bid is ' + textBid + ' Kr and the sellers reserve price is ' + reserve_price + ' Kr. <br/>Note If this auction ends your bid will be increased to match the reserve.';
                                        data1 += '</span></div>';

                                        var data2 = '<i class="fa fa-check" style="color: green;"></i> <?php echo Yii::t('lang', 'reserve_price_met_msg'); ?>.';

                                        $('#reserve_price_msg_2').html(data1);
                                        $('#reserve_price_msg_1').html(data2);
                                    }

                                    if (parseInt(result['high_bid']) >= reserve_price) {
                                        var data2 = '<i class="fa fa-check" style="color: green;"></i> <?php echo Yii::t('lang', 'reserve_price_met_msg'); ?>.';
                                        $('#reserve_price_msg_1').html(data2);
                                    }

                                    $('#modalMsg').html(result['status']);
                                    //$('#btnmsgModal').attr('data', '2');
                                    $('#msgModal').modal('show');

                                    $.ajax({
                                        url: '<?php echo Utils::GetBaseUrl(); ?>/site/getAllBidsOfTheUser',
                                        data: {p_id: product_id, u_id: session_user_id},
                                        type: 'POST',
                                        success: function (res) {
                                            $('.bid-user-list-' + product_id).html(res);
                                        }
                                    });
                                    getNicknameOfHigherBiddderShowHistory(product_id, result['val']);
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

        $('#btnAgree').click(function () {
            var isChecked = $('#btnCheck').prop('checked');

            if (isChecked) {
                if (<?php echo $session_id; ?> == 0) {
                    $("#bidModal").modal("hide");

                    if (confirm("<?php echo Yii::t('lang', 'cant_buy_auction_msg'); ?>")) {
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

        $('#btnmsgModal').click(function () {
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

    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('html, body').animate({
            scrollTop: $('.betcrunb-part').offset().top + 40
        }, 1500);

        $('div[class^="col-sm-3 pid_each_"]').each(function () {
            var product_id = $(this).attr('class').split('_').pop();
            var textBid = $('.price_' + product_id).html();
            //console.log(textBid);
            getNicknameOfHigherBiddderShowHistory(product_id, textBid);
        });

    });

    flag_check = true;
    flag_out = true;
    xhr = "";

    function getNicknameOfHigherBiddderShowHistory(p_id, val) {
        $.ajax({
            url: '<?php echo Utils::GetBaseUrl() ?>/site/highBidder/',
            data: {pid: p_id},
            type: 'POST',
            success: function (res) {
                if (res != '0') {
                    $('#highbidder_nickname_' + p_id).html('<strong>' + res + '</strong> har ledande bud:<br/><strong>' + val + ' Kr</strong>');
                    $('#highbidder_nickname_block_' + p_id).show();
                }
            }
        });
    }


    /* Block Alphabets */
    /* Block Alphabets, Eg. for Contact Field */
    jQuery('.numeric').keydown(function (e) {
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

    $(".pagination li a ").click(function (e) {
        var link = $(this).attr("href");
        var num = $(this).parent().parent().attr("id");
        e.preventDefault();
        $.ajax({
            url: link,
            type: "get",
            data: {by: 'by', history_id: num},
            success: function (out_res) {
                $("#maincontent").html(out_res);
                $('html, body').animate({
                    scrollTop: $(".breadcrumb").offset().top - 10
                }, 1000);
            }
        });
    });

    $('.order').click(function () {
        var limit = $(this).attr('data-value');
        var link = '<?php echo Utils::GetBaseUrl(); ?>/site/closedauctions?limit=' + limit + '&by=ajax';
        console.log(link);

        $.ajax({
            url: link,
            type: "get",
            success: function (out_res) {
                $('#maincontent').html(out_res);
                $('html, body').animate({
                    scrollTop: $('.login-header').offset().top - 10
                }, 1000);
            }
        });
    });

</script>