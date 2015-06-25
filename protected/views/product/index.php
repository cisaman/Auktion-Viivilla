<div id="maincontent">
    <?php
    $this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'manage') . ' ' . Yii::t('lang', 'products');

    $sellers_id = Yii::app()->session['admin_data']['admin_id'];
    $role_id = Yii::app()->session['admin_data']['admin_role_id'];

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
    $('.search-form form').submit(function(){
            $('#product-grid-other').yiiGridView('update', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $approveJs = 'js:function(__event)
    {
        __event.preventDefault(); // disable default action

        var $this = $(this), // link/button
            confirm_message = $this.data("confirm"), // read confirmation message from custom attribute
            url = $this.attr("href"); // read AJAX URL with parameters from HREF attribute on the link

        if(confirm(confirm_message)) // if user confirmed operation, then...
        {

            $("#product-grid-admin").yiiGridView("update",
            {
                type    : "POST", // importatnt! we only allow POST in filters()            
                url     : url,
                success : function(data) {                
                    $("#product-grid-admin").yiiGridView("update"); // refresh gridview via AJAX
                },
                error   : function(xhr)
                {
                    console.log("Error:", xhr);
                }
            });
        }
    }';

    $approveSellersJs = 'js:function(__event) {
        __event.preventDefault(); // disable default action

        var $this = $(this), // link/button
            confirm_message = $this.data("confirm"), // read confirmation message from custom attribute
            url = $this.attr("href"); // read AJAX URL with parameters from HREF attribute on the link

        if(confirm(confirm_message)) {        
            $("#product-grid-sellers").yiiGridView("update", {
                type    : "POST",
                url       : url,
                success : function(data) {                
                    $("#product-grid-sellers").yiiGridView("update"); // refresh gridview via AJAX
                },
                error   : function(xhr) {
                    console.log("Error:", xhr);
                }
            });
        }
    }';


//echo date('Y-m-d h:i:s A');
    ?>

    <!-- begin PAGE TITLE AREA -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">            
                <ol class="breadcrumb">
                    <li><h1><i class="fa fa-user"></i> <?php echo Yii::t('lang', 'manage'); ?> <?php echo Yii::t('lang', 'products'); ?> | <a href="<?php echo Yii::app()->createAbsoluteUrl('product/create') ?>" class="text-blue"><?php echo Yii::t('lang', 'add'); ?> <?php echo Yii::t('lang', 'product'); ?></a></h1></li>
                </ol>
            </div>
        </div>    
    </div>
    <!-- end PAGE TITLE AREA -->

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
                        <?php if ($role_id == 1) { ?>
                            <li class="active" id="tab1">
                                <a href="#product-list-admin" data-toggle="tab">
                                    <?php echo Yii::t('lang', 'list_of'); ?> <?php echo Yii::t('lang', 'products'); ?> - <?php echo Yii::t('lang', 'administrator'); ?>
                                </a>
                            </li>
                            <li class="" id="tab2">
                                <a href="#product-list-other" data-toggle="tab">
                                    <?php echo Yii::t('lang', 'list_of'); ?> <?php echo Yii::t('lang', 'products'); ?><?php echo ($role_id == 1) ? ' - ' . Yii::t('lang', 'sellers') : ''; ?>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="active" id="tab3">
                                <a href="#product-list-other" data-toggle="tab">
                                    <?php echo Yii::t('lang', 'list_of'); ?> <?php echo Yii::t('lang', 'products'); ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div id="userTabContent" class="tab-content">
                        <?php if ($role_id == 1) { ?>
                            <div class="tab-pane fade active in" id="product-list-admin">
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
                                                    <?php $limitdata1 = isset($_GET['limitdata1']) ? $_GET['limitdata1'] : 10; ?>
                                                    <?php echo CHtml::dropDownList('limitdata1', $limitdata1, array('10' => '10', '25' => '25', '50' => '50', '75' => '75', '100' => '100'), array('class' => 'form-control')); ?>
                                                </div>                                    
                                            </div>
                                            <hr/>
                                            <?php
                                            $this->widget('zii.widgets.grid.CGridView', array(
                                                'id' => 'product-grid-admin',
                                                'htmlOptions' => array('class' => 'dataTables_wrapper', 'role' => 'grid'),
                                                'dataProvider' => $model->search($role_id, 1, NULL),
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
                                                        'name' => 'product_name',
                                                        'type' => 'raw',
                                                        'value' => '$data->product_name . (($data->product_copy > 0) ? " - <span class=\"text-green\"><i><strong>Copy</strong></i></span>" : "")',
                                                        'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                        'filter' => CHtml::activeTextField($model, 'product_name', array('placeholder' => $model->getAttributeLabel('product_name'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                    ),
                                                    array(
                                                        'name' => 'product_created',
                                                        'value' => '$data->product_created',
                                                        'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;'),
                                                        'headerHtmlOptions' => array('style' => 'text-align: center;width:160px'),
                                                        'filter' => ''
                                                    ),
                                                    array(
                                                        'name' => 'product_status',
                                                        //'value' => '($data->product_status == 0) ? Yii::t("lang", "inactive") : Yii::t("lang", "active")',
                                                        'type' => 'raw',
                                                        'value' => '($data->product_status == 0) ? "<a class=\"btn btn-xs btn-red\">" . Yii::t("lang", "inactive") . "</a>" : "<a class=\"btn btn-xs btn-green\">" . Yii::t("lang", "active")  . "</a>"',
                                                        'htmlOptions' => array('style' => 'text-align:center;'),
                                                        'headerHtmlOptions' => array('style' => 'text-align: center;width:150px'),
                                                        'filter' => CHtml::activeDropDownList($model, 'product_status', array(0 => Yii::t('lang', 'inactive'), 1 => Yii::t('lang', 'active')), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . Yii::t('lang', 'status')))
                                                    ),
                                                    array(
                                                        'header' => Yii::t('lang', 'action'),
                                                        'class' => 'CButtonColumn',
                                                        'deleteConfirmation' => Yii::t('lang', 'delete_record_msg'),
                                                        'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                        'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                        'htmlOptions' => array('style' => 'text-align:center;'),
                                                        'template' => '{view} {copy} {update} {delete}',
                                                        'visible' => Yii::app()->user->name == 'Administrator',
                                                        'buttons' => array
                                                            (
                                                            'view' => array
                                                                (
                                                                'label' => '<i class="fa fa-search"></i>',
                                                                'options' => array('title' => 'View', 'target' => '_blank'),
                                                                'imageUrl' => FALSE
                                                            ),
                                                            'copy' => array
                                                                (
                                                                'label' => '<i class="fa fa-copy"></i>',
                                                                'imageUrl' => FALSE,
                                                                'url' => 'Yii::app()->createUrl("product/copy", array("id"=>$data->product_id))',
                                                                'options' => array(
                                                                    'title' => 'Copy',
                                                                    'data-confirm' => 'Do you really want to duplicate this Auktion?',
                                                                ),
                                                                'click' => $approveJs,
                                                            ),
                                                            'update' => array
                                                                (
                                                                'label' => '<i class="fa fa-edit"></i>',
                                                                'options' => array('title' => 'Update', 'target' => '_blank'),
                                                                'imageUrl' => FALSE
                                                            ),
                                                            'delete' => array
                                                                (
                                                                'label' => '<i class="fa fa-times"></i>',
                                                                'options' => array('title' => 'Delete', 'class' => 'remove'),
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
                            <div class="tab-pane fade" id="product-list-other">
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
                                                    <?php $limitdata2 = isset($_GET['limitdata2']) ? $_GET['limitdata2'] : 10; ?>
                                                    <?php echo CHtml::dropDownList('limitdata2', $limitdata2, array('10' => '10', '25' => '25', '50' => '50', '75' => '75', '100' => '100'), array('class' => 'form-control')); ?>
                                                </div>                                    
                                            </div>
                                            <hr/>
                                            <?php
                                            $this->widget('zii.widgets.grid.CGridView', array(
                                                'id' => 'product-grid-sellers',
                                                'htmlOptions' => array('class' => 'dataTables_wrapper', 'role' => 'grid'),
                                                'dataProvider' => $model->search($role_id, 2, NULL),
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
                                                        'name' => 'product_name',
                                                        'type' => 'raw',
                                                        'value' => '$data->product_name . (($data->product_copy == 1) ? " - <span class=\"text-green\"><i><strong>Copy</strong></i></span>" : "")',
                                                        'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                        'filter' => CHtml::activeTextField($model, 'product_name', array('placeholder' => $model->getAttributeLabel('product_name'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                    ),
                                                    array(
                                                        'name' => 'product_sellersID',
                                                        'value' => 'Sellers::model()->getSellersUsername($data->product_sellersID)',
                                                        'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                        'visible' => Yii::app()->user->name == 'Administrator',
                                                        'filter' => CHtml::activeDropDownList($model, 'product_sellersID', Sellers::model()->getSellersUsername(), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . $model->getAttributeLabel('product_sellersID')))
                                                    ),
                                                    array(
                                                        'name' => 'product_created',
                                                        'value' => '$data->product_created',
                                                        'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;'),
                                                        'headerHtmlOptions' => array('style' => 'text-align: center;width:160px'),
                                                        'filter' => ''
                                                    ),
                                                    array(
                                                        'name' => 'product_status',
                                                        'type' => 'raw',
                                                        'value' => '($data->product_status == 0) ? "<a class=\"btn btn-xs btn-red\">" . Yii::t("lang", "inactive") . "</a>" : "<a class=\"btn btn-xs btn-green\">" . Yii::t("lang", "active")  . "</a>"',
                                                        'htmlOptions' => array('style' => 'text-align:center;'),
                                                        'headerHtmlOptions' => array('style' => 'text-align: center;width:150px'),
                                                        'filter' => CHtml::activeDropDownList($model, 'product_status', array(0 => Yii::t('lang', 'inactive'), 1 => Yii::t('lang', 'active')), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . Yii::t('lang', 'status')))
                                                    ),
                                                    array(
                                                        'header' => Yii::t('lang', 'action'),
                                                        'class' => 'CButtonColumn',
                                                        'deleteConfirmation' => 'Are you sure you want to delete this record?',
                                                        'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                        'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                        'htmlOptions' => array('style' => 'text-align:center;'),
                                                        'template' => '{view} {copy} {update} {delete}',
                                                        'buttons' => array
                                                            (
                                                            'view' => array
                                                                (
                                                                'label' => '<i class="fa fa-search"></i>',
                                                                'options' => array('title' => 'View', 'target' => '_blank'),
                                                                'imageUrl' => FALSE
                                                            ),
                                                            'copy' => array
                                                                (
                                                                'label' => '<i class="fa fa-copy"></i>',
                                                                'imageUrl' => FALSE,
                                                                'url' => 'Yii::app()->createUrl("product/copy", array("id"=>$data->product_id))',
                                                                'options' => array(
                                                                    'title' => 'Copy',
                                                                    'data-confirm' => 'Do you really want to duplicate this Auktion?',
                                                                ),
                                                                'click' => $approveSellersJs,
                                                            ),
                                                            'update' => array
                                                                (
                                                                'label' => '<i class="fa fa-edit"></i>',
                                                                'options' => array('title' => 'Update', 'target' => '_blank'),
                                                                'imageUrl' => FALSE
                                                            ),
                                                            'delete' => array
                                                                (
                                                                'label' => '<i class="fa fa-times"></i>',
                                                                'options' => array('title' => 'Delete', 'class' => 'remove'),
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
                        <?php } else { ?>
                            <div class="tab-pane fade active in" id="product-list-other">
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
                                                    <?php $limitdata3 = isset($_GET['limitdata3']) ? $_GET['limitdata3'] : 10; ?>
                                                    <?php echo CHtml::dropDownList('limitdata3', $limitdata3, array('10' => '10', '25' => '25', '50' => '50', '75' => '75', '100' => '100'), array('class' => 'form-control')); ?>
                                                </div>                                    
                                            </div>
                                            <hr/>
                                            <?php
                                            $this->widget('zii.widgets.grid.CGridView', array(
                                                'id' => 'product-grid-sellers',
                                                'htmlOptions' => array('class' => 'dataTables_wrapper', 'role' => 'grid'),
                                                'dataProvider' => $model->search($role_id, 2, $sellers_id),
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
                                                        'name' => 'product_name',
                                                        'type' => 'raw',
                                                        'value' => '$data->product_name . (($data->product_copy == 1) ? " - <span class=\"text-green\"><i><strong>Copy</strong></i></span>" : "")',
                                                        'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                        'filter' => CHtml::activeTextField($model, 'product_name', array('placeholder' => $model->getAttributeLabel('product_name'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                    ),
                                                    array(
                                                        'name' => 'product_sellersID',
                                                        'value' => 'User::model()->getFullName($data->product_sellersID)',
                                                        'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                        'visible' => Yii::app()->user->name == 'Administrator',
                                                    //'filter' => CHtml::activeTextField($model, 'product_sellersID', array('placeholder' => 'User Name', 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                    //'filter' => CHtml::activeDropDownList($model, 'product_sellersID', Sellers::model()->getListWithoutSuperAdmin(), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . Yii::t('lang', 'user')))
                                                    ),
                                                    array(
                                                        'name' => 'product_created',
                                                        'value' => '$data->product_created',
                                                        'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;'),
                                                        'headerHtmlOptions' => array('style' => 'text-align: center;width:160px'),
                                                        'filter' => ''
                                                    ),
                                                    array(
                                                        'name' => 'product_status',
                                                        //'value' => '($data->product_status == 0) ? Yii::t("lang", "inactive") : Yii::t("lang", "active")',
                                                        'type' => 'raw',
                                                        'value' => '($data->product_status == 0) ? "<a class=\"btn btn-xs btn-red\">" . Yii::t("lang", "inactive") . "</a>" : "<a class=\"btn btn-xs btn-green\">" . Yii::t("lang", "active")  . "</a>"',
                                                        'htmlOptions' => array('style' => 'text-align:center;'),
                                                        'headerHtmlOptions' => array('style' => 'text-align: center;width:150px'),
                                                        'filter' => CHtml::activeDropDownList($model, 'product_status', array(0 => Yii::t('lang', 'inactive'), 1 => Yii::t('lang', 'active')), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . Yii::t('lang', 'status')))
                                                    ),
                                                    array(
                                                        'header' => Yii::t('lang', 'action'),
                                                        'class' => 'CButtonColumn',
                                                        'deleteConfirmation' => 'Are you sure you want to delete this record?',
                                                        'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                        'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                        'htmlOptions' => array('style' => 'text-align:center;'),
                                                        'template' => '{view} {copy} {update} {delete}',
                                                        'buttons' => array
                                                            (
                                                            'view' => array
                                                                (
                                                                'label' => '<i class="fa fa-search"></i>',
                                                                'options' => array('title' => 'View'),
                                                                'imageUrl' => FALSE
                                                            ),
                                                            'copy' => array
                                                                (
                                                                'label' => '<i class="fa fa-copy"></i>',
                                                                'imageUrl' => FALSE,
                                                                'url' => 'Yii::app()->createUrl("product/copy", array("id"=>$data->product_id))',
                                                                'options' => array(
                                                                    'title' => 'Copy',
                                                                    'data-confirm' => 'Do you really want to duplicate this Auktion?',
                                                                ),
                                                                'click' => $approveSellersJs,
                                                            ),
                                                            'update' => array
                                                                (
                                                                'label' => '<i class="fa fa-edit"></i>',
                                                                'options' => array('title' => 'Update'),
                                                                'imageUrl' => FALSE
                                                            ),
                                                            'delete' => array
                                                                (
                                                                'label' => '<i class="fa fa-times"></i>',
                                                                'options' => array('title' => 'Delete', 'class' => 'remove'),
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
                        <?php } ?>
                    </div>
                </div>            
            </div>
        </div>    
    </div>

</div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/bootstrap-typeahead.min.js" charset="UTF-8"></script>

<script type="text/javascript" async>
    $(document).ready(function () {
        $("#limitdata1").change(function () {
            var link = 'index?ajax=product-grid-sellers';
            var limitdata1 = $(this).val();

            $.ajax({
                url: link,
                type: "GET",
                data: {limitdata1: limitdata1},
                success: function (out_res) {
                    $("#maincontent").html(out_res);
                    $('html, body').animate({
                        scrollTop: $(".breadcrumb").offset().top - 10
                    }, 1000);
                    $('.nav-tabs a[href="#product-list-admin"]').tab('show');
                }
            });
        });

        $("#limitdata2").change(function () {
            var link = 'index?ajax=product-grid-sellers';
            var limitdata2 = $(this).val();

            $.ajax({
                url: link,
                type: "GET",
                data: {limitdata2: limitdata2},
                success: function (out_res) {
                    $("#maincontent").html(out_res);
                    $('html, body').animate({
                        scrollTop: $(".breadcrumb").offset().top - 10
                    }, 1000);
                    $('.nav-tabs a[href="#product-list-other"]').tab('show');
                }

            });
        });

        $("#limitdata3").change(function () {
            var link = 'index?ajax=product-grid-sellers';
            var limitdata3 = $(this).val();

            $.ajax({
                url: link,
                type: "GET",
                data: {limitdata3: limitdata3},
                success: function (out_res) {
                    $("#maincontent").html(out_res);
                    $('html, body').animate({
                        scrollTop: $(".breadcrumb").offset().top - 10
                    }, 1000);
                    $('.nav-tabs a[href="#product-list-other"]').tab('show');
                }
            });
        });
    });
</script>