<div class="view">   

    <div class="row">
        <div class="col-md-12 setTop">
            <h3 class="text-green"><?php echo CHtml::encode($model->product_name); ?> <?php echo ($model->product_copy == 1) ? '- <span class="text-green"><i>Copy</i></span>' : ''; ?></h3>
            <hr/>   
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="portlet portlet-default">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h4>Product's Information</h4>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="portlet-body">
                    <ul class="nav nav-tabs" id="myTab2">
                        <li class="active"><a data-toggle="tab" id="h_1" class="tabShow" href="#basic_info">Basic Information</a></li>
                        <li class=""><a data-toggle="tab" id="h_2" class="tabShow" href="#auction_info">Auction Information</a></li>
                        <li class=""><a data-toggle="tab" id="h_3" class="tabShow" href="#gallery_info">Gallery Images</a></li>
                        <li class="" style="display: none;"><a data-toggle="tab" id="h_4" class="tabShow" href="#other_info">Other Information</a></li>
                    </ul>
                    <div class="tab-content" id="myTabContent2">                                                            
                        <div id="basic_info" class="tab-pane fade active in">
                            <table class="table table-bordered table-striped">            
                                <tbody>
                                    <tr>                                        
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_name')); ?></th>
                                        <td><?php echo CHtml::encode($model->product_name); ?></td>
                                    </tr>  
                                    <tr>
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_description')); ?></th>
                                        <td>
                                            <div style="text-align:justify;-ms-word-break: break-all;word-break: break-all;">
                                                <?php echo preg_replace('/(<br>)+$/', '', $model->product_description); ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_categoryID')); ?></th>
                                        <td><?php echo CHtml::encode(Category::model()->getCategoryNameByID($model->product_categoryID)); ?></td>
                                    </tr>                
                                    <tr>
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_winners')); ?></th>
                                        <td><?php echo CHtml::encode($model->product_winners); ?></td>
                                    </tr>  
                                </tbody>
                            </table>
                        </div>
                        <div id="auction_info" class="tab-pane fade">
                            <table class="table table-bordered table-striped">            
                                <tbody>                
                                    <tr>                                        
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_current_price')); ?></th>
                                        <td><?php echo CHtml::encode($model->product_current_price); ?> Kr</td>
                                    </tr>
                                    <tr>
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_bid_diff_price')); ?></th>
                                        <td><?php echo CHtml::encode($model->product_bid_diff_price); ?> Kr</td>
                                    </tr>
                                    <tr>
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_reserve_price')); ?></th>
                                        <td><?php echo CHtml::encode($model->product_reserve_price); ?> Kr</td>
                                    </tr>
                                    <tr>
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_shipping_price')); ?></th>
                                        <td><?php echo CHtml::encode($model->product_shipping_price); ?> Kr</td>
                                    </tr>
                                    <tr>
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_buynow_price')); ?></th>
                                        <td><?php echo CHtml::encode($model->product_buynow_price); ?> Kr</td>
                                    </tr>
                                    <tr>
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_tax')); ?></th>
                                        <td><?php echo CHtml::encode($model->product_tax); ?> %</td>
                                    </tr>
                                    <tr>
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_expiry_date')); ?></th>
                                        <td><?php echo date('jS F Y H:i:s', strtotime($model->product_expiry_date)); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_publish_date')); ?></th>
                                        <td><?php echo date('jS F Y H:i:s', strtotime($model->product_publish_date)); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo CHtml::encode($model->getAttributeLabel('product_sellersID')); ?></th>
                                        <td><?php echo CHtml::encode(Sellers::model()->getSellersFullName($model->product_sellersID)); ?> - <a class="btn btn-primary btn-xs" href="<?php echo Utils::GetBaseUrl(); ?>/sellers/<?php echo $model->product_sellersID; ?>" target="_blank"><i class="fa fa-search"></i> View Details</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="gallery_info" class="tab-pane fade">
                            <table class="table table-bordered">            
                                <tbody>                
                                    <tr>                    
                                        <td align="center">
                                            <div class="row">
                                                <div class="col-md-12">                                
                                                    <?php
                                                    $images = explode(',', $model->product_attachments);
                                                    if (count($images) > 0) {

                                                        foreach ($images as $img) {
                                                            $path = Utils::ProductImagePath() . $img;
                                                            $thumb_path = Utils::ProductImageThumbnailPath() . $img;
                                                            ?>
                                                            <div class="col-md-2">
                                                                <a title="View Image" data-placement="top" data-toggle="tooltip" class="view_img" data-img="<?php echo $path; ?>">
                                                                    <img src="<?php echo $thumb_path; ?>" alt="<?php echo $thumb_path; ?>" title="Click to enlarge" class="gallery_img" />
                                                                </a>
                                                            </div>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        No Images Found.
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>                
                                </tbody>
                            </table>
                        </div>
                        <div id="other_info" class="tab-pane fade">

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
    $(document).ready(function() {

        $('.view_img').click(function() {
            var path = $(this).attr('data-img');
            $('#show_img').attr('src', '');
            $('#show_img').attr('src', path);
            $('#msgModal').modal('show');
        });

        $('.tabShow').click(function() {
            var id_array = $(this).attr('id').split('_');
            var id = id_array[1];

            $('#h_' + id).tab('show');

            $('html, body').animate({
                scrollTop: $(".setTop").offset().top
            }, 1000);
        });

    });
</script>


<style type="text/css">

    .modal-body > img {
        width: 100%;
    }

    th{
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
        height: 140px; 
        width: 100%; 
        padding: 5px; 
        border: 1px solid rgb(204, 204, 204); 
        /*        margin: 5px 20px;*/
        border-radius: 5px;
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
</style>