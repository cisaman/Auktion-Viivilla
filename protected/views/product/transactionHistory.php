<div id="maincontent">
    <?php
    $this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'transaction_history');

    Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('.search-form form').submit(function(){
            $('#transaction-grid').yiiGridView('update', {
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
                    <li><h1><i class="fa fa-user"></i> <?php echo Yii::t('lang', 'transaction_history'); ?></h1></li>
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
                                    <div class="col-sm-2 col-sm-offset-9">
                                        <label style="width: 100%; margin: 0px; text-align: right; font-weight: bold ! important; line-height: 34px;">
                                            Records per Page
                                        </label>
                                    </div>
                                    <div class="col-sm-1" style="padding-left: 0;">
                                        <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : 10; ?>
                                        <?php echo CHtml::dropDownList('limitdata', $limit, array('10' => '10', '25' => '25', '50' => '50', '75' => '75', '100' => '100'), array('class' => 'form-control')); ?>
                                    </div>                                    
                                </div>
                                <hr/>
                                <?php
                                $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'transaction-grid',
                                    'htmlOptions' => array('class' => 'dataTables_wrapper samplescroll', 'role' => 'grid'),
                                    'dataProvider' => $model->search(),
                                    'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'header' => Yii::t('lang', 'sno'),
                                            'name' => 'S. No.',
                                            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                            'htmlOptions' => array('style' => 'text-align:center'),
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:60px'),
                                        ),
                                        array(
                                            'name' => 'payment_date',
                                            'value' => 'date("d-m-Y H:i", strtotime($data->payment_date))',
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;font-weight:bold;'),
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:150px'),
                                            'filter' => CHtml::activeTextField($model, 'payment_date', array('placeholder' => $model->getAttributeLabel('payment_date'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                        ),
                                        array(
                                            'name' => 'payment_invoiceno',
                                            'type' => 'raw',
                                            //'value' => 'CHtml::link($data->payment_invoiceno, "/site/invoice?info=" . $data->payment_productID . "__" . $data->payment_buyersID . "__" . $data->payment_amount . "__" . $data->payment_invoiceno . "__" . $data->payment_created . "__d", array("target" => "_blank", "class" => "text-blue text-bold", "data"=>"view"))',
                                            'value' => 'CHtml::link($data->payment_invoiceno, "javascript:void(0)", array("data" => "/site/invoice?info=" . $data->payment_id, "class" => "text-blue text-bold", "onclick" => "showInvoice(this)"))',
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;font-weight:bold;'),
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:90px;'),
                                            'filter' => CHtml::activeTextField($model, 'payment_invoiceno', array('placeholder' => $model->getAttributeLabel('payment_invoiceno'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                        ),
                                        array(
                                            'name' => 'payment_buyersID',
                                            'type' => 'raw',
                                            'value' => 'CHtml::link(Buyers::model()->getUsername($data->payment_buyersID), "/buyers/view/" . $data->payment_buyersID, array("target" => "_blank", "class" => "text-blue text-bold"))',
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;'),
                                            'headerHtmlOptions' => array('style' => 'text-align: center;'),
                                            'filter' => CHtml::activeTextField($model, 'payment_buyersID', array('placeholder' => $model->getAttributeLabel('payment_buyersID'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                        ),
                                        array(
                                            'name' => 'payment_productID',
                                            'type' => 'raw',
                                            'value' => 'CHtml::link(Product::model()->getProductName($data->payment_productID), "/product/view/" . $data->payment_productID, array("target" => "_blank", "class" => "text-blue text-bold"))',
                                            'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                            'headerHtmlOptions' => array('style' => 'text-align: center;'),
                                            'filter' => CHtml::activeTextField($model, 'payment_productID', array('placeholder' => $model->getAttributeLabel('payment_productID'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                        ),
                                        array(
                                            'name' => 'payment_gateway',
                                            'value' => '($data->payment_gateway == 1) ? "Paypal" : "Bank"',
                                            'htmlOptions' => array('style' => 'text-align:center;font-weight:bold;'),
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:70px'),
                                            'filter' => CHtml::activeDropDownList($model, 'payment_gateway', array('1' => 'Paypal', '2' => 'Bank'), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . $model->getAttributeLabel('payment_gateway')))
                                        ),
                                        array(
                                            'name' => 'payment_type',
                                            'value' => '($data->payment_type == 1) ? "Credit" : "Refund"',
                                            'htmlOptions' => array('style' => 'text-align:center;font-weight:bold;'),
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:100px;'),
                                            'filter' => CHtml::activeDropDownList($model, 'payment_type', array('1' => 'Credit', '0' => 'Refund'), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . $model->getAttributeLabel('payment_type')))
                                        ),
                                        array(
                                            'type' => 'raw',
                                            'header' => 'Shipping Price',
                                            'value' => 'Product::model()->getProductShippingPriceById($data->payment_productID) . " kr"',
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:120px;'),
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;font-weight:bold;'),
                                            'filter' => CHtml::activeTextField($model, 'payment_amount', array('placeholder' => $model->getAttributeLabel('payment_amount'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                        ),
                                        array(
                                            'type' => 'raw',
                                            'header' => 'Amount Paid',
                                            'value' => 'Product::model()->getProductShippingPriceById($data->payment_productID, $data->payment_amount) . " kr"',
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:120px;'),
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;font-weight:bold;'),
                                            'filter' => CHtml::activeTextField($model, 'payment_amount', array('placeholder' => $model->getAttributeLabel('payment_amount'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                        ),
                                        array(
                                            'type' => 'raw',
                                            'header' => 'Total Amount',
                                            'value' => '$data->payment_amount  . " kr"',
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:120px;'),
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;font-weight:bold;'),
                                            'filter' => CHtml::activeTextField($model, 'payment_amount', array('placeholder' => $model->getAttributeLabel('payment_amount'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                        ),
                                        array(
                                            'type' => 'raw',
                                            'name' => 'payment_refund',
                                            'value' => '!empty($data->payment_refund) ? $data->payment_refund  . " kr": "-"',
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:120px;'),
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;font-weight:bold;'),
                                            'filter' => CHtml::activeTextField($model, 'payment_refund', array('placeholder' => $model->getAttributeLabel('payment_refund'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                        ),
                                        array(
                                            'type' => 'raw',
                                            'header' => 'Order Status',
                                            'value' => '($data->payment_type==1)?(($data->payment_orderstatus==1) ? "<label class=\"btn btn-xs btn-green\" title=\"Order Status\"><i class=\"fa fa-check\"></i> Completed</label>":"<a class=\"btn btn-xs btn-warning\" title=\"Order Status\" onclick=\"showOrderPopup(this)\" href=\"javascript:void(0);\" data=\"order\" data-id=\"$data->payment_id\"><i class=\"fa fa-clock-o\"></i> Pending</a>"):"No Mails"',
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:120px;'),
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;font-weight:bold;'),
                                            'filter' => ''
                                        ),
                                        array(
                                            'type' => 'raw',
                                            'header' => 'Order Date & Time',
                                            'value' => '(empty($data->payment_orderdatetime)) ? "-":$data->payment_orderdatetime',
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:180px;'),
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;font-weight:bold;'),
                                            'filter' => ''
                                        ),
                                        array(
                                            'type' => 'raw',
                                            'header' => 'View',
                                            'value' => 'CHtml::link("View", "/product/paymentdetails/" . $data->payment_id, array("target" => "_blank", "class" => "text-green text-bold"))',
                                            'headerHtmlOptions' => array('style' => 'text-align: center;'),
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;font-weight:bold;'),
                                        ),
                                    ),
                                    'itemsCssClass' => 'table table-striped table-bordered table-hover table-green dataTable',
                                    'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
                                    'summaryCssClass' => 'dataTables_info',
                                    'template' => '{items}<div class = "row"><div class = "col-xs-4">{summary}</div><div class = "col-xs-8">{pager}</div></div>',
                                    'pager' => array(
                                        'htmlOptions' => array('class' => 'pagination', 'id' => ''),
                                        'header' => '',
                                        'cssFile' => false,
                                        'selectedPageCssClass' => 'active',
                                        'previousPageCssClass' => 'prev',
                                        'nextPageCssClass' => 'next',
                                        'hiddenPageCssClass' => 'disabled',
                                        'maxButtonCount' => 5,
                                    ),
                                    'emptyText' => '<span class="text-danger text-center">No Record Found!</span>',
                                ));
                                ?>
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
                        <a href="javascript:void(0);" class="text-red" data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
                    </div>
                    <div class="showInvoice"></div>                
                </div>            
            </div>        
        </div>    
    </div>

    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="standardModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog orderModal">
            <div class="modal-content">            
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
                    <h1>Beställningsmail till leverantör</h1>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12"><div id="orderError"></div></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="checkbox" id="winner_bid"/> Vinnarbud
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="fee" disabled="disabled"/> 5% Administrationsavgift
                            </div>
                            <div class="form-group">
                                <input type="radio" id="shipping1" name="shipping"/> Frakt
                            </div>
                            <div class="form-group">
                                <input type="radio" id="shipping2" name="shipping"/> Frakt faktureras av leverantör
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Övrigt</label>
                                <div>
                                    <textarea id="remarks" name="remarks" placeholder="Övrigt" maxlength="300" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 10px; text-align: right;">
                        <input type="hidden" id="record"/>                        
                        <a href="javascript:void(0);" class="btn btn-danger" data-dismiss="modal">Avbryt</a>&nbsp;
                        <a href="javascript:void(0);" id="orderSubmit" class="btn btn-success">Skicka</a>
                    </div>
                </div>
            </div>        
        </div>    
    </div>

    <style type="text/css">
        .text-bold {font-weight: bold;}
        .msgModal {width: 850px !important;}
        //.portlet .portlet-body {padding: 5px !important;}
        .modal-header h1 {font-size: 24px;margin: 0;text-align: center;}
        .samplescroll{overflow-x: scroll;}
        .samplescroll table {width: 1700px;}
    </style>

    <script type="text/javascript">

        function showInvoice(obj) {
            $('#loading').show();

            var url = $(obj).attr('data');

            $.ajax({
                url: url,
                success: function (response) {
                    $('.showInvoice').html(response);
                    $('#setUrl').attr('href', url + '__d');
                    $('#msgModal').modal('show');
                    $('#loading').hide();
                }
            });
        }

        function showOrderPopup(obj) {
            $('#orderError').removeClass('alert alert-danger');
            $('#orderError').html('');
            $('#record').val($(obj).attr("data-id"));

            $("#winner_bid").prop("checked", false);
            $("#fee").prop("checked", false);
            $("#shipping1").prop("checked", false);
            $("#shipping2").prop("checked", false);
            $("#remarks").val("");

            $('#orderModal').modal('show');
        }


        $('#winner_bid').click(function () {
            $('#loading').show();
            if ($(this).prop('checked')) {
                $('#fee').removeAttr('disabled');
            } else {
                $('#fee').attr('disabled', 'disabled');
                $('#fee').prop('checked', false);
            }
            $('#loading').hide();
        });

        $('#orderSubmit').click(function () {
            $('#loading').show();
            var winnerbid = $("#winner_bid").prop("checked");
            var fee = $("#fee").prop("checked");
            var shipping1 = $("#shipping1").prop("checked");
            var shipping2 = $("#shipping2").prop("checked");
            var remarks = $('#remarks').val();
            var record = $('#record').val();

            $.ajax({
                url: '<?php echo Utils::GetBaseUrl() ?>/product/order/' + record,
                type: 'POST',
                data: {winnerbid: winnerbid, fee: fee, shipping1: shipping1, shipping2: shipping2, remarks: remarks},
                success: function (response) {
                    if (response == "1") {
                        alert('Order Mail sent successfully to Buyer and Seller');
                    } else {
                        alert('Order Mail sent fail to Buyer and Seller');
                    }
                    $('#orderModal').modal('hide');
                    $('#loading').hide();
                    window.location.reload();
                }
            });
        });
    </script>

    <script type="text/javascript" async>
        $(document).ready(function () {
            $("#limitdata").change(function () {
                var link = 'transactionhistory?ajax=Payment';
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
        });
    </script>

</div>

