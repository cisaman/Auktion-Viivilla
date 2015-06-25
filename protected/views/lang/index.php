<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' | Manage Language Translation';

$super_role_id = Yii::app()->session['admin_data']['admin_role_id'];

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lang-grid').yiiGridView('update', {
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
                <li><h1><i class="fa fa-user"></i> Manage Language Translation</h1></li>
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
                    <li class="active"><a href="#lang-list" data-toggle="tab">List of Language Translation</a></li>
                    <?php if ($super_role_id == 1) { ?>
                        <li class=""><a href="#lang-add" data-toggle="tab">Add Language Translation</a></li>
                    <?php } ?>
                </ul>
                <div id="userTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="lang-list">
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="table-responsive">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'lang-grid',
                                        'htmlOptions' => array('class' => 'dataTables_wrapper', 'role' => 'grid'),
                                        'dataProvider' => $model->search(),
                                        'filter' => $model,
                                        'columns' => array(
                                            array(
                                                'header' => 'S. No.',
                                                'name' => 'S. No.',
                                                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                                'htmlOptions' => array('style' => 'text-align:center'),
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:60px'),
                                            ),
                                            array(
                                                'header' => 'Language',
                                                'value' => 'Languages::model()->getLanguageNameByCode($data->lang_shortcode)',
                                                'headerHtmlOptions' => array('style' => 'width:100px'),
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeDropDownList($model, 'language_code', CHtml::listData(Languages::model()->findAll(), 'lang_code', 'lang_name'), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => 'Please Select Language'))
                                            ),
//                                            array(
//                                                'name' => 'lang_shortcode',
//                                                'value' => '$data->lang_shortcode',
//                                                'headerHtmlOptions' => array('style' => 'width:150px'),
//                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
//                                                'filter' => CHtml::activeTextField($model, 'lang_shortcode', array('placeholder' => 'Language Short Code', 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
//                                            ),
                                            array(
                                                'name' => 'lang_attribute',
                                                'value' => '$data->lang_attribute',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'lang_attribute', array('placeholder' => 'Language Attribute', 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'name' => 'lang_attribute_t',
                                                'value' => '$data->lang_attribute_t',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'lang_attribute_t', array('placeholder' => 'Language Attribute Translation', 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'header' => 'Action',
                                                'class' => 'CButtonColumn',
                                                'deleteConfirmation' => 'Are you sure you want to delete this record?',
                                                'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:80px'),
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

                    <?php if ($super_role_id == 1) { ?>
                        <div class="tab-pane fade" id="lang-add">                            
                            <div class="row">
                                <div class="col-md-12">

                                    <?php $this->renderPartial('_form', array('model' => $model)); ?>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- /.portlet-body -->
        </div>
        <!-- /.portlet -->

    </div>
    <!-- /.col-lg-12 -->
</div>