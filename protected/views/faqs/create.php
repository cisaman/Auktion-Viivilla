<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'add') . ' ' . Yii::t('lang', 'faqs');
?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-user"></i> <?php echo Yii::t('lang', 'manage'); ?> <?php echo Yii::t('lang', 'faqs'); ?> | <small><a class="text-blue" href="<?php echo Yii::app()->createAbsoluteUrl('faqs/index'); ?>"><?php echo Yii::t('lang', 'back_to_listing'); ?></a></small></h1></li>
            </ol>
        </div>
    </div>    
</div>
<!-- end PAGE TITLE AREA -->

<div class="row">
    <div class="col-lg-12">

        <div class="portlet portlet-default">
            <div class="portlet-body">
                <ul id="userTab" class="nav nav-tabs">
                    <li class="active"><a href="#faqs-add" data-toggle="tab"><?php echo Yii::t('lang', 'add'); ?> <?php echo Yii::t('lang', 'faqs'); ?></a></li>
                </ul>
                <div id="userTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="faqs-add">                            
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