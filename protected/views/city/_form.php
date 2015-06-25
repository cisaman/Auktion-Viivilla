<?php
$create_url = Yii::app()->createAbsoluteUrl('city/create');
$update_url = Yii::app()->createAbsoluteUrl('city/update/' . $model->city_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'city-form',
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
    'focus' => array($model, 'city_stateID'),
        ));
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">        
        <div class="row">
            <div class="col-md-6">                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'city_stateID'); ?>
                    <?php
                    $state = CHtml::listData(State::model()->findAll(), 'state_id', 'state_name');
                    echo $form->dropDownlist($model, 'city_stateID', $state, array('class' => 'form-control', 'empty' => 'Please Select State'));
                    ?>
                    <?php echo $form->error($model, 'city_stateID', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'city_name'); ?>
                    <?php echo $form->textField($model, 'city_name', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'City Name')); ?>
                    <?php echo $form->error($model, 'city_name', array('class' => 'text-red')); ?>
                </div>
                <?php if (!$model->isNewRecord) { ?>                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'city_status'); ?>
                        <?php echo $form->checkBox($model, 'city_status', array('class' => 'checkbox-inline')); ?>
                        <?php echo $form->error($model, 'city_status', array('class' => 'text-red')); ?>
                    </div>                    
                <?php } ?>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton('Add City', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton('Reset', array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton('Update City', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>