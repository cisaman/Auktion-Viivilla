<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'manage') . ' ' . Yii::t('lang', 'products');

$super_role_id = Yii::app()->session['admin_data']['admin_role_id'];

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
?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-user"></i> <?php echo Yii::t('lang', 'manage'); ?> <?php echo Yii::t('lang', 'products'); ?></h1></li>
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
                    <?php if ($super_role_id == 1) { ?>
                        <li class="active"><a href="#product-list-admin" data-toggle="tab"><?php echo Yii::t('lang', 'list_of'); ?> <?php echo Yii::t('lang', 'products'); ?> - <?php echo Yii::t('lang', 'administrator'); ?></a></li>
                    <?php } ?>
                    <li class="<?php echo ($super_role_id == 1) ? '' : 'active'; ?>"><a href="#product-list-other" data-toggle="tab"><?php echo Yii::t('lang', 'list_of'); ?> <?php echo Yii::t('lang', 'products'); ?><?php echo ($super_role_id == 1) ? ' - ' . Yii::t('lang', 'other') : ''; ?></a></li>
                    <li class=""><a href="#product-add" data-toggle="tab"><?php echo Yii::t('lang', 'add'); ?> <?php echo Yii::t('lang', 'product'); ?></a></li>
                </ul>
                <div id="userTabContent" class="tab-content">
                    <?php if ($super_role_id == 1) { ?>
                        <div class="tab-pane fade active in" id="product-list-admin">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="table-responsive">
                                        <?php
                                        $this->widget('zii.widgets.grid.CGridView', array(
                                            'id' => 'product-grid-admin',
                                            'htmlOptions' => array('class' => 'dataTables_wrapper', 'role' => 'grid'),
                                            'dataProvider' => $model->search($super_role_id, 1),
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
                                                    'value' => '$data->product_name',
                                                    'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                    'filter' => CHtml::activeTextField($model, 'product_name', array('placeholder' => $model->getAttributeLabel('product_name'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                ),
                                                array(
                                                    'name' => 'product_status',
                                                    'value' => '($data->product_status == 0) ? Yii::t("lang", "inactive") : Yii::t("lang", "active")',
                                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                    'filter' => CHtml::activeDropDownList($model, 'product_status', array(0 => Yii::t('lang', 'inactive'), 1 => Yii::t('lang', 'active')), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . Yii::t('lang', 'status')))
                                                ),
                                                array(
                                                    'header' => Yii::t('lang', 'action'),
                                                    'class' => 'CButtonColumn',
                                                    'deleteConfirmation' => Yii::t('lang', 'delete_record_msg'),
                                                    'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                    'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                    'htmlOptions' => array('style' => 'text-align:center;'),
                                                    'template' => '{update} {delete}',
                                                    'visible' => Yii::app()->user->name == 'Administrator',
                                                    'buttons' => array
                                                        (
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
                                            'template' => '{items}<div class = "row"><div class = "col-xs-6">{summary}</div><div class = "col-xs-6">{pager}</div></div>',
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
                    <?php } ?>

                    <div class="tab-pane fade<?php echo ($super_role_id == 1) ? '' : ' active in'; ?>" id="product-list-other">
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="table-responsive">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'product-grid-other',
                                        'htmlOptions' => array('class' => 'dataTables_wrapper', 'role' => 'grid'),
                                        'dataProvider' => $model->search($super_role_id, 2),
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
                                                'value' => '$data->product_name',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'product_name', array('placeholder' => $model->getAttributeLabel('product_name'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'name' => 'product_userID',
                                                'value' => 'User::model()->getFullName($data->product_userID)',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'visible' => Yii::app()->user->name == 'Administrator',
                                                //'filter' => CHtml::activeTextField($model, 'product_userID', array('placeholder' => 'User Name', 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                                'filter' => CHtml::activeDropDownList($model, 'product_userID', User::model()->getListWithoutSuperAdmin(), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . Yii::t('lang', 'user')))
                                            ),
                                            array(
                                                'name' => 'product_status',
                                                'value' => '($data->product_status == 0) ? Yii::t("lang", "inactive") : Yii::t("lang", "active")',
                                                'htmlOptions' => array('style' => 'text-align:center;'),
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                'filter' => CHtml::activeDropDownList($model, 'product_status', array(0 => Yii::t('lang', 'inactive'), 1 => Yii::t('lang', 'active')), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . Yii::t('lang', 'status')))
                                            ),
                                            array(
                                                'header' => Yii::t('lang', 'action'),
                                                'class' => 'CButtonColumn',
                                                'deleteConfirmation' => 'Are you sure you want to delete this record?',
                                                'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                'htmlOptions' => array('style' => 'text-align:center;'),
                                                'template' => '{update} {delete}',
                                                'buttons' => array
                                                    (
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
                                        'template' => '{items}<div class = "row"><div class = "col-xs-6">{summary}</div><div class = "col-xs-6">{pager}</div></div>',
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

                    <div class="tab-pane fade" id="product-add">                            
                        <div class="row">
                            <div class="col-md-12">

                                <?php $this->renderPartial('_form', array('model' => $model)); ?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.portlet-body -->
        </div>
        <!-- /.portlet -->

    </div>
    <!-- /.col-lg-12 -->
</div>