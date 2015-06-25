<?php
$create_url = Yii::app()->createAbsoluteUrl('state/create');
$update_url = Yii::app()->createAbsoluteUrl('state/update/' . $model->state_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'state-form',
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
    'focus' => array($model, 'state_name'),
        ));
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'state_countryID'); ?>
                    <?php
                    $country = CHtml::listData(Country::model()->findAll(), 'country_id', 'country_name');
                    echo $form->dropDownlist($model, 'state_countryID', $country, array('class' => 'form-control', 'empty' => 'Please Select Country'));
                    ?>
                    <?php echo $form->error($model, 'state_countryID', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'state_name'); ?>
                    <?php echo $form->textField($model, 'state_name', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'State Name')); ?>
                    <?php echo $form->error($model, 'state_name', array('class' => 'text-red')); ?>
                </div>
                <?php if (!$model->isNewRecord) { ?>                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'state_status'); ?>
                        <?php echo $form->checkBox($model, 'state_status', array('class' => 'checkbox-inline')); ?>
                        <?php echo $form->error($model, 'state_status', array('class' => 'text-red')); ?>
                    </div>                    
                <?php } ?>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton('Add State', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton('Reset', array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton('Update State', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>