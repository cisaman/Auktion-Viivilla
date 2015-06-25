<?php $this->pageTitle = Yii::app()->name . ' | Forgot Password'; ?>

<div class="col-md-4 col-md-offset-4">
    <div class="login-banner text-center">
        <h1><i class="fa fa-gears"></i> <?php echo Yii::app()->name; ?></h1>
    </div>
    <div class="portlet portlet-green">
        <div class="portlet-heading login-heading">
            <div class="portlet-title">
                <h4><strong>Forgot Password</strong>
                </h4>
            </div>            
            <div class="clearfix"></div>
        </div>
        <div class="portlet-body">

            <?php if (Yii::app()->user->hasFlash('message')): ?>
                <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?> alert-dismissable" id="successmsg">
                    <?php echo Yii::app()->user->getFlash('message'); ?>
                </div>
            <?php endif; ?>

            <div role="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'forgot-password-form',
                    'enableClientValidation' => TRUE,
                    'clientOptions' => array(
                        'validateOnSubmit' => TRUE,
                        'validateOnChange' => TRUE
                    ),
                    'htmlOptions' => array(
                        'autocomplete' => 'off'
                    ),
                    'focus' => array($model, 'username'),
                ));
                ?>   

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'username'); ?>
                    <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'E-mail')); ?>
                    <?php echo $form->error($model, 'username'); ?>
                </div>

                <?php echo CHtml::submitButton('Forgot Password', array('class' => 'btn btn-lg btn-green btn-block', 'id' => 'btnForgotPassword')); ?>

                <?php $this->endWidget(); ?>
                <br>
                <p class="small text-center">
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('dashboard/sellers'); ?>">Back to Log In</a>
                </p>
            </div>

        </div>
    </div>
</div>