<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_name'); ?>
		<?php echo $form->textField($model,'product_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_description'); ?>
		<?php echo $form->textField($model,'product_description',array('size'=>60,'maxlength'=>1000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_categoryID'); ?>
		<?php echo $form->textField($model,'product_categoryID',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_reserve_price'); ?>
		<?php echo $form->textField($model,'product_reserve_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_current_price'); ?>
		<?php echo $form->textField($model,'product_current_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_shipping_price'); ?>
		<?php echo $form->textField($model,'product_shipping_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_bid_diff_price'); ?>
		<?php echo $form->textField($model,'product_bid_diff_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_winners'); ?>
		<?php echo $form->textField($model,'product_winners'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_expiry_date'); ?>
		<?php echo $form->textField($model,'product_expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_attachments'); ?>
		<?php echo $form->textField($model,'product_attachments',array('size'=>60,'maxlength'=>1000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_created'); ?>
		<?php echo $form->textField($model,'product_created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_updated'); ?>
		<?php echo $form->textField($model,'product_updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_status'); ?>
		<?php echo $form->textField($model,'product_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->