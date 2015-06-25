<?php
$update_url = Yii::app()->createAbsoluteUrl('sellers/update/' . $model->sellers_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'sellers-form',
    'action' => ($model->isNewRecord) ? 'create' : $update_url,
    'enableAjaxValidation' => TRUE,
    'enableClientValidation' => TRUE,
    'clientOptions' => array(
        'validateOnSubmit' => TRUE,
        'validateOnChange' => TRUE
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'autocomplete' => 'off',
        'role' => 'form'
    ),
    'focus' => array($model, 'sellers_fname'),
        ));
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sellers_username'); ?>
                    <?php echo $form->textField($model, 'sellers_username', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('sellers_username'))); ?>
                    <?php echo $form->error($model, 'sellers_username', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sellers_vatno'); ?>
                    <?php echo $form->textField($model, 'sellers_vatno', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('sellers_vatno'))); ?>
                    <?php echo $form->error($model, 'sellers_vatno', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sellers_fname'); ?>
                    <?php echo $form->textField($model, 'sellers_fname', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('sellers_fname'))); ?>
                    <?php echo $form->error($model, 'sellers_fname', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sellers_lname'); ?>
                    <?php echo $form->textField($model, 'sellers_lname', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('sellers_lname'))); ?>
                    <?php echo $form->error($model, 'sellers_lname', array('class' => 'text-red')); ?>
                </div>                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sellers_email'); ?>
                    <?php echo $form->textField($model, 'sellers_email', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('sellers_email'))); ?>
                    <?php echo $form->error($model, 'sellers_email', array('class' => 'text-red')); ?>
                </div>
                <?php if ($model->isNewRecord) { ?>                
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'sellers_password'); ?>
                        <?php echo CHtml::textField('Sellers[sellers_password]', Utils::getRandomPassword(6), array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('sellers_password'), 'readonly' => 'true')); ?>
                        <?php echo $form->error($model, 'sellers_password', array('class' => 'text-red')); ?>
                    </div>                 
                <?php } ?> 
            </div>
            <div class="col-md-6">
                <div class="form-group text-center">                    
                    <?php
                    $flag = 1;
                    $path = Utils::NoImagePath();
                    if (!empty($model->sellers_image)) {
                        $path = Utils::UserImagePath() . $model->sellers_image;
                        $flag = 0;
                    }
                    ?>                                        
                    <div class="innerdiv">
                        <img id="imagePreview" style="height: 200px;width: 100%" src="<?php echo $path; ?>"/>
                        <span id="span_close">
                            <?php if ($flag == 0) { ?>
                                <span id="close" style="display:none" title="Click here to delete this image"><i class="fa fa-times fa-2x"></i></span>
                            <?php } ?>
                        </span>                                                
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sellers_image'); ?> 
                    <?php echo $form->fileField($model, 'sellers_image', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'sellers_image', array('class' => 'text-red')); ?>
                    <p class="help-block text-green"><?php echo Yii::t('lang', 'msg_images'); ?></p>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sellers_website'); ?>
                    <?php echo $form->textField($model, 'sellers_website', array('maxlength' => 150, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('sellers_website'))); ?>
                    <?php echo $form->error($model, 'sellers_website', array('class' => 'text-red')); ?>
                </div>
            </div>
        </div> 
        <div class="row">            
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sellers_city'); ?>
                    <?php echo $form->textField($model, 'sellers_city', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('sellers_city'))); ?>
                    <?php echo $form->error($model, 'sellers_city', array('class' => 'text-red')); ?>
                </div>            
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sellers_country'); ?> 
                    <?php echo $form->textField($model, 'sellers_country', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('sellers_country'))); ?>
                    <?php echo $form->error($model, 'sellers_country', array('class' => 'text-red')); ?>                    
                </div>            
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sellers_zipcode'); ?>
                    <?php echo $form->textField($model, 'sellers_zipcode', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('sellers_zipcode'))); ?>
                    <?php echo $form->error($model, 'sellers_zipcode', array('class' => 'text-red')); ?>
                </div>            
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sellers_contactno'); ?> 
                    <?php echo $form->textField($model, 'sellers_contactno', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('sellers_contactno'))); ?>
                    <?php echo $form->error($model, 'sellers_contactno', array('class' => 'text-red')); ?>                    
                </div>
            </div> 
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sellers_address'); ?>
                    <?php echo $form->textArea($model, 'sellers_address', array('maxlength' => 300, 'rows' => 8, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('sellers_address'))); ?>
                    <?php echo $form->error($model, 'sellers_address', array('class' => 'text-red')); ?>
                </div>
            </div>
        </div>        
        <div class="row">
            <?php if (!$model->isNewRecord) { ?>            
                <div class="col-md-6">
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'sellers_status'); ?>
                        <?php echo $form->checkBox($model, 'sellers_status', array('class' => 'checkbox-inline')); ?>
                        <?php echo $form->error($model, 'sellers_status', array('class' => 'text-red')); ?>
                    </div> 
                </div>
            <?php } ?>
            <div class="col-md-12">
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton(Yii::t('lang', 'add') . ' ' . Yii::t('lang', 'seller'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton(Yii::t('lang', 'reset'), array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton(Yii::t('lang', 'update') . ' ' . Yii::t('lang', 'seller'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

    $(function () {

        /*********************************************************/
        /*   User Image Block Start   */
        /*********************************************************/
        $('#Sellers_sellers_image').on('change', function () {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader)
                return;

            var ftype = $(this)[0].files[0].type;
            var types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
            if ($.inArray(ftype, types) > 0) {
                if (/^image/.test(files[0].type)) {
                    if ($(this)[0].files[0].size > 2097152) {
                        $('#statusMsg').addClass('alert alert-danger').html('The Image Size is too Big. Max size for the image is 2MB');
                        $(this).val('');
                        $("#imagePreview").attr("src", '<?php echo!empty($model->sellers_image) ? Utils::UserImagePath() . $model->sellers_image : Utils::NoImagePath(); ?>');
                        setTimeout(function () {
                            $('#statusMsg').removeClass('alert alert-danger').html('');
                        }, 3000);
                    } else {
                        var reader = new FileReader();
                        reader.readAsDataURL(files[0]);
                        reader.onloadend = function (event) {
                            $("#imagePreview").attr("src", event.target.result);
                            $("#span_close").html('<span id="close" style="display:none" title="Click here to delete this image"><i class="fa fa-times fa-2x"></i></span>');
                        }
                    }
                } else {
                    $('#statusMsg').addClass('alert alert-danger').html('Please upload a valid Image File.');
                    $(this).val('');
                    $("#imagePreview").attr("src", '<?php echo!empty($model->sellers_image) ? Utils::UserImagePath() . $model->sellers_image : Utils::NoImagePath() ?>');
                    setTimeout(function () {
                        $('#statusMsg').removeClass('alert alert-danger').html('');
                    }, 3000);
                }
            } else {
                $('#statusMsg').addClass('alert alert-danger').html('Please upload a valid Image File.');
                $(this).val('');
                $("#imagePreview").attr("src", '<?php echo!empty($model->sellers_image) ? Utils::UserImagePath() . $model->sellers_image : Utils::NoImagePath(); ?>');
                setTimeout(function () {
                    $('#statusMsg').removeClass('alert alert-danger').html('');
                }, 3000);
            }
        });

        $("#imagePreview").mouseover(function () {
            $("#close").show();
        });
        $("#close").mouseover(function () {
            $("#close").show();
        });
        $("#span_close").mouseover(function () {
            $("#close").show();
        });
        $("#close").mouseout(function () {
            $("#close").hide();
        });
        $("#imagePreview").mouseout(function () {
            $("#close").hide();
        });

        $("#close").on("click", function () {
            var img_data = '<?php echo $model->sellers_image; ?>';
            if (img_data) {
                $.post(
                        '<?php echo Yii::app()->request->baseUrl; ?>/sellers/removeImage',
                        {'id': '<?php echo $model->sellers_id; ?>'},
                function (data) {
                    if (data == 1) {
                        $('#statusMsg').addClass('alert alert-success').html('Photo deleted successfully.');
                        setTimeout(function () {
                            $('#statusMsg').removeClass('alert alert-danger').html('');
                        }, 3000);
                        //window.location.reload();
                    } else {
                        $('#statusMsg').addClass('alert alert-danger').html('System Error.');
                        setTimeout(function () {
                            $('#statusMsg').removeClass('alert alert-danger').html('');
                        }, 3000);
                    }
                });
            } else {
                $("#imagePreview").attr("src", '<?php echo Utils::NoImagePath() ?>');
                $('#User_sellers_image').val('');
                $("#span_close").html("");
            }
        });

        $("#span_close").on("click", function () {
            $("#imagePreview").attr("src", '<?php echo Utils::NoImagePath() ?>');
            $('#User_sellers_image').val('');
            $("#span_close").html("");
        });
        /*********************************************************/
        /*   User Image Block End   */
        /*********************************************************/
    });
</script>
<style>
    #close{
        right: 0;
        position: absolute;
        top: -2px;
        display: block;
        cursor: pointer;
        color: #d82551;
    }
    .innerdiv{
        position: relative;
        width: 280px;
        /*        height: 350px;*/
        margin: 0 auto;
        text-align: center;
        border: 1px solid #ccc;
        padding: 4px;
    }
</style>