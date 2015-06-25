<?php
$create_url = Yii::app()->createAbsoluteUrl('template/create');
$update_url = Yii::app()->createAbsoluteUrl('template/update/' . $model->template_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'template-form',
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
    'focus' => array($model, 'template_title'),
        ));

$flag = ($model->isNewRecord) ? false : true;
?>

<script src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/ckeditor/ckeditor.js"></script>

<link href="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/dashboard/css/uploadfilemulti.css" rel="stylesheet">
<script src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/dashboard/js/jquery.fileuploadmulti.min.js"></script>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <div class="col-md-8">                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'template_title'); ?>
                    <?php echo $form->textField($model, 'template_title', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('template_title'))); ?>
                    <?php echo $form->error($model, 'template_title', array('class' => 'text-red')); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'template_subject'); ?>
                    <?php echo $form->textArea($model, 'template_subject', array('maxlength' => 200, 'rows' => 2, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('template_subject'))); ?>
                    <?php echo $form->error($model, 'template_subject', array('class' => 'text-red')); ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'template_parameters'); ?>
                    <?php echo $form->textArea($model, 'template_parameters', array('maxlength' => 500, 'rows' => 6, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('template_parameters'))); ?>
                    <?php echo $form->error($model, 'template_parameters', array('class' => 'text-red')); ?>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'template_content'); ?>
                    <form action="/bootstrap/ckeditor/samples/sample_posteddata.php" method="post">                   
                        <textarea cols="80" id="Template_template_content" name="Template[template_content]" rows="10" class="form-control"><?php echo $model->template_content; ?></textarea>
                        <script>
                            CKEDITOR.replace('Template_template_content', {
                                "filebrowserImageUploadUrl": "<?php echo Utils::GetBaseUrl() ?>/bootstrap/ckeditor/plugins/imgupload/imgupload.php"
                            });
                        </script>                    
                    </form>
                    <?php echo $form->error($model, 'template_content', array('class' => 'text-red')); ?>
                </div>

                <?php if (!$model->isNewRecord) { ?>
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'template_status'); ?>
                        <?php echo $form->checkBox($model, 'template_status', array('class' => 'checkbox-inline')); ?>
                        <?php echo $form->error($model, 'template_status', array('class' => 'text-red')); ?>
                    </div>                    
                <?php } ?>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton(Yii::t('lang', 'add') . ' ' . Yii::t('lang', 'template'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton(Yii::t('lang', 'reset'), array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton(Yii::t('lang', 'update') . ' ' . Yii::t('lang', 'template'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>


<style type="text/css">
    .cke_contents{
        min-height: 400px !important;
    }
    .cke_editable{
        margin: 10px !important;
    }
</style>