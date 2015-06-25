<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' | Add Admin';
?>

<!-- begin PAGE TITLE AREA -->
<!--<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-user"></i> Add Admin | <a href="<?php //echo Yii::app()->createAbsoluteUrl('user/index'); ?>">Back to Admin Listing</a></h1></li>
            </ol>
        </div>
    </div>    
</div>-->
<!-- end PAGE TITLE AREA -->

<div class="row">                
    <div class="col-lg-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4><i class="fa fa-user"></i> Manage Users - Add Admin | <a class="text-gold" href="<?php echo Yii::app()->createAbsoluteUrl('user/index'); ?>">Back to Admin Listing</a></h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-collapse collapse in" id="basicFormExample">
                <div class="portlet-body">

                    <?php $this->renderPartial('_admin_form', array('model' => $model)); ?>

                </div>
            </div>
        </div>        
    </div>
</div>