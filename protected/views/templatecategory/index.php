<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'manage') . ' ' . Yii::t('lang', 'templatecategory');

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#template-category-grid').yiiGridView('update', {
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
                <li><h1><i class="fa fa-user"></i> <?php echo Yii::t('lang', 'manage'); ?> <?php echo Yii::t('lang', 'templatecategory'); ?></h1></li>
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
                    <li class="active"><a href="#template-list" data-toggle="tab"><?php echo Yii::t('lang', 'list_of'); ?> <?php echo Yii::t('lang', 'templatecategory'); ?></a></li>
                    <li class=""><a href="#template-add" data-toggle="tab"><?php echo Yii::t('lang', 'add'); ?> <?php echo Yii::t('lang', 'templatecategory'); ?></a></li>
                </ul>
                <div id="userTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="template-list">
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="table-responsive">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'template-category-grid',
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
                                                'name' => 'template_category_title',
                                                'value' => '$data->template_category_title',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'template_category_title', array('placeholder' => $model->getAttributeLabel('template_category_title'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'name' => 'template_category_table_name',
                                                'value' => '$data->template_category_table_name',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'template_category_table_name', array('placeholder' => $model->getAttributeLabel('template_category_table_name'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'name' => 'template_category_field_names',
                                                'value' => '$data->template_category_field_names',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'template_category_field_names', array('placeholder' => $model->getAttributeLabel('template_category_field_names'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'header' => Yii::t('lang', 'action'),
                                                'class' => 'CButtonColumn',
                                                'deleteConfirmation' => Yii::t('lang', 'delete_record_msg'),
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

                    <div class="tab-pane fade" id="template-add">                            
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