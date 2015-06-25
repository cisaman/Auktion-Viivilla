<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Error';
?>

<h1>Error <?php echo $code; ?></h1>

<div style="color: red;text-align: center;">
    <?php echo CHtml::encode($message); ?>                    
    <p><?php echo CHtml::button('Back to Home', array('onclick' => 'js:history.go(-1);returnFalse;')); ?></p>
</div>
