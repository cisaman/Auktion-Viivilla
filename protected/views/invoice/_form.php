<?php
$create_url = Yii::app()->createAbsoluteUrl('invoice/create');
$update_url = Yii::app()->createAbsoluteUrl('invoice/update/' . $model->invoice_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'invoice-form',
    'action' => ($model->isNewRecord) ? $create_url : $update_url,
    //'enableAjaxValidation' => TRUE,
    'enableClientValidation' => TRUE,
    'clientOptions' => array(
        'validateOnSubmit' => TRUE,
        'validateOnChange' => TRUE
    ),
    'htmlOptions' => array(
        'autocomplete' => 'off',
        'role' => 'form'
    ),
    'focus' => array($model, 'invoice_title'),
        ));

//$flag = ($model->isNewRecord) ? false : true;
?>

<script src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/ckeditor/ckeditor.js"></script>

<link href="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/dashboard/css/uploadfilemulti.css" rel="stylesheet">
<script src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/dashboard/js/jquery.fileuploadmulti.min.js"></script>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <div class="col-md-12">                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'invoice_title'); ?>
                    <?php echo $form->textField($model, 'invoice_title', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('invoice_title'))); ?>
                    <?php echo $form->error($model, 'invoice_title', array('class' => 'text-red')); ?>
                </div>             
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'invoice_parameters'); ?>
                    <?php echo $form->textArea($model, 'invoice_parameters', array('maxlength' => 500, 'rows' => 4, 'class' => 'form-control', 'readonly' => $flag, 'placeholder' => $model->getAttributeLabel('invoice_parameters'))); ?>
                    <?php echo $form->error($model, 'invoice_parameters', array('class' => 'text-red')); ?>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'invoice_content'); ?>
                    <form action="/bootstrap/ckeditor/samples/sample_posteddata.php" method="post">
                        <textarea cols="80" id="Invoice_invoice_content" name="Invoice[invoice_content]" rows="10" class="form-control"><?php echo $model->invoice_content; ?></textarea>
                        <script>
                            CKEDITOR.replace('Invoice_invoice_content', {
                                "filebrowserImageUploadUrl": "<?php echo Utils::GetBaseUrl() ?>/bootstrap/ckeditor/plugins/imgupload/imgupload.php"
                            });
                            CKEDITOR.config.contentsCss = 'http://auktion.viivilla.se/bootstrap/site/css/invoice.css';
                        </script>                    
                    </form>
                    <?php echo $form->error($model, 'invoice_content', array('class' => 'text-red')); ?>
                </div>

                <?php if (!$model->isNewRecord) { ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'invoice_status'); ?>
                        <?php echo $form->checkBox($model, 'invoice_status', array('class' => 'checkbox-inline')); ?>
                        <?php echo $form->error($model, 'invoice_status', array('class' => 'text-red')); ?>
                    </div>                    
                <?php } ?>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton(Yii::t('lang', 'add') . ' ' . Yii::t('lang', 'invoice'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton(Yii::t('lang', 'reset'), array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton(Yii::t('lang', 'update') . ' ' . Yii::t('lang', 'invoice'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>


<style type="text/css">
    .cke_contents{
        min-height: 800px !important;
    }
    .cke_editable{
        margin: 10px !important;
    }
</style>