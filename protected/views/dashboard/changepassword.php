<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' | Profile';
?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-key"></i> Change Password</h1></li>
            </ol>
        </div>
    </div>    
</div>
<!-- end PAGE TITLE AREA -->

<div class="row">        
    <div class="col-lg-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Change Password</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-collapse collapse in" id="basicFormExample">
                <div class="portlet-body">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'district-form',
                        'enableClientValidation' => TRUE,
                        'clientOptions' => array(
                            'validateOnSubmit' => TRUE,
                            'validateOnChange' => TRUE
                        ),
                        'htmlOptions' => array(
                            'autocomplete' => 'off',
                            'role' => 'form'
                        ),
                        'focus' => array($model, 'user_password'),
                    ));
                    ?>

                    <?php if (Yii::app()->user->hasFlash('message')): ?>
                        <div class="alert alert-success alert-dismissable" id="successmsg">
                            <?php echo Yii::app()->user->getFlash('message'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="form-group">
                                <label for="old_password">Old Password <span class="required">*</span></label>
                                <input type="password" class="form-control" placeholder="Old Password"/>                                
                                <div id="old_password_err" class="text-red"></div>
                            </div>

                            <div class="form-group">
                                <label for="new_password">New Password <span class="required">*</span></label>
                                <input type="password" class="form-control" placeholder="New Password"/>
                                <div id="new_password_err" class="text-red"></div>
                            </div>

                            <div class="form-group">
                                <label for="new_password_again">Re-type New Password <span class="required">*</span></label>
                                <input type="password" class="form-control" placeholder="Re-type New Password"/>                                                                
                                <div id="new_password_again_err" class="text-red"></div>
                            </div>

                            <?php echo CHtml::submitButton('Update Password', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave')); ?>  
                        </div>
                    </div>                    

                    <?php $this->endWidget(); ?>

                </div>
            </div>
        </div>        
    </div>
</div>