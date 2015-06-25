<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-contact-form',
    'action' => array('site/contact'),
    'enableAjaxValidation' => TRUE,
    'enableClientValidation' => TRUE,
    'clientOptions' => array(
        'validateOnSubmit' => TRUE,
        'validateOnChange' => TRUE,
        'validateOnType' => TRUE,
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'autocomplete' => 'off'),
    'focus' => 'contact_name'
        )
);
?>   

<div class="contact-detail">

    <?php if (Yii::app()->user->hasFlash('message')): ?>
        <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?>" id="successmsg">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>

    <div class="input-field-one">
        <div class="row">
            <div class="col-md-6">
                <?php echo $form->textField($model, 'contact_name', array('class' => 'fill-part', 'placeholder' => 'Ditt namn *Krävs')); ?>
                <?php echo $form->error($model, 'contact_name'); ?>        
            </div>
            <div class="col-md-6">
                <?php echo $form->textField($model, 'contact_email', array('class' => 'fill-part', 'placeholder' => 'Din mailadress *Krävs')); ?>
                <?php echo $form->error($model, 'contact_email'); ?>
            </div>
        </div>       
    </div>
    <div class="input-field-two">
        <?php echo $form->textField($model, 'contact_subject', array('class' => 'fill-part', 'placeholder' => 'Ämne')); ?>
        <?php echo $form->error($model, 'contact_subject'); ?>        
    </div>
    <div class="input-field-one">
        <?php echo $form->textArea($model, 'contact_message', array('rows' => 5, 'placeholder' => 'Ditt meddelande')); ?>
        <?php echo $form->error($model, 'contact_message'); ?>         
    </div>        
</div>

<div class="captcha-part">
    <div class="leftcap">
        <span>Säkerhetskod:</span>
    </div>
    <div class="rightcap">
        <span class="right-cap-info">
            <p>Vänligen ange koden här *Krävs</p>
            <div class="type-here">
                <?php if (CCaptcha::checkRequirements()): ?>
                    <?php echo $form->textField($model, 'verifyCode', array('class' => 'type-code')); ?>
                    <?php echo $form->error($model, 'verifyCode'); ?>
                    <?php
                    $this->widget("CCaptcha", array(
                        'showRefreshButton' => false,
                        'clickableImage' => true,
                    ));
                    ?>
                <?php endif; ?>
            </div>
            <p>Ny kod? <a href="javascript:void(0);" id="refresh">Uppdatera</a> </p>                    
        </span>
    </div>
</div
<div class="input-field-btn">
    <?php echo CHtml::submitButton('Skicka', array('id' => 'btnLogin', 'class' => 'btnSend')); ?>    
</div>

<?php $this->endWidget(); ?>

<style type="text/css">
    .fill-part{
        width: 100% !important;
    }

    .btnSend {
        background: none repeat scroll 0 0 #004784 !important;
        border: 0 none !important;
        color: #fff !important;
        cursor: pointer !important;
        font-size: 14px !important;
        padding: 5px 11px !important;
        text-align: center !important;
        text-transform: capitalize !important;
    }

    .type-here a {
        color: #ee262c;
        font-size: 30px;
        font-weight: lighter;
        text-decoration: none;
        text-align: center;
    }

    .type-here {
        width: 100%;
    }

</style>
<script type="text/javascript">
    $("document").ready(function() {
        $("#refresh").on("click", function() {
            $("#yw0").click();
        });
    });
</script>