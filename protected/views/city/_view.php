<?php
/* @var $this CityController */
/* @var $data City */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->city_id), array('view', 'id'=>$data->city_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_name')); ?>:</b>
	<?php echo CHtml::encode($data->city_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_stateID')); ?>:</b>
	<?php echo CHtml::encode($data->city_stateID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_created')); ?>:</b>
	<?php echo CHtml::encode($data->city_created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_updated')); ?>:</b>
	<?php echo CHtml::encode($data->city_updated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_status')); ?>:</b>
	<?php echo CHtml::encode($data->city_status); ?>
	<br />


</div>