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

<script src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/ckeditor/ckeditor.js"></script>

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
                    <?php //echo $form->textArea($model, 'page_content'); ?>           
                    <form action="sample_posteddata.php" method="post">                   
                        <textarea cols="80" id="Pages_page_content" name="Pages[page_content]" rows="20"><?php echo $model->page_content; ?></textarea>
                        <script>
                            CKEDITOR.replace('Pages_page_content', {
                                "filebrowserImageUploadUrl": "<?php echo Utils::GetBaseUrl() ?>/bootstrap/ckeditor/samples/plugins/imgupload.php"
                            });
                        </script>                    
                    </form>
                    <?php echo $form->error($model, 'page_content', array('class' => 'text-red')); ?>
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

<style type="text/css">
    .cke_contents{
        height: 400px !important;
    }
</style>