<?php $this->pageTitle = Yii::app()->name . ' | View Payment Details' . '(#' . $model->payment_id . ')'; ?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-shopping-cart"></i> View Payment Details | <small><a class="text-blue" href="<?php echo Yii::app()->createAbsoluteUrl('product/transactionHistory'); ?>">Back to Listing</a></small></h1></li>
            </ol>
        </div>
    </div>    
</div>
<!-- end PAGE TITLE AREA -->

<div class="row">
    <div class="col-lg-12">

        <div class="portlet portlet-default">
            <div class="portlet-body">
                <ul id="bookingTab" class="nav nav-tabs">
                    <li class="active"><a href="#booking-view" data-toggle="tab">View Payment Details(#<?php echo $model->payment_id; ?>)</a></li>
                </ul>
                <div id="bookingTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="booking-view">                            

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <h3 class="text-green text-bold">
                                    Invoice #<?php echo CHtml::encode($model->payment_invoiceno); ?>
                                    <span class="pull-right">
                                        <?php
                                        if ($_SERVER['HTTP_HOST'] == 'localhost') {
                                            echo CHtml::link('<i class="fa fa-download"></i> View Invoice', "/auction_build_4_05_2015/site/invoice?info=" . $model->payment_id, array("target" => "_blank", "class" => "text-blue text-bold", "data" => "view", "id" => "btnCreditInvoice"));
                                        } else {
                                            echo CHtml::link('<i class="fa fa-download"></i> View Invoice', "/site/invoice?info=" . $model->payment_id, array("target" => "_blank", "class" => "text-blue text-bold", "data" => "view", "id" => "btnCreditInvoice"));
                                        }
                                        ?>
                                    </span>
                                </h3>
                                <hr/>   
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="view">

                                    <table class="table table-bordered table-striped">            
                                        <tbody>
                                            <tr>
                                                <th><?php echo CHtml::encode($model->getAttributeLabel('payment_buyersID')); ?></th>
                                                <td><?php echo CHtml::link(Buyers::model()->getUsername($model->payment_buyersID), "/buyers/view/" . $model->payment_buyersID, array("target" => "_blank", "class" => "text-blue text-bold")); ?></td>
                                            </tr>
                                            <tr>                                        
                                                <th><?php echo CHtml::encode($model->getAttributeLabel('payment_productID')); ?></th>
                                                <td><?php echo CHtml::link(Product::model()->getProductName($model->payment_productID), "/product/view/" . $model->payment_productID, array("target" => "_blank", "class" => "text-blue text-bold")); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo CHtml::encode($model->getAttributeLabel('payment_gateway')); ?></th>
                                                <td><?php echo CHtml::encode(($model->payment_gateway == 1) ? "Paypal" : "Bank"); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo CHtml::encode($model->getAttributeLabel('payment_type')); ?></th>
                                                <td class="highlight"><?php echo CHtml::encode(($model->payment_type == 1) ? "Credit" : "Refund"); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo CHtml::encode($model->getAttributeLabel('payment_amount')); ?></th>
                                                <td><?php echo CHtml::encode($model->payment_amount . ' Kr'); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo CHtml::encode($model->getAttributeLabel('payment_payer_id')); ?></th>
                                                <td><?php echo CHtml::encode($model->payment_payer_id); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo CHtml::encode($model->getAttributeLabel('payment_payer_email')); ?></th>
                                                <td><?php echo CHtml::encode($model->payment_payer_email); ?></td>
                                            </tr>                                            
                                            <tr>
                                                <th><?php echo CHtml::encode($model->getAttributeLabel('payment_transaction_id')); ?></th>
                                                <td><?php echo CHtml::encode($model->payment_transaction_id); ?></td>
                                            </tr>      
                                            <tr>
                                                <th><?php echo CHtml::encode($model->getAttributeLabel('payment_status')); ?></th>
                                                <td class="highlight"><?php echo CHtml::encode($model->payment_status); ?></td>
                                            </tr>

                                            <?php if ($model->payment_type == 0) { ?>
                                                <tr>
                                                    <th><?php echo CHtml::encode($model->getAttributeLabel('payment_refund_invoiceno')); ?></th>
                                                    <td class="highlight"><?php echo CHtml::encode(!empty($model->payment_refund_invoiceno) ? $model->payment_refund_invoiceno : "-"); ?></td>
                                                </tr>
                                                <tr>                                                
                                                    <th><?php echo CHtml::encode($model->getAttributeLabel('payment_refund')); ?></th>
                                                    <td class="highlight"><?php echo CHtml::encode(!empty($model->payment_refund) ? $model->payment_refund . " kr" : "-"); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo CHtml::encode($model->getAttributeLabel('payment_remark')); ?></th>
                                                    <td><?php echo CHtml::encode(!empty($model->payment_remark) ? $model->payment_remark : "No Remarks"); ?></td>
                                                </tr>
                                                <tr>
                                                    <th><?php echo CHtml::encode($model->getAttributeLabel('payment_refunddate')); ?></th>
                                                    <td><?php echo CHtml::encode($model->payment_created); ?></td>
                                                </tr>                              
                                            <?php } else { ?>
                                                <tr>
                                                    <th><?php echo CHtml::encode($model->getAttributeLabel('payment_created')); ?></th>
                                                    <td><?php echo CHtml::encode($model->payment_created); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

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
    <div class="modal-dialog msgModal">
        <div class="modal-content">            
            <div class="modal-body">
                <div style="margin-bottom: 10px; text-align: right; font-weight: bold;">
                    <a href="" id="setUrl" class="text-blue"><i class="fa fa-download"></i> Download Invoice</a>&nbsp;
                    <a href="javascript:void(0);" class="text-red" data-dismiss="modal" id="btnClose"><i class="fa fa-times"></i> Close</a>
                </div>
                <div class="showInvoice"></div>                
            </div>            
        </div>        
    </div>    
</div>

<style type="text/css">
    .text-bold {font-weight: bold;}
    .msgModal {width: 850px !important;}
    .refundModal {width: 300px !important;}
    .portlet .portlet-body {padding: 5px !important;}
    .highlight {color: green;font-size: 18px;font-weight: bold;}
</style>

<script type="text/javascript">

    $('#btnClose').click(function () {
        $('#msgModal').modal('hide');
    });

    $('#btnCreditInvoice').click(function () {
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            success: function (response) {
                $('.showInvoice').html(response);
                $('#setUrl').attr('href', url + '__d');
                $('#msgModal').modal('show');
            }
        });
        return false;
    });

//    $('a').click(function(e) {
//        if ($(this).attr("data") == "view") {
//
//        } else {
//            $(this).attr("target", "_blank");
//            window.open($(this).attr("href"));
//        }
//        return false;
//    });
</script>