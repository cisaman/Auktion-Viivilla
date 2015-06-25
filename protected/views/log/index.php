<div id="maincontent">
    <?php
    $this->pageTitle = Yii::app()->name . ' | Log History';

    $super_role_id = Yii::app()->session['admin_data']['admin_role_id'];

    Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('.search-form form').submit(function(){
                $('#log-grid').yiiGridView('update', {
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
                    <li><h1><i class="fa fa-list"></i> Log History</h1></li>
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
                                    'id' => 'log-grid',
                                    'htmlOptions' => array('class' => 'dataTables_wrapper', 'role' => 'grid'),
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
                                            'name' => 'log_name',
                                            'value' => '$data->log_name',
                                            'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                            'filter' => CHtml::activeTextField($model, 'log_name', array('placeholder' => $model->getAttributeLabel('log_name'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                        ),
                                        array(
                                            'name' => 'log_userid',
                                            'value' => '$data->log_userid',
                                            'type' => 'raw',
                                            //'value' => 'CHtml::link(Buyers::model()->getUsername($data->log_userid), "/buyers/view/" . $data->payment_buyersID, array("target" => "_blank", "class" => "text-blue text-bold"))',
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;'),
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:100px'),
                                            'filter' => CHtml::activeTextField($model, 'log_userid', array('placeholder' => $model->getAttributeLabel('log_userid'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                        ),
                                        array(
                                            'header' => 'Username',
                                            'value' => '($data->log_usertype==3)?Buyers::getBuyerName($data->log_userid):Sellers::model()->getSellersUsername($data->log_userid)',
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;'),
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:150px'),
                                            'filter' => ''
                                        ),
                                        array(
                                            'name' => 'log_productid',
                                            'value' => '$data->log_productid',
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;'),
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:100px'),
                                            'filter' => CHtml::activeTextField($model, 'log_productid', array('placeholder' => $model->getAttributeLabel('log_productid'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                        ),
                                        array(
                                            'header' => 'Product Name',
                                            'value' => 'Product::getProductNameById($data->log_productid)',
                                            'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;'),
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:300px'),
                                            'filter' => ''
                                        ),
                                        array(
                                            'header' => Yii::t('lang', 'action'),
                                            'class' => 'CButtonColumn',
                                            'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                            'htmlOptions' => array('style' => 'text-align:center;'),
                                            'template' => '{view}',
                                            'buttons' => array
                                                (
                                                'view' => array
                                                    (
                                                    'label' => '<i class="fa fa-search"></i>',
                                                    'options' => array('title' => 'View'),
                                                    'imageUrl' => FALSE
                                                ),
                                            ),
                                        ),
                                    ),
                                    'itemsCssClass' => 'table table-striped table-bordered table-hover table-green dataTable',
                                    'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
                                    'summaryCssClass' => 'dataTables_info',
                                    'template' => '{items}<div class = "row"><div class = "col-xs-6">{summary}</div><div class = "col-xs-6">{pager}</div></div>',
                                    'pager' => array(
                                        'htmlOptions' => array('class' => 'pagination', 'id' => ''),
                                        'header' => '',
                                        'firstPageLabel' => '<<',
                                        'prevPageLabel' => '<',
                                        'nextPageLabel' => '>',
                                        'lastPageLabel' => '>>',
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
</div>

<script type="text/javascript" async>
    $(document).ready(function () {
        $("#limitdata").change(function () {
            var link = 'index?ajax=log';
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