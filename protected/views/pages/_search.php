<?php
/* @var $this PagesController */
/* @var $model Pages */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'page_id'); ?>
		<?php echo $form->textField($model,'page_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'page_name'); ?>
		<?php echo $form->textField($model,'page_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'page_content'); ?>
		<?php echo $form->textArea($model,'page_content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'page_created'); ?>
		<?php echo $form->textField($model,'page_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'page_updated'); ?>
		<?php echo $form->textField($model,'page_updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'page_status'); ?>
		<?php echo $form->textField($model,'page_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->