<div id="maincontent">


    <?php $this->pageTitle = Yii::app()->name . ' | View Buyer' . '(#' . $model->buyers_id . ')'; ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">            
                <ol class="breadcrumb">
                    <li><h1><i class="fa fa-shopping-cart"></i> View Buyer | <small><a class="text-blue" href="<?php echo Yii::app()->createAbsoluteUrl('buyers/index'); ?>">Back to Listing</a></small></h1></li>
                </ol>
            </div>
        </div>    
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="portlet portlet-default">
                <div class="portlet-body">
                    <ul id="bookingTab" class="nav nav-tabs">
                        <li class="active"><a href="#user-view" data-toggle="tab">View Buyer(#<?php echo $model->buyers_id; ?>)</a></li>
                    </ul>
                    <div id="bookingTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="user-view">                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="view">   

                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="text-green"><?php echo CHtml::encode($model->buyers_fname . ' ' . $model->buyers_lname); ?></h3>
                                                <hr/>   
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 col-lg-12 col-sm-12">
                                                <div class="portlet portlet-default">
                                                    <div class="portlet-heading">
                                                        <div class="portlet-title">
                                                            <h4>Buyer's Information</h4>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <ul class="nav nav-tabs" id="myTab2">
                                                            <li class="active"><a data-toggle="tab" href="#basic_info">Basic Information</a></li>
                                                            <li class=""><a data-toggle="tab" href="#contact_info">Contact Information</a></li>
                                                            <li class=""><a data-toggle="tab" href="#social_info">Social Information</a></li>
                                                            <li class=""><a data-toggle="tab" href="#other_info">Other Information</a></li>
                                                        </ul>
                                                        <div class="tab-content" id="myTabContent2">                                                            
                                                            <div id="basic_info" class="tab-pane fade active in">
                                                                <table class="table table-bordered table-responsive">            
                                                                    <tbody> 
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_nickname')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_nickname); ?></td>
                                                                            <td rowspan="7" align="center" style="vertical-align:top">
                                                                                <?php
                                                                                $thumb_path = Utils::UserThumbnailImagePath() . $model->buyers_image;
                                                                                $path = Utils::UserImagePath() . $model->buyers_image;
                                                                                $thumb_path_m = Utils::UserImagePath_M();
                                                                                $path_m = Utils::UserImagePath_M();
                                                                                $thumb_path_f = Utils::UserImagePath_F();
                                                                                $path_f = Utils::UserImagePath_F();
                                                                                ?>

                                                                                <?php if (!empty($model->buyers_image)) { ?>
                                                                                    <a title="View Image" data-placement="top" data-toggle="tooltip" class="view_img" data-img="<?php echo $path; ?>">
                                                                                        <img src="<?php echo $thumb_path; ?>" alt="<?php echo $thumb_path; ?>" title="Click to enlarge" class="gallery_img" />
                                                                                    </a>
                                                                                <?php } else { ?>
                                                                                    <?php if (!empty($model->buyers_gender)) { ?>
                                                                                        <?php if ($model->buyers_gender == 'M') { ?>
                                                                                            <a title="View Image" data-placement="top" data-toggle="tooltip" class="view_img" data-img="<?php echo $path_m; ?>">
                                                                                                <img src="<?php echo $thumb_path_m; ?>" alt="<?php echo $thumb_path_m; ?>" title="Click to enlarge" class="gallery_img" />
                                                                                            </a>
                                                                                        <?php } else { ?>
                                                                                            <a title="View Image" data-placement="top" data-toggle="tooltip" class="view_img" data-img="<?php echo $path_f; ?>">
                                                                                                <img src="<?php echo $thumb_path_f; ?>" alt="<?php echo $thumb_path_f; ?>" title="Click to enlarge" class="gallery_img" />
                                                                                            </a>
                                                                                        <?php } ?>
                                                                                    <?php } else { ?>
                                                                                        <a title="View Image" data-placement="top" data-toggle="tooltip" class="view_img" data-img="<?php echo $path_m; ?>">
                                                                                            <img src="<?php echo $thumb_path_m; ?>" alt="<?php echo $thumb_path_m; ?>" title="Click to enlarge" class="gallery_img" />
                                                                                        </a>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_fname')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_fname); ?></td>                    
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_lname')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_lname); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_email')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_email); ?></td>                    
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_gender')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_gender); ?></td>
                                                                        </tr>                                                                        
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_jobtitle')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_jobtitle); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_dob')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_dob); ?></td>
                                                                        </tr>                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div id="contact_info" class="tab-pane fade">
                                                                <table class="table table-bordered table-responsive">            
                                                                    <tbody>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_address')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_address); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_city')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_city); ?></td>
                                                                        </tr>                
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_zipcode')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_zipcode); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_contactno')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_contactno); ?></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>                                                                
                                                            </div>
                                                            <div id="social_info" class="tab-pane fade">                                                                
                                                                <table class="table table-bordered table-responsive">            
                                                                    <tbody>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_summary')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_summary); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_website')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_website); ?></td>                    
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_facebook')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_facebook); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_twitter')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_twitter); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_linkedin')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_linkedin); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_skype')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_skype); ?></td>
                                                                        </tr>                
                                                                    </tbody>
                                                                </table>                                                                
                                                            </div>
                                                            <div id="other_info" class="tab-pane fade">
                                                                <table class="table table-bordered table-responsive">            
                                                                    <tbody>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_status')); ?></th>
                                                                            <td><?php echo ($model->buyers_status == 1) ? 'Activated' : 'De-Actived'; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_registertype')); ?></th>
                                                                            <td><?php echo CHtml::encode($model->buyers_registertype); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_lastlogin')); ?></th>
                                                                            <td>
                                                                                <?php
                                                                                if ($model->buyers_lastlogin == '0000-00-00 00:00:00') {
                                                                                    echo '-';
                                                                                } else if (strtotime($model->buyers_lastlogin) != 0) {
                                                                                    echo date('jS F Y H:i:s', strtotime($model->buyers_lastlogin));
                                                                                } else {
                                                                                    echo '-';
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th class="head"><?php echo CHtml::encode($model->getAttributeLabel('buyers_created')); ?></th>
                                                                            <td>
                                                                                <?php
                                                                                if (strtotime($model->buyers_created) != 0) {
                                                                                    echo date('jS F Y H:i:s', strtotime($model->buyers_created));
                                                                                } else {
                                                                                    echo '-';
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>                                                                
                                                            </div>
                                                        </div>
                                                    </div>                                           
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row setBidTop">
                                            <div class="col-md-12 col-lg-12 col-sm-12">
                                                <div class="portlet portlet-default">
                                                    <div class="portlet-heading">
                                                        <div class="portlet-title">
                                                            <h4>Bidding History</h4>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <ul class="nav nav-tabs" id="myTab">
                                                            <li class="active"><a data-toggle="tab" id="h_1" class="tabShow" href="#history_1">Ongoing Auctions</a></li>
                                                            <li class=""><a data-toggle="tab" id="h_2" class="tabShow" href="#history_2">Closed Auctions</a></li>
                                                            <li class=""><a data-toggle="tab" id="h_3" class="tabShow" href="#history_3">Paid Auctions</a></li>
                                                            <li class=""><a data-toggle="tab" id="h_4" class="tabShow" href="#history_4">Unpaid Auctions</a></li>
                                                            <li class=""><a data-toggle="tab" id="h_5" class="tabShow" href="#history_5">All Auctions</a></li>
                                                        </ul>
                                                        <div class="tab-content" id="myTabContent">
                                                            <?php for ($kk = 1; $kk <= 5; $kk++) { ?>
                                                                <div id="history_<?php echo $kk; ?>" class="tab-pane fade<?php echo ($kk == 1) ? ' active in' : ''; ?>">
                                                                    <?php if (count($history) > 0) { ?>
                                                                        <?php $i = $number; ?>

                                                                        <?php
                                                                        foreach ($history as $product) {
                                                                            if ($history_id == 3 || $history_id == 4 || $history_id == 5) {
                                                                                $product = $product['data'];
                                                                                ?>
                                                                                <div class="myboxDIV">
                                                                                    <h4 class="text-center productInfoTitle">Product Information</h4>
                                                                                    <hr/>
                                                                                    <table class="table table-bordered table-responsive table-striped tt">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th style="width: 30px !important;">#</th>
                                                                                                <th>Picture</th>
                                                                                                <th><?php echo Yii::t('lang', 'product') . ' ' . Yii::t('lang', 'name'); ?></th>
                                                                                                <th><?php echo Yii::t('lang', 'current_price') ?></th>
                                                                                                <th><?php echo Yii::t('lang', 'bid_diff_price'); ?></th>                                                                                            
                                                                                                <th><?php echo Yii::t('lang', 'shipping_price') ?></th>
                                                                                                <th><?php echo Yii::t('lang', 'buy_now_price'); ?></th>
                                                                                                <th><?php echo Yii::t('lang', 'reserve_price') ?></th>
                                                                                                <th><?php echo Yii::t('lang', 'expiry') . ' ' . Yii::t('lang', 'date'); ?></th>
                                                                                                <th>Action</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><?php echo $i++; ?></td>
                                                                                                <td><a href="<?php echo Utils::GetBaseUrl(); ?>/product/view/<?php echo $product['p_id']; ?>" target="blank"><img src="<?php echo $product['p_thumbs']; ?>" style="height: 60px; border: 1px solid rgb(204, 204, 204); padding: 2px; width: 60px;"/></a></td>
                                                                                                <td><?php echo $product['p_name'] ?></td>
                                                                                                <td><?php echo $product['p_price'] ?> Kr</td>
                                                                                                <td><?php echo $product['p_biddifference'] ?> Kr</td>
                                                                                                <td><?php echo $product['p_shipping_price'] ?> Kr</td>
                                                                                                <td><?php echo $product['p_buynow_price'] ?> Kr</td>
                                                                                                <td><?php echo $product['p_reserve_price'] ?> Kr</td>
                                                                                                <td><?php echo date('jS F Y H:i:s', $product['p_expiry_date']); ?></td>
                                                                                                <td><a href="<?php echo Utils::GetBaseUrl(); ?>/product/view/<?php echo $product['p_id']; ?>" target="blank" title="View Product"><i class="fa fa-search"></i></a></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>

                                                                                    <h4 class="text-center text-blue">Bidding History</h4>
                                                                                    <hr/>
                                                                                    <div class="col-sm-12 dashedBorder" style="background: none repeat scroll 0% 0% rgb(41, 128, 194); color: rgb(255, 255, 255); font-weight: bold;">
                                                                                        <div class="col-sm-2">#</div>
                                                                                        <div class="col-sm-3">Bid Price</div>
                                                                                        <div class="col-sm-4">Bid Date & Time</div>
                                                                                    </div>
                                                                                    <div style="max-height: 110px; overflow-y: scroll;width: 100%;">
                                                                                        <?php if (count($product['bids']) > 0) { ?>
                                                                                            <?php $j = 1; ?>
                                                                                            <?php foreach ($product['bids'] as $bid) { ?>
                                                                                                <div class="col-sm-12 dashedBorder">
                                                                                                    <div class="col-sm-2"><?php echo $j++; ?></div>
                                                                                                    <div class="col-sm-3"><?php echo $bid['b_value'] ?> Kr</div>
                                                                                                    <div class="col-sm-7"><?php echo $bid['b_created']; ?></div>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        <?php } else { ?>
                                                                                            <div class="col-sm-12">
                                                                                                <div class="myNoBidMsg">
                                                                                                    No Bid Found!
                                                                                                </div>                                    
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                <div class="myboxDIV">
                                                                                    <h4 class="text-center productInfoTitle">Product Information</h4>
                                                                                    <hr/>
                                                                                    <table class="table table-bordered table-responsive table-striped tt">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <th style="width: 30px !important;">#</th>
                                                                                                <th>Picture</th>
                                                                                                <th><?php echo Yii::t('lang', 'product') . ' ' . Yii::t('lang', 'name'); ?></th>
                                                                                                <th><?php echo Yii::t('lang', 'current_price') ?></th>
                                                                                                <th><?php echo Yii::t('lang', 'bid_diff_price'); ?></th>                                                                                            
                                                                                                <th><?php echo Yii::t('lang', 'shipping_price') ?></th>
                                                                                                <th><?php echo Yii::t('lang', 'buy_now_price'); ?></th>
                                                                                                <th><?php echo Yii::t('lang', 'reserve_price') ?></th>
                                                                                                <th><?php echo Yii::t('lang', 'expiry') . ' ' . Yii::t('lang', 'date'); ?></th>
                                                                                                <th>Action</th>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><?php echo $i++; ?></td>
                                                                                                <td><a href="<?php echo Utils::GetBaseUrl(); ?>/product/view/<?php echo $product['p_id']; ?>" target="blank"><img src="<?php echo $product['p_thumbs']; ?>" style="height: 60px; border: 1px solid rgb(204, 204, 204); padding: 2px; width: 60px;"/></a></td>
                                                                                                <td><?php echo $product['p_name'] ?></td>
                                                                                                <td><?php echo $product['p_price'] ?> Kr</td>
                                                                                                <td><?php echo $product['p_biddifference'] ?> Kr</td>
                                                                                                <td><?php echo $product['p_shipping_price'] ?> Kr</td>
                                                                                                <td><?php echo $product['p_buynow_price'] ?> Kr</td>
                                                                                                <td><?php echo $product['p_reserve_price'] ?> Kr</td>
                                                                                                <td><?php echo date('jS F Y H:i:s', $product['p_expiry_date']); ?></td>
                                                                                                <td><a href="<?php echo Utils::GetBaseUrl(); ?>/product/view/<?php echo $product['p_id']; ?>" target="blank" title="View Product"><i class="fa fa-search"></i></a></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>

                                                                                    <h4 class="text-center text-blue">Bidding History</h4>
                                                                                    <hr/>
                                                                                    <div class="col-sm-12 dashedBorder" style="background: none repeat scroll 0% 0% rgb(41, 128, 194); color: rgb(255, 255, 255); font-weight: bold;">
                                                                                        <div class="col-sm-2">#</div>
                                                                                        <div class="col-sm-3">Bid Price</div>
                                                                                        <div class="col-sm-4">Bid Date & Time</div>
                                                                                    </div>
                                                                                    <div style="max-height: 110px; overflow-y: scroll;width: 100%;">
                                                                                        <?php if (count($product['bids']) > 0) { ?>
                                                                                            <?php $j = 1; ?>
                                                                                            <?php foreach ($product['bids'] as $bid) { ?>
                                                                                                <div class="col-sm-12 dashedBorder">
                                                                                                    <div class="col-sm-2"><?php echo $j++; ?></div>
                                                                                                    <div class="col-sm-3"><?php echo $bid['b_value'] ?> Kr</div>
                                                                                                    <div class="col-sm-7"><?php echo $bid['b_created']; ?></div>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        <?php } else { ?>
                                                                                            <div class="col-sm-12">
                                                                                                <div class="myNoBidMsg">
                                                                                                    No Bid Found!
                                                                                                </div>                                    
                                                                                            </div>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                        <?php } ?>

                                                                        <div class="text-right">
                                                                            <?php
                                                                            $this->widget('CLinkPager', array(
                                                                                'header' => '',
                                                                                'firstPageLabel' => '<<',
                                                                                'prevPageLabel' => '<',
                                                                                'nextPageLabel' => '>',
                                                                                'lastPageLabel' => '>>',
                                                                                'pages' => $pages,
                                                                                'htmlOptions' => array('class' => 'pagination', 'id' => $kk, 'style' => 'margin:0;'),
                                                                                'selectedPageCssClass' => 'active',
                                                                                'previousPageCssClass' => 'prev',
                                                                                'nextPageCssClass' => 'next',
                                                                                'hiddenPageCssClass' => 'disabled',
                                                                                'maxButtonCount' => 5,
                                                                            ));
                                                                            ?>
                                                                        </div>

                                                                    <?php } else { ?>
                                                                        <div class="alert alert-danger text-center">
                                                                            No Bidding History!
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            <?php } ?>
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
            </div>        
        </div>    
    </div>

    <div class="modal fade" id="msgModal" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">            
                <div class="modal-body">
                    <img id="show_img"/>                
                </div>            
            </div>        
        </div>    
    </div>

    <script type="text/javascript">
        $(document).ready(function () {

            $('.view_img').click(function () {
                var path = $(this).attr('data-img');
                $('#show_img').attr('src', '');
                $('#show_img').attr('src', path);
                $('#msgModal').modal('show');
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
                            scrollTop: $(".setBidTop").offset().top - 10
                        }, 1000);
                    }
                });
            });

            $('.tabShow').click(function () {
                var link = window.location.href;
                var id_array = $(this).attr('id').split('_');
                var history_id = id_array[1];
                $.ajax({
                    url: link,
                    type: "get",
                    data: {by: 'by', history_id: history_id},
                    success: function (out_res) {
                        $("#maincontent").html(out_res);
                        $('#h_' + history_id).tab('show');
                        $('html, body').animate({
                            scrollTop: $(".setBidTop").offset().top
                        }, 1000);
                    },
                });
            });

        });
    </script>

    <style type="text/css">

        .modal-body > img {
            width: 100%;
        }

        .head{
            width: 150px;
        }

        @media (min-width:320px) and (min-width:360px) {
            .view {
                padding: 0 !important;
            }
        }

        @media (min-width:361px){
            .view {
                padding: 0 30px !important;
            }
        }

        .gallery_img{       
            padding: 5px; 
            border: 1px solid rgb(204, 204, 204); 
            margin: 10px 0px;
            height: 200px; 
            width: 180px; 
            padding: 5px; 
            border: 1px solid rgb(204, 204, 204); 
            /*        margin: 5px 20px;*/
            border-radius: 5px;
        }

        .tt th, .tt td{
            text-align: center;       
        }

        .myboxDIV{
            border: 1px solid rgb(22, 160, 133); padding: 5px; margin-bottom: 15px;
        }
        .myNoBidMsg{
            color: rgb(255, 255, 255); background: none repeat scroll 0% 0% red; padding: 3px; border-radius: 3px;text-align: center;
        }   
        .dashedBorder {
            border: 1px dashed #ccc;
        }

        #myTab .active a, #myTab2 .active a{
            background: none repeat scroll 0 0 rgb(41, 128, 194);
            border-color: rgb(41, 128, 194);
            color: #fff;
            -moz-border-radius: 0px;
            -webkit-border-radius: 5px 5px 0px 0px;
            border-radius: 5px 5px 0px 0px; 
        }
        #myTab, #myTab2 {
            border-bottom: 1px solid rgb(41, 128, 194);
        }
        .productInfoTitle{
            background: none repeat scroll 0px 0px rgb(22, 160, 133); color: rgb(255, 255, 255); margin: 0px; padding: 10px; border-radius: 5px;
        }
    </style>

</div>