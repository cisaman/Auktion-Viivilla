<?php $this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'update') . ' ' . Yii::t('lang', 'buyers') . '(#' . $model->buyers_id . ')'; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li>
                    <h1>
                        <i class="fa fa-user"></i> <?php echo Yii::t('lang', 'manage'); ?> <?php echo Yii::t('lang', 'buyers'); ?> | 
                        <small>
                            <a class="text-blue" href="<?php echo Yii::app()->createAbsoluteUrl('buyers/index'); ?>">
                                <?php echo Yii::t('lang', 'back_to_listing'); ?></a>
                        </small>
                    </h1>
                </li>
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
                    <li class="active">
                        <a href="#buyers-update" data-toggle="tab">
                            <?php echo Yii::t('lang', 'update'); ?> <?php echo Yii::t('lang', 'buyers'); ?>(#<?php echo $model->buyers_id; ?>)
                        </a>
                    </li>
                </ul>
                <div id="userTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="buyers-update">                            
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
