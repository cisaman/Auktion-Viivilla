<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'manage') . ' ' . Yii::t('lang', 'products') . ' by Seller - (#' . $sellers_id . ') ' . $sellers_name;

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
                <li>
                    <h1>
                        <i class="fa fa-user"></i> <?php echo Yii::t('lang', 'manage'); ?> <?php echo Yii::t('lang', 'products'); ?> 
                        by Seller (#<?php echo $sellers_id; ?>) <?php echo $sellers_name; ?>
                    </h1>
                </li>
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
                    <li class="active">
                        <a href="#product-list" data-toggle="tab">
                            <?php echo Yii::t('lang', 'list_of'); ?> <?php echo Yii::t('lang', 'products'); ?> by Sellers (#<?php echo $sellers_id; ?>) <?php echo $sellers_name; ?>
                        </a>
                    </li>
                </ul>
                <div id="userTabContent" class="tab-content">                    
                    <div class="tab-pane fade active in" id="product-list">
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="table-responsive">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'product-grid-admin',
                                        'htmlOptions' => array('class' => 'dataTables_wrapper', 'role' => 'grid'),
                                        'dataProvider' => $model->search(NULL, NULL, $sellers_id),
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
                                                'value' => '$data->product_name . (($data->product_copy > 0) ? " - <span class=\"text-green\"><i><strong>Copy - $data->product_copy</strong></i></span>" : "")',
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
                                                'value' => '($data->product_status == 0) ? Yii::t("lang", "inactive") : Yii::t("lang", "active")',
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
                                                        'click' => $approveJs,
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
