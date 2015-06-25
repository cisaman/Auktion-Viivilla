<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'manage') . ' ' . Yii::t('lang', 'messages');

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });

    $('.search-form form').submit(function(){
        $('#contact-grid').yiiGridView('update', {
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
                <li><h1><i class="fa fa-user"></i> <?php echo Yii::t('lang', 'manage'); ?> <?php echo Yii::t('lang', 'messages'); ?></h1></li>
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
                    <li class="active"><a href="#contact-list" data-toggle="tab"><?php echo Yii::t('lang', 'list_of'); ?> <?php echo Yii::t('lang', 'messages'); ?></a></li>
                </ul>
                <div id="userTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="contact-list">
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="table-responsive">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'contact-grid',
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
                                                'name' => 'contact_name',
                                                'type' => 'raw',
                                                //'value' => '$data->contact_status == 1 ? "<strong>" . $data->contact_name . "</strong>" : $data->contact_name',
                                                'value' => 'CHtml::link($data->contact_status == 1 ? "<strong>" . $data->contact_name . "</strong>" : $data->contact_name, Yii::app()->createAbsoluteUrl("contact/view/" . $data->contact_id), array("style" => "display: block;"))',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'contact_name', array('placeholder' => $model->getAttributeLabel('contact_name'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'name' => 'contact_subject',
                                                'type' => 'raw',
                                                //'value' => '$data->contact_status == 1 ? "<strong>" . $data->contact_subject . "</strong>" : $data->contact_subject',
                                                'value' => 'CHtml::link($data->contact_status == 1 ? "<strong>" . $data->contact_subject . "</strong>" : $data->contact_subject, Yii::app()->createAbsoluteUrl("contact/view/" . $data->contact_id), array("style" => "display: block;"))',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'contact_subject', array('placeholder' => $model->getAttributeLabel('contact_subject'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'name' => 'contact_productID',
                                                'type' => 'raw',
                                                'value' => '$data->contact_status == 1 ? "<strong>" . Product::model()->getProductNameById($data->contact_productID) . "</strong>" : "-"',
                                                //'value' => 'CHtml::link($data->contact_status == 1 ? "<strong>" . $data->contact_productID . "</strong>" : $data->contact_productID, Yii::app()->createAbsoluteUrl("contact/view/" . $data->contact_id), array("style" => "display: block;"))',
                                                //'value' => ($data->contact_productID == 0) ? "-" : CHtml::link($data->contact_status == 1 ? "<strong>" . Product::model()->getProductNameById($data->contact_productID) . "</strong>" : Product::model()->findByPk($data->contact_productID)->product_name, Yii::app()->createAbsoluteUrl("contact/view/" . $data->contact_id), array("style" => "display: block;")),
                                                'htmlOptions' => array('style' => 'text-align:center;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'contact_productID', array('placeholder' => $model->getAttributeLabel('contact_productID'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'name' => 'contact_created',
                                                'type' => 'raw',
                                                //'value' => '$data->contact_created',
                                                'value' => 'CHtml::link($data->contact_created, Yii::app()->createAbsoluteUrl("contact/view/" . $data->contact_id), array("style" => "display: block;"))',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'contact_created', array('placeholder' => $model->getAttributeLabel('contact_created'), 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'header' => Yii::t('lang', 'action'),
                                                'class' => 'CButtonColumn',
                                                'deleteConfirmation' => 'Are you sure you want to delete this Contact Information?',
                                                'afterDelete' => 'function(link,success,data){ if(success) { $("#statusMsg").css("display", "block"); $("#statusMsg").html(data); $("#statusMsg").animate({opacity: 1.0}, 3000).fadeOut("fast");}}',
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:120px'),
                                                'htmlOptions' => array('style' => 'text-align:center;'),
                                                'template' => '{view} {delete}',
                                                'buttons' => array
                                                    (
                                                    'view' => array
                                                        (
                                                        'label' => '<i class="fa fa-search"></i>',
                                                        'options' => array('title' => 'View Seller'),
                                                        'imageUrl' => FALSE
                                                    ),
                                                    'delete' => array
                                                        (
                                                        'label' => '<i class="fa fa-times"></i>',
                                                        'options' => array('title' => 'Delete', 'class' => 'remove'),
                                                        'imageUrl' => FALSE,
                                                        'visible' => "Yii::app()->user->name == 'Admin'"
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
                </div>
            </div>            
        </div>
    </div>    
</div>