<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' | Manage Cities';

$super_role_id = Yii::app()->session['admin_data']['admin_role_id'];

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#city-grid').yiiGridView('update', {
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
                <li><h1><i class="fa fa-user"></i> Manage Cities</h1></li>
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
                    <li class="active"><a href="#city-list" data-toggle="tab">List of Cities</a></li>
                    <?php if ($super_role_id == 1) { ?>
                        <li class=""><a href="#city-add" data-toggle="tab">Add City</a></li>
                    <?php } ?>
                </ul>
                <div id="userTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="city-list">
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="table-responsive">
                                    <?php
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                        'id' => 'country-grid',
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
//                                            array(
//                                                'header' => 'Country',
//                                                'value' => 'State::model()->getCountryNameByStateID($data->city_stateID)',
//                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
//                                                'filter' => CHtml::activeDropDownList($model, 'state_countryID', CHtml::listData(Country::model()->findAll(), 'country_id', 'country_name'), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => 'Please Select Country'))
//                                            ),
                                            array(
                                                'name' => 'city_stateID',
                                                'value' => 'State::model()->getStateName($data->city_stateID)',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeDropDownList($model, 'city_stateID', CHtml::listData(State::model()->findAll(), "state_id", "state_name"), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => 'Please Select State'))
                                            ),
                                            array(
                                                'name' => 'city_name',
                                                'value' => '$data->city_name',
                                                'htmlOptions' => array('style' => 'text-align:justify;-ms-word-break: break-all;word-break: break-all;'),
                                                'filter' => CHtml::activeTextField($model, 'city_name', array('placeholder' => 'City Name', 'style' => 'font-style:italic', 'autocomplete' => 'off', 'class' => 'form-control'))
                                            ),
                                            array(
                                                'name' => 'city_status',
                                                'value' => '($data->city_status == 0) ? "Inactive" : "Active"',
                                                'htmlOptions' => array('style' => 'text-align:center;'),
                                                'headerHtmlOptions' => array('style' => 'text-align: center;width:150px'),
                                                'filter' => CHtml::activeDropDownList($model, 'city_status', array(0 => 'Inactive', 1 => 'Active'), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => 'Please Select Status'))
                                            ),
                                            array(
                                                'header' => 'Action',
                                                'class' => 'CButtonColumn',
                                                'deleteConfirmation' => 'Are you sure you want to delete this record?',
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

                    <?php if ($super_role_id == 1) { ?>
                        <div class="tab-pane fade" id="city-add">                            
                            <div class="row">
                                <div class="col-md-12">

                                    <?php $this->renderPartial('_form', array('model' => $model)); ?>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>            
        </div>
    </div>    
</div>


<script type="text/javascript">

    /*
     $(document).ready(function() {
     $("#City_state_countryID").change(function() {
     var countryID = $(this).val();
     var url = '<?php //echo Utils::GetBaseUrl(); ?>/index.php/state/getcountries';
     $.getJSON(
     url,
     {country_id: countryID},
     function(data) {
     $("#City_city_stateID").html('');
     }
     );
     });
     });
     */

</script>