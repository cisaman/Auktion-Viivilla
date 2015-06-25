<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' | Log In to Dashboard!';
//$utils = new Utils;
//echo $utils->passwordEncrypt(123456);
?>

<div class="col-md-4 col-md-offset-4">
    <div class="login-banner text-center">
        <h1><i class="fa fa-gears"></i> <?php echo Yii::app()->name; ?></h1>
    </div>
    <div class="portlet portlet-green">
        <div class="portlet-heading login-heading">
            <div class="portlet-title" style="width: 100%;">
                <h4 class="text-center"><strong>Log In to Dashboard!</strong></h4>
            </div>
            <div class="portlet-widgets">
                <!--<button class="btn btn-white btn-xs"><i class="fa fa-plus-circle"></i> New User</button>-->
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="portlet-body">

            <div role="form">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'sellers-form',
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

                <?php if (Yii::app()->user->hasFlash('msg')): ?>
                    <div class="alert alert-danger" id="successmsg">
                        <?php
                        echo Yii::app()->user->getFlash('msg');
                        $model->password = '';
                        ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'username'); ?>
                    <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'E-mail ID')); ?>
                    <?php echo $form->error($model, 'username'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'password'); ?>
                    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'Password')); ?>
                    <?php echo $form->error($model, 'password'); ?>                    
                </div>

                <?php echo CHtml::submitButton('Log In', array('class' => 'btn btn-lg btn-green btn-block', 'id' => 'btnLogin')); ?>

                <?php $this->endWidget(); ?>
                <br>
                <p class="small text-center">
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('dashboard/forgotpassword'); ?>">Forgot your password?</a>
                </p>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#LoginForm_username').blur(function() {
            if ($('#LoginForm_username_em_').css('display') != 'none') {
                $('#LoginForm_password').val('');
            }
        });

        $('#btnLogin').click(function() {
            if ($('#LoginForm_username_em_').css('display') != 'none') {
                $('#LoginForm_password').val('');
            }
        });
    });
</script>