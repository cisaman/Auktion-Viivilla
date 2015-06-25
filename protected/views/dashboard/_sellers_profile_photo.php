<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'sellers-profile-photo-form',
    'action' => 'profile',
    'enableClientValidation' => TRUE,
    'clientOptions' => array(
        'validateOnSubmit' => TRUE,
        'validateOnChange' => TRUE
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'autocomplete' => 'off',
        'role' => 'form'
        )));
?>


<h3><?php echo Yii::t('lang', 'profile_photo'); ?>:</h3>
<hr/>
<?php
$flag = 1;
$path = Utils::NoImagePath();
if (!empty($model->sellers_image)) {
    $path = Utils::UserImagePath() . $model->sellers_image;
    $flag = 0;
}
?>                                        
<div class="innerdiv">
    <img id="imagePreview" style="height: 200px;width: 100%;margin-bottom: 0;" src="<?php echo $path; ?>" class="img-responsive img-profile"/>
    <span id="span_close">
        <?php if ($flag == 0) { ?>
            <span id="close" style="display:none" title="Click here to delete this image"><i class="fa fa-times fa-2x"></i></span>
        <?php } ?>
    </span>                                                
</div>
<br>                                                                                    
<div class="form-group">
    <label><?php echo Yii::t('lang', 'msg_new_image'); ?></label>                                            
    <?php echo $form->fileField($model, 'sellers_image'); ?>
    <?php echo $form->error($model, 'sellers_image', array('class' => 'text-red')); ?>
    <p class="help-block text-orange"><?php echo Yii::t('lang', 'msg_images'); ?></p>
</div>                                        

<?php echo CHtml::submitButton(Yii::t('lang', 'update') . ' ' . Yii::t('lang', 'profile_photo'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSaveProfilePicture', 'name' => 'btnSaveProfilePicture')); ?>
&nbsp;&nbsp;<button class="btn btn-square btn-orange"><?php echo Yii::t('lang', 'reset'); ?></button>    

<?php $this->endWidget(); ?>