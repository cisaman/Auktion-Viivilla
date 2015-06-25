<?php
/* @var $this CityController */
/* @var $model City */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'city_id'); ?>
		<?php echo $form->textField($model,'city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'city_name'); ?>
		<?php echo $form->textField($model,'city_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'city_stateID'); ?>
		<?php echo $form->textField($model,'city_stateID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'city_created'); ?>
		<?php echo $form->textField($model,'city_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'city_updated'); ?>
		<?php echo $form->textField($model,'city_updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'city_status'); ?>
		<?php echo $form->textField($model,'city_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->