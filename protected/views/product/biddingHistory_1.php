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

                    <ul id="userTab" class="nav nav-tabs">                    
                        <li class="active"><a href="#product-list-admin" data-toggle="tab"><?php echo Yii::t('lang', 'list_of') . ' ' . Yii::t('lang', 'products') ?></a></li>
                    </ul>
                    <div id="userTabContent" class="tab-content">                    
                        <div class="tab-pane fade active in" id="product-list-admin">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="table-responsive">
                                        <?php
                                        if (count($result) > 0) {
                                            foreach ($result as $product) {
                                                ?>

                                                <div class="col-md-12 mybox">
                                                    <div class="col-md-2" style="padding-left: 0px;">                                                    
                                                        <img src="<?php echo $product['p_thumbs'] ?>" class="myimage img-responsive"/>
                                                        <p class="myimage img-responsive text-center">
                                                            <a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('product/view/' . $product['p_id']); ?>" class="btn btn-green btn-square" style="width: 100%;margin-bottom:0"><i class="fa fa-search"></i> View</a>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <h3 style="margin-top: 10px;"><?php echo $product['p_name'] ?></h3>
                                                        <hr/>
                                                        <!--<p>
                                                            <?php if (!empty($product['p_desc']) && strlen($product['p_desc']) > 0) { ?>
                                                                <?php echo $product['p_desc'] ?> ... <a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('product/view/' . $product['p_id']); ?>">[Read More]</a>
                                                            <?php } ?>
                                                        </p>-->

                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <div class="btn btn-purple btn-square">
                                                                    Current Price : <?php echo $product['p_current_price'] ?> (Kr) 
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="btn btn-green btn-square">
                                                                    Bid Difference : <?php echo $product['p_biddiff'] ?> (Kr)
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="btn btn-orange btn-square">
                                                                    Winners : <?php echo $product['p_winners'] ?>
                                                                </div>
                                                            </div>

                                                            <?php if (!empty($product['p_buynow_price'])) { ?>
                                                                <div class="col-md-4">
                                                                    <div class="btn btn-blue btn-square">
                                                                        Buy Now Price : <?php echo $product['p_buynow_price'] ?> (Kr)
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                            <?php if (!empty($product['p_reserve_price'])) { ?>
                                                                <div class="col-md-4">
                                                                    <div class="btn btn-orange btn-square">
                                                                        Reserve Price : <?php echo $product['p_reserve_price'] ?> (Kr)
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                            <?php if (!empty($product['p_shipping_price'])) { ?>
                                                                <div class="col-md-4">
                                                                    <div class="btn btn-default btn-square">
                                                                        Shipping Price : <?php echo $product['p_shipping_price'] ?> (Kr)
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                            <?php if (!empty($product['p_expiry_date'])) { ?>
                                                                <div class="col-md-4">
                                                                    <div class="btn btn-red btn-square">
                                                                        Expiry Date : <?php echo date("F d, Y H:i:s A", $product['p_expiry_date']); ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                        </div>

                                                        <?php if ($product['p_expiry'] < 0) { ?>
                                                            <?php if (count($product['result']) > 0) { ?>
                                                                <div class="col-md-12" style="max-height: 250px; overflow: auto; margin: 15px 0px 0px; border: 1px solid rgb(204, 204, 204);">
                                                                    <h4 style="padding: 5px 0px; margin-bottom: 5px;" class="text-center tile green">
                                                                        <?php echo Yii::t('lang', 'winner_report') ?>
                                                                    </h4>
                                                                    <hr style="margin: 5px 0 !important;">
                                                                    <table class="table table-responsive table-bordered table-hover" style="margin: 5px 0 10px !important;">
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
                                                                        foreach ($product['result'] as $result) {
                                                                            if ($result['winner_pay_status_id'] == 1 && $history_id == 3) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td align="center"><?php echo $count++; ?></td>
                                                                                    <td align="center"><?php echo $result['winner_userid'] ?></td>
                                                                                    <td ><?php echo User::model()->getFullName($result['winner_userid']) ?></td>
                                                                                    <td align="center"><?php echo $result['winner_price'] ?></td>
                                                                                    <td align="center"><?php echo Utils::getWinnerStatus($result['winner_number']); ?></td>
                                                                                    <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                        <td align="center">
                                                                                            <a class="btn btn-xs <?php echo ($result['winner_pay_status_id'] == 1) ? 'btn-green' : 'btn-orange'; ?>" title="Winner Payment Status" href="javascript:void(0);">
                                                                                                <i class="fa <?php echo ($result['winner_pay_status_id'] == 1) ? 'fa-check' : 'fa-clock-o'; ?>"></i> <?php echo $result['winner_pay_status'] ?>
                                                                                            </a>
                                                                                        </td>
                                                                                    <?php } ?>
                                                                                    <td align="center">                                                                                    
                                                                                        <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                            <?php if ($result['winner_pay_status_id'] != 1) { ?>
                                                                                                <?php
                                                                                                $email_id = User::model()->findByPk($result['winner_userid'])->user_email;
                                                                                                $item_url = Yii::app()->createAbsoluteUrl('product/' . $product['p_id'] . '/' . $product['p_slug']);
                                                                                                $data_info = 'u_name=' . User::model()->getFullName($result['winner_userid']) . '&u_email=' . $email_id . '&p_id=' . $product['p_id'] . '&p_name=' . $product['p_name'] . '&p_url=' . $item_url . '&u_status=' . Utils::getWinnerStatus($result['winner_number']) . '&amt=' . $result['winner_price'];
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
                                                                                        <a class="" href="<?php echo Utils::GetBaseUrl() . '/user/view/' . $result['winner_userid']; ?>" target="_blank" title="View User">
                                                                                            <i class="fa fa-search"></i>
                                                                                        </a>                                                                                    
                                                                                    </td>
                                                                                </tr>
                                                                                <?php
                                                                            }
                                                                            if ($result['winner_pay_status_id'] != 1 && $history_id == 4) {
                                                                                ?>
                                                                                <tr>
                                                                                    <td align="center"><?php echo $count++; ?></td>
                                                                                    <td align="center"><?php echo $result['winner_userid'] ?></td>
                                                                                    <td ><?php echo Buyers::model()->getFullName($result['winner_userid']) ?></td>
                                                                                    <td align="center"><?php echo $result['winner_price'] ?></td>
                                                                                    <td align="center"><?php echo Utils::getWinnerStatus($result['winner_number']); ?></td>
                                                                                    <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                        <td align="center">
                                                                                            <a class="btn btn-xs <?php echo ($result['winner_pay_status_id'] == 1) ? 'btn-green' : 'btn-orange'; ?>" title="Winner Payment Status" href="javascript:void(0);">
                                                                                                <i class="fa <?php echo ($result['winner_pay_status_id'] == 1) ? 'fa-check' : 'fa-clock-o'; ?>"></i> <?php echo $result['winner_pay_status'] ?>
                                                                                            </a>
                                                                                        </td>
                                                                                    <?php } ?>
                                                                                    <td align="center">                                                                                    
                                                                                        <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                            <?php if ($result['winner_pay_status_id'] != 1) { ?>
                                                                                                <?php
                                                                                                $email_id = Buyers::model()->findByPk($result['winner_userid'])->buyers_email;
                                                                                                $item_url = Yii::app()->createAbsoluteUrl('product/' . $product['p_id'] . '/' . $product['p_slug']);
                                                                                                $data_info = 'u_name=' . Buyers::model()->getFullName($result['winner_userid']) . '&u_email=' . $email_id . '&p_id=' . $product['p_id'] . '&p_name=' . $product['p_name'] . '&p_url=' . $item_url . '&u_status=' . Utils::getWinnerStatus($result['winner_number']) . '&amt=' . $result['winner_price'];
                                                                                                ?>
                                                                                                <a class="send_mail" title="Send Mail" href="javascript:void(0);" data="<?php echo $data_info; ?>">
                                                                                                    <i class="fa fa-mail-forward"></i>
                                                                                                </a>
                                                                                            <?php } ?>
                                                                                        <?php } ?>
                                                                                    </td>
                                                                                    <td align="center">
                                                                                        <a class="" href="<?php echo Utils::GetBaseUrl() . '/user/view/' . $result['winner_userid']; ?>" target="_blank" title="View User">
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
                                                                                    <td align="center"><?php echo $result['winner_userid'] ?></td>
                                                                                    <td ><?php echo Buyers::model()->getFullName($result['winner_userid']) ?></td>
                                                                                    <td align="center"><?php echo $result['winner_price'] ?></td>
                                                                                    <td align="center"><?php echo Utils::getWinnerStatus($result['winner_number']); ?></td>
                                                                                    <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                        <td align="center">
                                                                                            <a class="btn btn-xs <?php echo ($result['winner_pay_status_id'] == 1) ? 'btn-green' : 'btn-orange'; ?>" title="Winner Payment Status" href="javascript:void(0);">
                                                                                                <i class="fa <?php echo ($result['winner_pay_status_id'] == 1) ? 'fa-check' : 'fa-clock-o'; ?>"></i> <?php echo $result['winner_pay_status'] ?>
                                                                                            </a>
                                                                                        </td>
                                                                                    <?php } ?>
                                                                                    <td align="center">                                                                                    
                                                                                        <?php if (!in_array($history_id, array(1, 2))) { ?>
                                                                                            <?php if ($result['winner_pay_status_id'] != 1) { ?>
                                                                                                <?php
                                                                                                $email_id = Buyers::model()->findByPk($result['winner_userid'])->buyers_email;
                                                                                                $item_url = Yii::app()->createAbsoluteUrl('product/' . $product['p_id'] . '/' . $product['p_slug']);
                                                                                                $data_info = 'u_name=' . Buyers::model()->getFullName($result['winner_userid']) . '&u_email=' . $email_id . '&p_id=' . $product['p_id'] . '&p_name=' . $product['p_name'] . '&p_url=' . $item_url . '&u_status=' . Utils::getWinnerStatus($result['winner_number']) . '&amt=' . $result['winner_price'];
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
                                                                                        <a class="" href="<?php echo Utils::GetBaseUrl() . '/user/view/' . $result['winner_userid']; ?>" target="_blank" title="View User">
                                                                                            <i class="fa fa-search"></i>
                                                                                        </a>                                                                                    
                                                                                    </td>
                                                                                </tr>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </table>
                                                                </div>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <div class="col-md-12" style="max-height: 250px; overflow: auto; margin: 15px 0px; border: 1px solid rgb(204, 204, 204);">
                                                            <h4 style="padding: 5px 0px; margin-bottom: 5px;" class="text-center tile green">
                                                                <?php echo Yii::t('lang', 'bidding_report') ?>
                                                            </h4>
                                                            <hr style="margin: 5px 0 !important;"/>
                                                            <table class="table table-responsive table-bordered table-hover" style="margin: 5px 0 10px !important;">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>User Name</th>
                                                                    <th>Bid Value (Kr)</th>
                                                                    <th>Bid Created Date</th>
                                                                    <th>Action</th>
                                                                </tr>

                                                                <?php
                                                                if (count($product['bids']) > 0) {
                                                                    $count = 1;
                                                                    foreach ($product['bids'] as $bids) {
                                                                        ?>

                                                                        <tr>
                                                                            <td align="center"><?php echo $count++; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                $u = Buyers::model()->findByPk($bids['b_buyersid']);
                                                                                echo $u->user_firstname . ' ' . $u->user_lastname;
                                                                                ?>
                                                                            </td>
                                                                            <td align="center"><?php echo $bids['b_value'] ?></td>
                                                                            <td align="center"><?php echo $bids['b_created'] ?></td>
                                                                            <td align="center"><a class="" href="<?php echo Utils::GetBaseUrl() . '/user/view/' . $bids['b_userid']; ?>" target="_blank"><i class="fa fa-search"></i></a></td>
                                                                        </tr>

                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <tr><td colspan="6" class="text-center text-red">No Bidding Found!</td></tr>
                                                                <?php } ?>
                                                            </table>
                                                        </div>
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
                                            'htmlOptions' => array('class' => 'pagination', 'id' => ''),
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

</div>

<style type="text/css">
    .myimage {
        border: 1px solid #ccc;
        margin: 10px;
        padding: 5px;
        width: 100%;
    }  
    .mybox {
        border: 1px solid #ccc;
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
</style>

<script type="text/javascript">

    $(document).ready(function() {
        /* For Gallery Products using Pagination by AJAX */
        $(".pagination li a ").click(function(e) {
            link = $(this).attr("href");
            link = link + "&by=ajax";

            e.preventDefault();
            $.ajax({
                url: link,
                type: "get",
                success: function(out_res) {
                    $("#maincontent").html(out_res);

                    $('html, body').animate({
                        scrollTop: $("#userTab").offset().top - 10
                    }, 1500);
                }
            });
        });


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