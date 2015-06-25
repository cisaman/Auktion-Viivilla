<?php
$create_url = Yii::app()->createAbsoluteUrl('pages/create');
$update_url = Yii::app()->createAbsoluteUrl('pages/update/' . $model->page_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'pages-form',
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
    'focus' => array($model, 'page_name'),
        ));
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'page_name'); ?>
                    <?php echo $form->textField($model, 'page_name', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('page_name'))); ?>
                    <?php echo $form->error($model, 'page_name', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'page_content'); ?>
                    <?php echo $form->textArea($model, 'page_content', array('maxlength' => 500, 'rows' => 16, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('page_content'))); ?>
                    <?php echo $form->error($model, 'page_content', array('class' => 'text-red')); ?>
                    <input type="hidden" name="description" id="description"/>
                </div>
                <?php if (!$model->isNewRecord) { ?>                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'page_status'); ?>
                        <?php echo $form->checkBox($model, 'page_status', array('class' => 'checkbox-inline')); ?>
                        <?php echo $form->error($model, 'page_status', array('class' => 'text-red')); ?>
                    </div>                    
                <?php } ?>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton(Yii::t('lang', 'add') . ' ' . Yii::t('lang', 'page'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton(Yii::t('lang', 'reset'), array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton(Yii::t('lang', 'update') . ' ' . Yii::t('lang', 'page'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>


<link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/summernote/summernote.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
<script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/summernote/summernote.min.js"></script>
<script>
    $(document).ready(function () {
        $('#Pages_page_content').summernote({
            name: 'Pages_page_content',
            height: 300
        });

        $('.note-editable').blur(function () {
            checkDescription();
        });

        $('.note-editable').keypress(function () {
            checkDescription();
        });

        function checkDescription() {
            var length = $('.note-editable').html().length;
            if (length == 0) {
                $('#Pages_page_content_em_').css('display', 'block');
                $('#Pages_page_content_em_').html('Please enter description.');
            } else {
                $('#Pages_page_content_em_').css('display', 'none');
                $('#Pages_page_content_em_').html('');
                $('#description').val($('.note-editable').html());
            }
        }
    });
</script>