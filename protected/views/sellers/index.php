<div id="maincontent">
    <?php
    $this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'manage') . ' ' . Yii::t('lang', 'sellers');

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });

    $('.search-form form').submit(function(){
        $('#sellers-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });    
");

    $setNewPasswordJs = 'js:function(__event) {
    __event.preventDefault(); // disable default action

    var
         $this                     = $(this), // link/button         
         confirm_message = $this.data("confirm"), // read confirmation message from custom attribute
         url                         = $this.attr("href"); // read AJAX URL with parameters from HREF attribute on the link    

    if(confirm(confirm_message)) {        
        $("#sellers-grid").yiiGridView("update", {
            type    : "POST", // importatnt! we only allow POST in filters()            
            url       : url,            
            success : function(response) {   
                response = JSON.parse(response);               

                $("#statusMsg").addClass("alert alert-" + response.type);
                $("#statusMsg").html(response.msg);
                $("#statusMsg").show();

                $("#sellers-grid").yiiGridView("update"); // refresh gridview via AJAX

                setInterval(function(){ $("#statusMsg").fadeOut("slow"); }, 3000);
            },
            error   : function(xhr) {
                console.log("Error:", xhr);
            }
        });
    }
}';

    $showProductsBySellerIDJs = 'js:function(__event) {
    __event.preventDefault(); // disable default action

    var
         $this                     = $(this), // link/button         
         confirm_message = $this.data("confirm"), // read confirmation message from custom attribute
         url                         = $this.attr("href"); // read AJAX URL with parameters from HREF attribute on the link    

    if(confirm(confirm_message)) {
        window.open(url, "_blank");        
    }
}';
    ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">            
                <ol class="breadcrumb">
                    <li><h1><i class="fa fa-user"></i> <?php echo Yii::t('lang', 'manage'); ?> <?php echo Yii::t('lang', 'sellers'); ?></h1></li>
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
                        <li class="active"><a href="#sellers-list" data-toggle="tab"><?php echo Yii::t('lang', 'list_of'); ?> <?php echo Yii::t('lang', 'sellers'); ?></a></li>
                        <li class=""><a href="#sellers-add" data-toggle="tab"><?php echo Yii::t('lang', 'add'); ?> <?php echo Yii::t('lang', 'seller'); ?></a></li>
                    </ul>
                    <div id="userTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="sellers-list">
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
                                            'id' => 'sellers-grid',
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
                                                    'header' => Yii::t('lang', 'photo'),
                                                    'type' => 'html',
                                                    'value' => '!empty($data->sellers_image) ? CHtml::image(Utils::UserThumbnailImagePath() . $data->sellers_image, $data->sellers_image, array("class" => "imglogo")) : CHtml::image(Utils::NoImagePath(), "N/A", array("class" => "imglogo"))',
                                                    'htmlOptions' => array('style' => 'text-align:center'),
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                    'filter' => ''
                                                ),
                                                array(
                                                    'name' => 'sellers_username',
                                                    'value' => '$data->sellers_username',
                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                    'filter' => CHtml::activeTextField($model, 'sellers_username', array('placeholder' => $model->getAttributeLabel('sellers_username'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                ),
                                                array(
                                                    'name' => 'sellers_vatno',
                                                    'value' => '$data->sellers_vatno',
                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                    'filter' => CHtml::activeTextField($model, 'sellers_vatno', array('placeholder' => $model->getAttributeLabel('sellers_vatno'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                ),
                                                array(
                                                    'name' => 'sellers_fname',
                                                    'value' => '$data->sellers_fname',
                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                    'filter' => CHtml::activeTextField($model, 'sellers_fname', array('placeholder' => $model->getAttributeLabel('sellers_fname'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                ),
                                                array(
                                                    'name' => 'sellers_lname',
                                                    'value' => '$data->sellers_lname',
                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                    'filter' => CHtml::activeTextField($model, 'sellers_lname', array('placeholder' => $model->getAttributeLabel('sellers_lname'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                ),
                                                array(
                                                    'name' => 'sellers_email',
                                                    'value' => '$data->sellers_email',
                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                    'filter' => CHtml::activeTextField($model, 'sellers_email', array('placeholder' => $model->getAttributeLabel('sellers_email'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                ),
                                                array(
                                                    'header' => 'Total Products',
                                                    'value' => 'Product::model()->countProductBySellerID($data->sellers_id)',
                                                    'htmlOptions' => array('style' => 'text-align:center'),
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width: 120px'),
                                                ),
                                                array(
                                                    'name' => 'sellers_status',
                                                    //'value' => '($data->sellers_status == 0) ? Yii::t("lang", "inactive") : Yii::t("lang", "active")',
                                                    'type' => 'raw',
                                                    'value' => '($data->sellers_status == 0) ? "<a class=\"btn btn-xs btn-red\">" . Yii::t("lang", "inactive") . "</a>" : "<a class=\"btn btn-xs btn-green\">" . Yii::t("lang", "active")  . "</a>"',
                                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                    'filter' => CHtml::activeDropDownList($model, 'sellers_status', array(0 => Yii::t('lang', 'inactive'), 1 => Yii::t('lang', 'active')), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . Yii::t('lang', 'status')))
                                                ),
                                                array(
                                                    'header' => Yii::t('lang', 'action'),
                                                    'class' => 'CButtonColumn',
                                                    'deleteConfirmation' => 'Are you sure you want to delete this Seller?',
                                                    'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:120px'),
                                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                                    'template' => '{product} {password} {view} {update} {delete}',
                                                    'buttons' => array
                                                        (
                                                        'product' => array
                                                            (
                                                            'label' => '<i class="fa fa-shopping-cart"></i>',
                                                            'imageUrl' => FALSE,
                                                            'url' => 'Yii::app()->createUrl("product/show", array("id"=>$data->sellers_id))',
                                                            'options' => array(
                                                                'title' => 'View Products by this Seller',
                                                                'data-confirm' => 'Do you want to View Products by this Seller?',
                                                            ),
                                                            'click' => $showProductsBySellerIDJs,
                                                        ),
                                                        'password' => array
                                                            (
                                                            'label' => '<i class="fa fa-key"></i>',
                                                            'imageUrl' => FALSE,
                                                            'url' => 'Yii::app()->createUrl("sellers/setNewPassword", array("id"=>$data->sellers_id))',
                                                            'options' => array(
                                                                'title' => 'Set New Password for Seller',
                                                                'data-confirm' => 'Do you really want to Set New Password for this Seller?',
                                                            ),
                                                            'click' => $setNewPasswordJs,
                                                        ),
                                                        'view' => array
                                                            (
                                                            'label' => '<i class="fa fa-search"></i>',
                                                            'options' => array('title' => 'View Seller'),
                                                            'imageUrl' => FALSE
                                                        ),
                                                        'update' => array
                                                            (
                                                            'label' => '<i class="fa fa-edit"></i>',
                                                            'options' => array('title' => 'Update Seller'),
                                                            'imageUrl' => FALSE
                                                        ),
                                                        'delete' => array
                                                            (
                                                            'label' => '<i class="fa fa-times"></i>',
                                                            'options' => array('title' => 'Remove Seller', 'class' => 'remove'),
                                                            'imageUrl' => FALSE
                                                        ),
                                                    ),
                                                ),
                                            ),
                                            'itemsCssClass' => 'table table-striped table-bordered table-hover table-green dataTable',
                                            'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
                                            'summaryCssClass' => 'dataTables_info',
                                            'template' => '{items}<div class = "row"><div class = "col-xs-4">{summary}</div><div class = "col-xs-8">{pager}</div></div>',
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

                        <div class="tab-pane fade" id="sellers-add">                            
                            <div class="row">
                                <div class="col-md-12">

                                    <?php $this->renderPartial('_form', array('model' => $model)); ?>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>            
            </div>
        </div>    
    </div>


    <style type="text/css">
        .imglogo {border: 1px solid #ccc;height: 80px;padding: 4px;width: 100%;}
    </style>

</div>

<script type="text/javascript" async>
    $(document).ready(function () {
        $("#limitdata").change(function () {
            var link = 'index?ajax=Buyers';
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