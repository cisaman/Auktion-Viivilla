<?php
$create_url = Yii::app()->createAbsoluteUrl('lang/create');
$update_url = Yii::app()->createAbsoluteUrl('lang/update/' . $model->lang_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'lang-form',
    'action' => ($model->isNewRecord) ? $create_url : $update_url,
    'enableAjaxValidation' => TRUE,
    'enableClientValidation' => TRUE,
    'clientOptions' => array(
        'validateOnSubmit' => TRUE,
        'validateOnChange' => TRUE
    ),
    'htmlOptions' => array(
        'autocomplete' => 'off',
        'role' => 'form'
    ),
    'focus' => array($model, 'lang_attribute'),
        ));

if (!$model->isNewRecord) {
    $flag = true;
} else {
    $flag = false;
}

//print_r($model);
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">        
        <div class="row">
            <div class="col-md-6">
                <!--                <div class="form-group">
                                    <label class="required">Language <span class="required">*</span></label>
                <?php //echo CHtml::activeDropDownList($model, 'lang_shortcode', CHtml::listData(Languages::model()->findAll(), 'lang_code', 'lang_name'), array('style' => 'font-style:italic', 'class' => 'form-control', 'empty' => 'Please Select Language')) ?>
                <?php //echo $form->error($model, 'lang_shortcode', array('class' => 'text-red')); ?>
                                </div> -->                

                <input type="hidden" name="id" id="id" value="<?php echo $model->lang_id ?>"/>                

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'lang_attribute'); ?>
                    <?php echo $form->textField($model, 'lang_attribute', array('maxlength' => 100, 'class' => 'form-control', 'readonly' => $flag, 'placeholder' => 'Language Attribute')); ?>
                    <?php echo $form->error($model, 'lang_attribute', array('class' => 'text-red')); ?>
                </div> 
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'en_t'); ?>
                    <?php echo $form->textField($model, 'en_t', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => 'English Translation')); ?>
                    <?php echo $form->error($model, 'en_t', array('class' => 'text-red')); ?>
                </div> 
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sv_t'); ?>
                    <?php echo $form->textField($model, 'sv_t', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => 'Swedish Translation')); ?>
                    <?php echo $form->error($model, 'sv_t', array('class' => 'text-red')); ?>
                </div> 
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton('Add Language', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton('Reset', array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton('Update Language', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>