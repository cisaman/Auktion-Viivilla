<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'manage') . ' ' . Yii::t('lang', 'faqs');

$super_role_id = Yii::app()->session['admin_data']['admin_role_id'];

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#faqs-grid').yiiGridView('update', {
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
                <li><h1><i class="fa fa-user"></i> <?php echo Yii::t('lang', 'manage'); ?> <?php echo Yii::t('lang', 'faqs'); ?></h1></li>
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
                    <li class="active"><a href="#faqs-list" data-toggle="tab"><?php echo Yii::t('lang', 'list_of'); ?> <?php echo Yii::t('lang', 'faqs'); ?></a></li>                    
                    <li class=""><a href="#faqs-add" data-toggle="tab"><?php echo Yii::t('lang', 'add'); ?> <?php echo Yii::t('lang', 'faqs'); ?></a></li>
                    <li class=""><a href="#faqs-order" data-toggle="tab"><?php echo Yii::t('lang', 'order'); ?> <?php echo Yii::t('lang', 'faqs'); ?></a></li>
                </ul>
                <div id="userTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="faqs-list">
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="table-responsive">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'faqs-grid',
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
                                                'name' => 'faqs_ques',
                                                'value' => '$data->faqs_ques',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'faqs_ques', array('placeholder' => $model->getAttributeLabel('faqs_ques'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
//                                            array(
//                                                'name' => 'faqs_ans',
//                                                'value' => '$data->faqs_ans',
//                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
//                                                'filter' => CHtml::activeTextField($model, 'faqs_ans', array('placeholder' => $model->getAttributeLabel('faqs_ans'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
//                                            ),
                                            array(
                                                'name' => 'faqs_status',
                                                //'value' => '($data->faqs_status == 0) ? Yii::t("lang", "inactive") : Yii::t("lang", "active")',
                                                'type' => 'raw',
                                                'value' => '($data->faqs_status == 0) ? "<a class=\"btn btn-xs btn-red\">" . Yii::t("lang", "inactive") . "</a>" : "<a class=\"btn btn-xs btn-green\">" . Yii::t("lang", "active")  . "</a>"',
                                                'htmlOptions' => array('style' => 'text-align:center;'),
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                'filter' => CHtml::activeDropDownList($model, 'faqs_status', array(0 => Yii::t('lang', 'inactive'), 1 => Yii::t('lang', 'active')), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . Yii::t('lang', 'status')))
                                            ),
                                            array(
                                                'header' => Yii::t('lang', 'action'),
                                                'class' => 'CButtonColumn',
                                                'deleteConfirmation' => Yii::t('lang', 'delete_record_msg'),
                                                'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:90px'),
                                                'htmlOptions' => array('style' => 'text-align:center;'),
                                                'template' => '{view} {update} {delete}',
                                                'visible' => Yii::app()->user->name == 'Administrator',
                                                'buttons' => array
                                                    (
                                                    'view' => array
                                                        (
                                                        'label' => '<i class="fa fa-search"></i>',
                                                        'options' => array('title' => 'View'),
                                                        'imageUrl' => FALSE
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
                                        'emptyText' => '<span class="text-danger text-center">' . Yii::t('lang', 'no_record_msg') . '</span>',
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>    

                    <?php if ($super_role_id == 1) { ?>
                        <div class="tab-pane fade" id="faqs-add">                            
                            <div class="row">
                                <div class="col-md-12">

                                    <?php $this->renderPartial('_form', array('model' => $model)); ?>

                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="faqs-order">                            
                            <div class="row">
                                <div class="col-md-12">

                                    <?php $this->renderPartial('_faq_order', array('model' => $model)); ?>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>