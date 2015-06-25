<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'changepassword');

$this->breadcrumbs = array(
    Yii::t('lang', 'changepassword'),
);
?>

<div class="col-lg-12 col-md-12 col-sm-12 product-page login-main bidding-end">
    <div class="row">
        <div class="login-page-detail">
            <div class="login-header">                
                <h1><?php echo Yii::t('lang', 'member'); ?> <?php echo $user->buyers_fname . ' ' . $user->buyers_lname; ?></h1>
            </div>
            <div class="bidding-main">
                <div class="bidd-inner">
                    <div class="bottom-head">
                        <h2><?php echo Yii::t('lang', 'changepassword'); ?></h2>
                    </div>
                    <div class="bid-history">

                        <?php if (Yii::app()->user->hasFlash('message')): ?>
                            <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?>" id="successmsg">
                                <?php echo Yii::app()->user->getFlash('message'); ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'change-password-form',
                            'action' => Yii::app()->createAbsoluteUrl('site/changepassword'),
                            'enableAjaxValidation' => TRUE,
                            'enableClientValidation' => TRUE,
                            'clientOptions' => array(
                                'validateOnSubmit' => TRUE,
                                'validateOnChange' => TRUE,
                            ),
                            'htmlOptions' => array(
                                'autocomplete' => 'off',
                                'role' => 'form'
                            ),
                        ));
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 my_account">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">                                    
                                    <?php echo $form->label($model, 'old_password', array('class' => 'control-label  cstm-label')); ?>
                                    <?php echo $form->passwordField($model, 'old_password', array('class' => 'form-control', 'maxlength' => 16 ,'placeholder' => $model->getAttributeLabel('old_password'))); ?>
                                    <?php echo $form->error($model, 'old_password'); ?>
                                </div>
                                <div class="form-group">                                    
                                    <?php echo $form->label($model, 'new_password', array('class' => 'control-label  cstm-label')); ?>
                                    <?php echo $form->passwordField($model, 'new_password', array('class' => 'form-control', 'maxlength' => 16 ,'placeholder' => $model->getAttributeLabel('new_password'))); ?>
                                    <?php echo $form->error($model, 'new_password'); ?>
                                </div>                                
                                <div class="form-group">                                    
                                    <?php echo $form->label($model, 'repeat_new_password', array('class' => 'control-label  cstm-label')); ?>
                                    <?php echo $form->passwordField($model, 'repeat_new_password', array('class' => 'form-control', 'maxlength' => 16 ,'placeholder' => $model->getAttributeLabel('repeat_new_password'))); ?>
                                    <?php echo $form->error($model, 'repeat_new_password'); ?>
                                </div>
                                <div class="form-group">   
                                    <?php echo CHtml::submitButton(Yii::t('lang', 'save_changes'), array('class' => 'save-btn', 'id' => 'btnSaveChanged')); ?>
                                </div>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .acct-log{margin-top: 10px !important;}
    #account:hover{cursor: pointer !important;}
    .bid-history{overflow: hidden;}
    .save-btn{margin-top: 0px !important;}
    .btm-block1 {padding: 10px 0 !important;}
    .required {color: red;}
</style>

<script type="text/javascript">
    $(document).ready(function() {

        $('html, body').animate({
            scrollTop: $('.bidd-inner').offset().top - 70
        }, 1500);

        $("#successmsg").animate({opacity: 1.0}, 5000).fadeOut("slow");

    });
</script>

<script type="text/javascript">

    $(document).ready(function() {
        function trimspace(element) {
            var cat = $('#' + element).val();
            cat = cat.replace(/ +(?= )/g, '');
            if (cat != " ") {
                $('#' + element).val(cat);
            } else {
                $('#' + element).val($.trim(cat));
            }
        }

        $('input[type="text"]').on('keyup', function() {
            trimspace(this.id);
        });

        $('textarea').on('keyup', function() {
            trimspace(this.id);
        });
    });

</script>