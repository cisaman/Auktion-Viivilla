<?php
$create_url = Yii::app()->createAbsoluteUrl('country/create');
$update_url = Yii::app()->createAbsoluteUrl('country/update/' . $model->country_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'country-form',
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
    'focus' => array($model, 'country_name'),
        ));
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'country_name'); ?>
                    <?php echo $form->textField($model, 'country_name', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Country Name')); ?>
                    <?php echo $form->error($model, 'country_name', array('class' => 'text-red')); ?>
                </div>
                <?php if (!$model->isNewRecord) { ?>                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'country_status'); ?>
                        <?php echo $form->checkBox($model, 'country_status', array('class' => 'checkbox-inline')); ?>
                        <?php echo $form->error($model, 'country_status', array('class' => 'text-red')); ?>
                    </div>                    
                <?php } ?>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton('Add Country', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton('Reset', array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton('Update Country', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>