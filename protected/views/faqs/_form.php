<?php
$create_url = Yii::app()->createAbsoluteUrl('faqs/create');
$update_url = Yii::app()->createAbsoluteUrl('faqs/update/' . $model->faqs_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'faqs-form',
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
    'focus' => array($model, 'faqs_ques'),
        ));
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'faqs_ques'); ?>
                    <?php echo $form->textArea($model, 'faqs_ques', array('maxlength' => 400, 'rows' => 4, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('faqs_ques'))); ?>
                    <?php echo $form->error($model, 'faqs_ques', array('class' => 'text-red')); ?>
                </div>                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'faqs_ans'); ?>
                    <?php echo $form->textArea($model, 'faqs_ans', array('rows' => 16, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('faqs_ans'))); ?>
                    <?php echo $form->error($model, 'faqs_ans', array('class' => 'text-red')); ?>
                    <input type="hidden" name="description" id="description"/>
                </div>
                <?php if (!$model->isNewRecord) { ?>                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'faqs_status'); ?>
                        <?php echo $form->checkBox($model, 'faqs_status', array('class' => 'checkbox-inline')); ?>
                        <?php echo $form->error($model, 'faqs_status', array('class' => 'text-red')); ?>
                    </div>                    
                <?php } ?>
            </div>            
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton(Yii::t('lang', 'add') . ' ' . Yii::t('lang', 'faqs'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton(Yii::t('lang', 'reset'), array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton(Yii::t('lang', 'update') . ' ' . Yii::t('lang', 'faqs'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
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
    $(document).ready(function() {
        $('#Faqs_faqs_ans').summernote({
            name: 'Faqs_faqs_ans',
            height: 300
        });

        $('.note-editable').blur(function() {
            checkDescription();
        });

        $('.note-editable').keypress(function() {
            checkDescription();
        });

        function checkDescription() {
            var length = $('.note-editable').html().length;
            if (length == 0) {
                $('#Faqs_faqs_ans_em_').css('display', 'block');
                $('#Faqs_faqs_ans_em_').html('Please enter Answer.');
            } else {
                $('#Faqs_faqs_ans_em_').css('display', 'none');
                $('#Faqs_faqs_ans_em_').html('');
                $('#description').val($('.note-editable').html());
            }
        }
    });
</script>