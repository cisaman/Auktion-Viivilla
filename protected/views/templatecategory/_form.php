<?php
$create_url = Yii::app()->createAbsoluteUrl('templatecategory/create');
$update_url = Yii::app()->createAbsoluteUrl('templatecategory/update/' . $model->template_category_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'template-category-form',
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
    'focus' => array($model, 'template_category_title'),
        ));

$flag_1 = ($model->isNewRecord) ? 1 : 0;
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <div class="col-md-9">                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'template_category_title'); ?>
                    <?php echo $form->textField($model, 'template_category_title', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('template_category_title'))); ?>
                    <?php echo $form->error($model, 'template_category_title', array('class' => 'text-red')); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'template_category_table_name'); ?>
                    <div id="tableName"></div>
                    <?php echo $form->error($model, 'template_category_table_name', array('class' => 'text-red')); ?>
                </div>  

                <div class="form-group" style="display: none;" id="fieldNameBox">
                    <?php echo $form->labelEx($model, 'template_category_field_names'); ?>                    
                    <div id="fieldName"><?php echo CHtml::listBox('TemplateCategory[template_category_field_names]', '', array(), array('size' => '10', 'multiple' => 'TRUE', 'class' => 'form-control')) ?></div>
                    <?php echo $form->error($model, 'template_category_field_names', array('class' => 'text-red')); ?>
                </div>  

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton(Yii::t('lang', 'add') . ' ' . Yii::t('lang', 'templatecategory'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton(Yii::t('lang', 'reset'), array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton(Yii::t('lang', 'update') . ' ' . Yii::t('lang', 'templatecategory'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(function() {

        getAlltables();
        function getAlltables() {
            $.ajax({
                url: '<?php echo Utils::GetBaseUrl(); ?>/dashboard/getTables',
                type: 'POST',
                success: function(response) {
                    $('#tableName').html(response);
                }
            });
        }

        $('#TemplateCategory_template_category_table_name').live('change', function() {
            if ($(this).val() == '') {
                alert('Please select Table Name');
                $(this).focus();
                return false;
            } else {
                var tableName = $(this).val();
                getFieldNamesByTableName(tableName);
                $('#fieldNameBox').show();
            }
        });

        function getFieldNamesByTableName(tableName) {
            $.ajax({
                url: '<?php echo Utils::GetBaseUrl(); ?>/dashboard/getFieldNamesByTableName',
                data: {tableName: tableName},
                type: 'POST',
                success: function(response) {
                    $('#fieldName').html(response);
                }
            });
        }

    });
</script>