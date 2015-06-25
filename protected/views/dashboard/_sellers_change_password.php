<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'sellers-change-password-form',
    'enableClientValidation' => TRUE,
    'clientOptions' => array(
        'validateOnSubmit' => TRUE,
        'validateOnChange' => TRUE
    ),
    'htmlOptions' => array(
        'autocomplete' => 'off',
        'role' => 'form'
    ),
    'focus' => array($model, 'sellers_password'),
        ));
?>

<h3><?php echo Yii::t('lang', 'change_password'); ?>:</h3>
<hr/>
<div class="form-group">
    <label for="old_password">Old Password <span class="required">*</span></label>
    <input type="password" class="form-control" placeholder="Old Password" name="old_password" id="old_password" maxlength="16"/>
    <div id="old_password_err" class="text-red"></div>
</div>
<div class="form-group">
    <label for="new_password">New Password <span class="required">*</span></label>
    <input type="password" class="form-control" placeholder="New Password" name="new_password" id="new_password" maxlength="16"/>
    <div id="new_password_err" class="text-red"></div>
</div>
<div class="form-group">
    <label for="new_password_again">Re-type New Password <span class="required">*</span></label>
    <input type="password" class="form-control" placeholder="Re-type New Password" name="new_password_again" id="new_password_again" maxlength="16"/>                                                                
    <div id="new_password_again_err" class="text-red"></div>
</div>

<?php echo CHtml::submitButton('Update Password', array('class' => 'btn btn-green btn-square', 'id' => 'btnSavePassword', 'name' => 'btnSavePassword')); ?>  
&nbsp;&nbsp;<button class="btn btn-square btn-orange">Cancel</button>

<?php $this->endWidget(); ?>