<div id="maincontent">
    <?php $this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'bidding_history') . ' - Closed Auctions'; ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">            
                <ol class="breadcrumb">
                    <li><h1><i class="fa fa-user"></i> <?php echo Yii::t('lang', 'bidding_history'); ?> - Closed Auctions</h1></li>
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

                    <div class="row">
                        <div class="col-md-12">                                
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>
                                                    <label style="width: 100%; margin: 0px; text-align: right; font-weight: bold ! important; line-height: 34px;">
                                                        Search:
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Product#" class="form-control" id="search_by_productid" style="width: 80px;"/>
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Product Name" class="form-control" id="search_by_productname"/>
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Expiry Date" class="form-control" id="search_by_productexpiry" style="width: 100px;"/>
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Seller" class="form-control" id="search_by_sellers" data=""/>
                                                </td>
                                                <td>
                                                    <input type="button" class="btn btn-success" id="search_products" value="Search" style="margin: 0px; line-height: 21px; width: 60px;"/>
                                                    <input type="button" class="btn btn-danger" id="search_reset" value="Reset" style="margin: 0px; line-height: 21px; width: 60px;"/>
                                                </td>
                                                <td>
                                                    <label style="width: 100%; margin: 0px; text-align: right; font-weight: bold ! important; line-height: 34px;">
                                                        Records per Page
                                                    </label>
                                                </td>
                                                <td>
                                                    <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : 10; ?>
                                                    <?php echo CHtml::dropDownList('limitdata', $limit, array('10' => '10', '25' => '25', '50' => '50', '75' => '75', '100' => '100'), array('class' => 'form-control', 'style' => "width: 60px;")); ?>
                                                </td>                                                    
                                            </tr>                                                
                                        </table>
                                    </div>
                                </div>
                                <hr/>
                                <?php
                                if (count($result) > 0) {
                                    $mm = $number;
                                    foreach ($result as $product) {
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
                                                    <div class="col-sm-5">
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
                                                    <div class="col-sm-7" style="padding-left: 0px;">
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
    #show_img {border: 1px solid #ccc;border-radius: 5px;padding: 5px;}
    .myimage {border: 1px solid #ccc;margin: 10px;padding: 5px;width: 100%;}  
    .mybox {border: 1px solid rgb(41, 128, 194);margin: 5px 0;padding: 0;}
    .myoption {-moz-border-bottom-colors: none;-moz-border-left-colors: none;-moz-border-right-colors: none;-moz-border-top-colors: none;border-bottom: 1px solid #bbb;border-image: none;border-left: 1px solid #bbb;border-radius: 5px;border-top: 1px solid #bbb;padding: 5px;width: 20%;margin-right: 10px;}
    th{text-align: center;}
    .btn {padding: 5px !important;font-size: 12px !important;width: 100%;margin-bottom:5px;}
    .btn-xs {margin-bottom: 0 !important;}
    #userTab .active a, #myTab2 .active a{background: none repeat scroll 0 0 rgb(41, 128, 194);border-color: rgb(41, 128, 194);color: #fff;-moz-border-radius: 0px;-webkit-border-radius: 5px 5px 0px 0px;border-radius: 5px 5px 0px 0px;}
    #userTab, #myTab2 {border-bottom: 1px solid rgb(41, 128, 194);}
    .myNoBidMsg{color: rgb(255, 255, 255); background: none repeat scroll 0% 0% red !important; padding: 3px !important; border-radius: 3px;text-align: center;}   
    .dashedBorder {border: 1px outset #ccc;}
    .tt th, .tt td{text-align: center;}
    .myStatusButton{padding:  2px 0 !important}
    .statusTable th, .statusTable td{padding: 2px !important;}
    .modal-body {padding: 10px;position: relative;}
</style>

<link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/bootstrap-datepicker/datepicker3.css" rel="stylesheet" media="screen"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/bootstrap-datepicker/bootstrap-datepicker.js" charset="UTF-8"></script>

<script type="text/javascript">

    $(document).ready(function () {

        $('.view_img').click(function () {
            var path = $(this).attr('data-img');
            $('#show_img').attr('src', '');
            $('#show_img').attr('src', path);
            $('#msgModal').modal('show');
        });

        $('#search_by_productexpiry').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
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
                    $('#h_' + num).tab('show');
                    $('html, body').animate({
                        scrollTop: $("#userTab").offset().top - 10
                    }, 1000);
                }
            });
        });

    });
</script>


<script type="text/javascript" async>
    $(document).ready(function () {
        $("#limitdata").change(function () {
            var link = 'closedauctions?by=Payment';
            var limit = $(this).val();

            $.ajax({
                url: link,
                type: "GET",
                data: {limit: limit},
                success: function (out_res) {
                    $("#maincontent").html(out_res);
                    $('html, body').animate({
                        scrollTop: $(".breadcrumb").offset().top - 10
                    }, 1000);

                }
            });
        });

        $("#search_products").click(function () {
            var link = 'closedauctions?by=Payment';
            var prod_id = $('#search_by_productid').val();
            var prod_name = $('#search_by_productname').val();
            var prod_expiry = $('#search_by_productexpiry').val();
            var sellers_id = $('#search_by_sellers').attr('data');
            var sellers_username = $('#search_by_sellers').val();

            $.ajax({
                url: link,
                type: "GET",
                data: {prod_id: prod_id, prod_name: prod_name, prod_expiry: prod_expiry, sellers_id: sellers_id},
                success: function (out_res) {
                    $("#maincontent").html(out_res);
                    $('#search_by_productid').val(prod_id);
                    $('#search_by_productname').val(prod_name);
                    $('#search_by_productexpiry').val(prod_expiry);
                    $('#search_by_sellers').attr('data', sellers_id);
                    $('#search_by_sellers').val(sellers_username);

                    $('html, body').animate({
                        scrollTop: $(".breadcrumb").offset().top - 10
                    }, 1000);

                }
            });
        });

        $("#search_reset").click(function () {

            $('#search_by_productid').val('');
            $('#search_by_productname').val('');
            $('#search_by_productexpiry').val('');
            $('#search_by_sellers').attr('data', '');
            $('#search_by_sellers').val('');

            var link = 'closedauctions?by=Payment';

            $.ajax({
                url: link,
                type: "GET",
                success: function (out_res) {
                    $("#maincontent").html(out_res);
                    $('html, body').animate({
                        scrollTop: $(".breadcrumb").offset().top - 10
                    }, 1000);

                }
            });
        });
    });
</script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/bootstrap-typeahead.min.js" charset="UTF-8"></script>


<script type="text/javascript">
    var sellers = [];
    $.ajax({
        url: '/index.php/sellers/getAllSellers',
        type: 'POST',
        async: false,
        dataType: 'JSON',
        success: function (res) {
            $.each(res, function (key, value) {
                sellers.push(value);
            });
        }
    });

    $(function () {
        function displayResult(item) {
            //alert(item.value);
            $('#search_by_sellers').attr('data', item.value);
        }

        $('#search_by_sellers').typeahead({
            source: sellers,
            displayField: 'name',
            valueField: 'id',
            onSelect: displayResult
        });
    });
</script>