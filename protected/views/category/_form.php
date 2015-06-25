<?php
$create_url = Yii::app()->createAbsoluteUrl('category/create');
$update_url = Yii::app()->createAbsoluteUrl('category/update/' . $model->category_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'category-form',
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
    'focus' => array($model, 'category_name'),
        ));
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'category_name'); ?>
                    <?php echo $form->textField($model, 'category_name', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('category_name'))); ?>
                    <?php echo $form->error($model, 'category_name', array('class' => 'text-red')); ?>
                </div>
                <?php if (!$model->isNewRecord) { ?>                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'category_status'); ?>
                        <?php echo $form->checkBox($model, 'category_status', array('class' => 'checkbox-inline')); ?>
                        <?php echo $form->error($model, 'category_status', array('class' => 'text-red')); ?>
                    </div>                    
                <?php } ?>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton(Yii::t('lang', 'add') . ' ' . Yii::t('lang', 'category'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton(Yii::t('lang', 'reset'), array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton(Yii::t('lang', 'update') . ' ' . Yii::t('lang', 'category'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>