<div id="maincontent">
    <?php
    $this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'bidding_history') . ' - ' . $history_type;

    Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('.search-form form').submit(function(){
            $('#product-grid-admin').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">            
                <ol class="breadcrumb">
                    <li><h1><i class="fa fa-user"></i> <?php echo Yii::t('lang', 'bidding_history'); ?> - <?php echo $history_type ?></h1></li>
                </ol>
            </div>
        </div>    
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="portlet portlet-default">
                <div class="portlet-body">

                    <div id="statusMsg"></div>

                    <?php if (Yii::app()->user->hasFlash('message')): ?>
                        <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?> alert-dismissable" id="successmsg">
                            <?php echo Yii::app()->user->getFlash('message'); ?>
                        </div>
                    <?php endif; ?>

                    <ul class="nav nav-tabs" id="userTab">                        
                        <li class="active"><a data-toggle="tab" id="h_1" class="tabShow" href="#history_1">Ongoing Auctions</a></li>
                        <li class=""><a data-toggle="tab" id="h_2" class="tabShow" href="#history_2">Closed Auctions</a></li>
                        <li class=""><a data-toggle="tab" id="h_3" class="tabShow" href="#history_3">Paid Auctions</a></li>
                        <li class=""><a data-toggle="tab" id="h_4" class="tabShow" href="#history_4">Unpaid Auctions</a></li>
                        <li class=""><a data-toggle="tab" id="h_5" class="tabShow" href="#history_5">All Auctions</a></li>
                    </ul>

                    <div id="userTabContent" class="tab-content">
                        <?php for ($kk = 1; $kk <= 5; $kk++) { ?>
                            <div id="history_<?php echo $kk; ?>" class="tab-pane fade<?php echo ($kk == 1) ? ' active in' : ''; ?>">
                                <div class="row">
                                    <div class="col-md-12">                                
                                        <div class="table-responsive">
                                            <?php
                                            if (count($result) > 0) {
                                                $mm = $number;
                                                foreach ($result as $product) { 
                                                    if($kk==3 || $kk==4){  
                                                        $product = $product['data'];
                                                    }   
                                                    print_r($product);                                                                               
                                                    ?>
                                                    <div class="col-md-12 mybox">                                                        
                                                        <div class="col-md-12">
                                                            <h3 style="margin-top: 10px;" class="text-green">
                                                                <?php echo $mm++; ?>. <?php echo $product['p_name'] ?> (#<?php echo $product['p_id'] ?>)
                                                                <span class="pull-right" style="font-size: 20px;">
                                                                    <a title="View Picture" href="javascript:void(0);" data-placement="top" data-toggle="tooltip" class="view_img" data-img="<?php echo $product['p_thumbs']; ?>">
                                                                        <i class="fa fa-image"></i>
                                                                    </a>&nbsp;
                                                                    <a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('product/view/' . $product['p_id']); ?>" title="View Product">
                                                                        <i class="fa fa-search"></i>
                                                                    </a>
                                                                </span>
                                                            </h3>
                                                            <hr style="border-color:#16a085;">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <table class="table table-bordered table-responsive table-striped">                                                                        
                                                                        <tr>
                                                                            <td><?php echo Yii::t('lang', 'current_price') ?></td>
                                                                            <td><?php echo $product['p_current_price'] ?> Kr</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo Yii::t('lang', 'bid_diff_price') ?></td>
                                                                            <td><?php echo $product['p_biddiff'] ?> Kr</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo Yii::t('lang', 'winners') ?></td>
                                                                            <td><?php echo $product['p_winners'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo Yii::t('lang', 'buy_now_price') ?></td>
                                                                            <td><?php echo $product['p_buynow_price'] ?> Kr</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo Yii::t('lang', 'reserve_price') ?></td>
                                                                            <td><?php echo $product['p_reserve_price'] ?> Kr</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo Yii::t('lang', 'shipping_price') ?></td>
                                                                            <td><?php echo $product['p_shipping_price'] ?> Kr</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><?php echo Yii::t('lang', 'expiry') . ' ' . Yii::t('lang', 'date') ?></td>
                                                                            <td><?php echo date('jS F Y H:i:s', $product['p_expiry_date']); ?></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="col-sm-6" style="padding-left: 0px;">
                                                                    <div style="overflow: hidden; height: 100%; border: 1px solid rgb(204, 204, 204);">
                                                                        <h4 style="margin: 0px; padding: 3px 0px;" class="text-center tile green">
                                                                            <?php echo Yii::t('lang', 'bidding_report') ?>
                                                                        </h4>                                                                        
                                                                        <table class="table table-bordered table-striped" style="margin: 0px ! important;">
                                                                            <tr>
                                                                                <th width="40px">#</th>
                                                                                <th width="125px">Username</th>
                                                                                <th width="85px">Bid Value</th>
                                                                                <th width="200px">Bid Date & Time</th>
                                                                                <th></th>
                                                                            </tr>    
                                                                        </table>
                                                                        <div style="height: 146px; width: 100%; overflow-x: hidden; overflow-y: scroll;">                                                                    
                                                                            <?php if (count($product['bids']) > 0) { ?>
                                                                                <?php $j = 1; ?>
                                                                                <table class="table table-bordered table-striped">
                                                                                    <?php foreach ($product['bids'] as $bid) { ?>
                                                                                        <tr>
                                                                                            <td width="40px" class="text-center"><?php echo $j++; ?></td>
                                                                                            <td width="125px" class="text-center"><?php echo $u = Buyers::model()->findByPk($bid['b_buyersid'])->buyers_nickname; ?></td>
                                                                                            <td width="85px" class="text-right"><?php echo $bid['b_value'] ?> Kr</td>
                                                                                            <td width="200px" class="text-center"><?php echo $bid['b_created']; ?></td>
                                                                                            <td>
                                                                                                <a class="" href="<?php echo Utils::GetBaseUrl() . '/buyers/view/' . $bid['b_buyersid']; ?>" target="_blank">
                                                                                                    <i class="fa fa-search"></i>
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                </table>
                                                                            <?php } else { ?>
                                                                                <table class="table table-bordered table-striped">
                                                                                    <tr>
                                                                                        <td class="myNoBidMsg">No Bid Found!</td>                                    
                                                                                    </tr>
                                                                                </table>
                                                                            <?php } ?>
                                                                        </div>                                                                
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <?php if ($product['p_expiry'] < 0) { ?>
                                                                <?php if (count($product['result']) > 0) { ?>
                                                                    <div class="row" style="max-height: 250px; overflow: auto; border: 1px solid rgb(204, 204, 204); margin: 0px 0px 10px;">
                                                                        <h4 style="padding: 5px 0px; margin: 0px;" class="text-center tile green">
                                                                            <?php echo Yii::t('lang', 'winner_report') ?>
                                                                        </h4>                                                                        
                                                                        <table class="table table-responsive table-bordered table-striped statusTable" style="margin: 0px ! important;">
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>User ID</th>
                                                                                <th>User Name</th>
                                                                                <th>Amount (Kr)</th>
                                                                                <th>Winning Status</th>
                                                                                <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                    <th>Payment Status</th>
                                                                                <?php } ?>                                                                            
                                                                                <th>Send Mail</th>
                                                                                <th>View</th>
                                                                            </tr>
                                                                            <?php
                                                                            $count = 1;
                                                                            $counter = 0;
                                                                            foreach ($result as $res) {
                                                                                if ($res->winner_pay_status_id == 1 && $history_id == 3) {
                                                                                    $counter = 1;
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td align="center"><?php echo $count++; ?></td>
                                                                                        <td align="center"><?php echo $res->winner_userid ?></td>
                                                                                        <td align="center"><?php echo Buyers::model()->getUsername($res->winner_userid) ?></td>
                                                                                        <td align="center"><?php echo $res->winner_price ?></td>
                                                                                        <td align="center"><?php echo Utils::getWinnerStatus($res->winner_number); ?></td>
                                                                                        <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                            <td align="center">
                                                                                                <a class="btn btn-xs <?php echo ($res->winner_pay_status_id == 1) ? 'btn-green' : 'btn-orange'; ?> myStatusButton" title="Winner Payment Status" href="javascript:void(0);">
                                                                                                    <i class="fa <?php echo ($res->winner_pay_status_id == 1) ? 'fa-check' : 'fa-clock-o'; ?>"></i> <?php echo $res->winner_pay_status ?>
                                                                                                </a>
                                                                                            </td>
                                                                                        <?php } ?>
                                                                                        <td align="center">                                                                                    
                                                                                            <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                                <?php if ($res->winner_pay_status_id != 1) { ?>
                                                                                                    <?php
                                                                                                    $email_id = Buyers::model()->findByPk($res->winner_userid)->user_email;
                                                                                                    $item_url = Yii::app()->createAbsoluteUrl('product/' . $product['p_id'] . '/' . $product['p_slug']);
                                                                                                    $data_info = 'u_name=' . Buyers::model()->getUsername($res->winner_userid) . '&u_email=' . $email_id . '&p_id=' . $product['p_id'] . '&p_name=' . $product['p_name'] . '&p_url=' . $item_url . '&u_status=' . Utils::getWinnerStatus($res->winner_number) . '&amt=' . $res->winner_price;
                                                                                                    ?>
                                                                                                    <a class="send_mail" title="Send Mail" href="javascript:void(0);" data="<?php echo $data_info; ?>">
                                                                                                        <i class="fa fa-mail-forward"></i>
                                                                                                    </a>
                                                                                                <?php } else { ?>
                                                                                                    <a class="" title="" href="javascript:void(0);">
                                                                                                        -
                                                                                                    </a>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        </td>
                                                                                        <td align="center">
                                                                                            <a class="" href="<?php echo Utils::GetBaseUrl() . '/buyers/view/' . $res->winner_userid; ?>" target="_blank" title="View User">
                                                                                                <i class="fa fa-search"></i>
                                                                                            </a>                                                                                    
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php } if ($res->winner_pay_status_id != 1 && $history_id == 4) { ?>
                                                                                    <tr>
                                                                                        <td align="center"><?php echo $count++; ?></td>
                                                                                        <td align="center"><?php echo $res->winner_userid ?></td>
                                                                                        <td align="center"><?php echo Buyers::model()->getUsername($res->winner_userid) ?></td>
                                                                                        <td align="center"><?php echo $res->winner_price ?></td>
                                                                                        <td align="center"><?php echo Utils::getWinnerStatus($res->winner_number); ?></td>
                                                                                        <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                            <td align="center">
                                                                                                <a class="btn btn-xs <?php echo ($res->winner_pay_status_id == 1) ? 'btn-green' : 'btn-orange'; ?> myStatusButton" title="Winner Payment Status" href="javascript:void(0);">
                                                                                                    <i class="fa <?php echo ($res->winner_pay_status_id == 1) ? 'fa-check' : 'fa-clock-o'; ?>"></i> <?php echo $res->winner_pay_status ?>
                                                                                                </a>
                                                                                            </td>
                                                                                        <?php } ?>
                                                                                        <td align="center">                                                                                    
                                                                                            <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                                <?php if ($res->winner_pay_status_id != 1) { ?>
                                                                                                    <?php
                                                                                                    $email_id = Buyers::model()->findByPk($res->winner_userid)->buyers_email;
                                                                                                    $item_url = Yii::app()->createAbsoluteUrl('product/' . $product['p_id'] . '/' . $product['p_slug']);
                                                                                                    $data_info = 'u_name=' . Buyers::model()->getUsername($res->winner_userid) . '&u_email=' . $email_id . '&p_id=' . $product['p_id'] . '&p_name=' . $product['p_name'] . '&p_url=' . $item_url . '&u_status=' . Utils::getWinnerStatus($res->winner_number) . '&amt=' . $res->winner_price;
                                                                                                    ?>
                                                                                                    <a class="send_mail" title="Send Mail" href="javascript:void(0);" data="<?php echo $data_info; ?>">
                                                                                                        <i class="fa fa-mail-forward"></i>
                                                                                                    </a>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        </td>
                                                                                        <td align="center">
                                                                                            <a class="" href="<?php echo Utils::GetBaseUrl() . '/buyers/view/' . $res->winner_userid; ?>" target="_blank" title="View User">
                                                                                                <i class="fa fa-search"></i>
                                                                                            </a>                                                                                    
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                                if ($history_id >= 5) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td align="center"><?php echo $count++; ?></td>
                                                                                        <td align="center"><?php echo $res->winner_userid ?></td>
                                                                                        <td align="center"><?php echo Buyers::model()->getUsername($res->winner_userid) ?></td>
                                                                                        <td align="center"><?php echo $res->winner_price ?></td>
                                                                                        <td align="center"><?php echo Utils::getWinnerStatus($res->winner_number); ?></td>
                                                                                        <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                            <td align="center">
                                                                                                <a class="btn btn-xs <?php echo ($res->winner_pay_status_id == 1) ? 'btn-green' : 'btn-orange'; ?> myStatusButton" title="Winner Payment Status" href="javascript:void(0);">
                                                                                                    <i class="fa <?php echo ($res->winner_pay_status_id == 1) ? 'fa-check' : 'fa-clock-o'; ?>"></i> <?php echo $res->winner_pay_status ?>
                                                                                                </a>
                                                                                            </td>
                                                                                        <?php } ?>
                                                                                        <td align="center">                                                                                    
                                                                                            <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                                <?php if ($res->winner_pay_status_id != 1) { ?>
                                                                                                    <?php
                                                                                                    $email_id = Buyers::model()->findByPk($res->winner_userid)->buyers_email;
                                                                                                    $item_url = Yii::app()->createAbsoluteUrl('product/' . $product['p_id'] . '/' . $product['p_slug']);
                                                                                                    $data_info = 'u_name=' . Buyers::model()->getUsername($res->winner_userid) . '&u_email=' . $email_id . '&p_id=' . $product['p_id'] . '&p_name=' . $product['p_name'] . '&p_url=' . $item_url . '&u_status=' . Utils::getWinnerStatus($res->winner_number) . '&amt=' . $res->winner_price;
                                                                                                    ?>
                                                                                                    <a class="send_mail" title="Send Mail" href="javascript:void(0);" data="<?php echo $data_info; ?>">
                                                                                                        <i class="fa fa-mail-forward"></i>
                                                                                                    </a>
                                                                                                <?php } else { ?>
                                                                                                    <a class="" title="" href="javascript:void(0);">
                                                                                                        -
                                                                                                    </a>
                                                                                                <?php } ?>
                                                                                            <?php } ?>
                                                                                        </td>
                                                                                        <td align="center">
                                                                                            <a class="" href="<?php echo Utils::GetBaseUrl() . '/buyers/view/' . $res->winner_userid; ?>" target="_blank" title="View User">
                                                                                                <i class="fa fa-search"></i>
                                                                                            </a>                                                                                    
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                            }

                                                                            if ($counter == 0 && $history_id == 3) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td colspan="8" class="myNoBidMsg">No Buyer have paid yet!</td>
                                                                                </tr>                                                                                    
                                                                            <?php } ?>
                                                                        </table>
                                                                    </div>
                                                                <?php } ?>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="col-md-12 mybox">
                                                    <h4 class="text-center text-red">No Record Found!</h4>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <?php
                                            $this->widget('CLinkPager', array(
                                                'header' => '',
                                                'firstPageLabel' => ' First &lt;&lt;',
                                                'prevPageLabel' => '&lt; Previous',
                                                'nextPageLabel' => 'Next &gt;',
                                                'lastPageLabel' => ' Last &lt;&lt;',
                                                'pages' => $pages,
                                                'htmlOptions' => array('class' => 'pagination', 'id' => $history_id),
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
                        <?php } ?>
                    </div>
                </div>            
            </div>
        </div>    
    </div>
</div>


<div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-body text-center">
                <img id="show_img"/>
            </div>            
        </div>        
    </div>    
</div>

<style type="text/css">
    #show_img {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 5px;
    }
    .myimage {
        border: 1px solid #ccc;
        margin: 10px;
        padding: 5px;
        width: 100%;
    }  
    .mybox {
        border: 1px solid rgb(41, 128, 194);
        margin: 5px 0;
        padding: 0;
    }
    .myoption {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-bottom: 1px solid #bbb;
        border-image: none;
        border-left: 1px solid #bbb;
        border-radius: 5px;
        border-top: 1px solid #bbb;       
        padding: 5px;
        width: 20%;
        margin-right: 10px;
    }
    th{
        text-align: center;
    }
    .btn {
        padding: 5px !important;
        font-size: 12px !important;
        width: 100%;
        margin-bottom:5px;
    }
    .btn-xs {
        margin-bottom: 0 !important;
    }
    #userTab .active a, #myTab2 .active a{
        background: none repeat scroll 0 0 rgb(41, 128, 194);
        border-color: rgb(41, 128, 194);
        color: #fff;
        -moz-border-radius: 0px;
        -webkit-border-radius: 5px 5px 0px 0px;
        border-radius: 5px 5px 0px 0px; 
    }
    #userTab, #myTab2 {
        border-bottom: 1px solid rgb(41, 128, 194);
    }
    .myNoBidMsg{
        color: rgb(255, 255, 255); background: none repeat scroll 0% 0% red !important; padding: 3px !important; border-radius: 3px;text-align: center;
    }   
    .dashedBorder {
        border: 1px outset #ccc;
    }
    .tt th, .tt td{
        text-align: center;       
    }
    .myStatusButton{
        padding:  2px 0 !important
    }
    .statusTable th, .statusTable td{
        padding: 2px !important;
    }
    .modal-body {
        padding: 10px;
        position: relative;
    }
</style>

<script type="text/javascript">

    $(document).ready(function() {

        $('.view_img').click(function() {
            var path = $(this).attr('data-img');
            $('#show_img').attr('src', '');
            $('#show_img').attr('src', path);
            $('#msgModal').modal('show');
        });

        $(".pagination li a ").click(function(e) {
            var link = $(this).attr("href");
            var num = $(this).parent().parent().attr("id");
            e.preventDefault();
            $.ajax({
                url: link,
                type: "get",
                data: {by: 'by', history_id: num},
                success: function(out_res) {
                    $("#maincontent").html(out_res);
                    $('#h_' + num).tab('show');
                    $('html, body').animate({
                        scrollTop: $("#userTab").offset().top - 10
                    }, 1000);
                }
            });
        });

        $('.tabShow').click(function() {
            var link = window.location.href;
            var id_array = $(this).attr('id').split('_');
            var history_id = id_array[1];
            $.ajax({
                url: link,
                type: "get",
                data: {by: 'by', history_id: history_id},
                success: function(out_res) {
                    $("#maincontent").html(out_res);
                    $('#h_' + history_id).tab('show');
                    $('html, body').animate({
                        scrollTop: $("#userTab").offset().top
                    }, 1000);
                },
            });
        });

        /* For Gallery Products using Pagination by AJAX */
        //        $(".pagination li a ").click(function(e) {
        //            link = $(this).attr("href");
        //            link = link + "&by=ajax";
        //
        //            e.preventDefault();
        //            $.ajax({
        //                url: link,
        //                type: "get",
        //                success: function(out_res) {
        //                    $("#maincontent").html(out_res);
        //
        //                    $('html, body').animate({
        //                        scrollTop: $("#userTab").offset().top - 10
        //                    }, 1500);
        //                }
        //            });
        //        });


        /* For Sorting of Products by AJAX */
        $('.order').click(function() {
            var order_title = $(this).html();
            var sort_by = $(this).attr('data-name');
            if (sort_by === '') {
                return false;
            }
            var order_by = $(this).attr('data-value');
            var link = '<?php echo Utils::GetBaseUrl(); ?>?sort_by=' + sort_by + '&order_by=' + order_by + '&by=ajax';

            //console.log(link);

            $.ajax({
                url: link,
                type: "get",
                success: function(out_res) {
                    $('#maincontent').html(out_res);

                    $('html, body').animate({
                        scrollTop: $('#list_all').offset().top - 10
                    }, 1000);

                    $('.order_title').text(order_title);
                }
            });
        });


        $('.send_mail').click(function() {
            var link = '<?php echo Utils::GetBaseUrl(); ?>/product/forwardMail?' + $(this).attr('data');
            $.ajax({
                url: link,
                type: "get",
                success: function(result) {
                    if (result == 1) {
                        alert('Notification mail sent successfully.');
                    } else {
                        alert('Notification mail sent error, please try again later.');
                    }
                }
            });
        });

    });
</script>