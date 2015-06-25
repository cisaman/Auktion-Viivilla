<?php
$update_url = Yii::app()->createAbsoluteUrl('buyers/update/' . $model->buyers_id);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'buyers-form',
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
    'focus' => array($model, 'buyers_fname'),
        ));
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_fname'); ?>
                    <?php echo $form->textField($model, 'buyers_fname', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_fname'))); ?>
                    <?php echo $form->error($model, 'buyers_fname', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_lname'); ?>
                    <?php echo $form->textField($model, 'buyers_lname', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_lname'))); ?>
                    <?php echo $form->error($model, 'buyers_lname', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_gender'); ?>
                    <?php echo $form->dropDownList($model, 'buyers_gender', $model->getGenderOptions(), array('class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . $model->getAttributeLabel('buyers_gender'))); ?>
                    <?php echo $form->error($model, 'buyers_gender', array('class' => 'text-red')); ?>
                </div>                
            </div>
            <div class="col-md-6">
                <div class="form-group text-center">                    
                    <?php
                    $flag = 1;
                    $path = ($model->buyers_gender == "") ? Utils::UserImagePath_M() : ($model->buyers_gender == 'F') ? Utils::UserImagePath_F() : Utils::UserImagePath_M();
                    if (!empty($model->buyers_image)) {
                        $path = Utils::UserImagePath() . $model->buyers_image;
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
            </div>
        </div> 
        <div class="row">            
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_nickname'); ?>
                    <?php echo $form->textField($model, 'buyers_nickname', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_nickname'))); ?>
                    <?php echo $form->error($model, 'buyers_nickname', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_email'); ?>
                    <?php echo $form->textField($model, 'buyers_email', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_email'))); ?>
                    <?php echo $form->error($model, 'buyers_email', array('class' => 'text-red')); ?>
                </div>
            </div>            
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_image'); ?> 
                    <?php echo $form->fileField($model, 'buyers_image', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'buyers_image', array('class' => 'text-red')); ?>
                    <p class="help-block text-green"><?php echo Yii::t('lang', 'msg_images'); ?></p>
                </div>
            </div>


        </div>        

        <div class="row">
            <div class="col-md-12">
                <h3>Location Information:</h3>
                <hr/>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php $model->buyers_location = $model->buyers_city; ?>
                    <?php echo $form->labelEx($model, 'buyers_location'); ?>
                    <?php echo $form->textField($model, 'buyers_location', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_location'))); ?>
                    <?php echo $form->error($model, 'buyers_location', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_zipcode'); ?>
                    <?php echo $form->textField($model, 'buyers_zipcode', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_zipcode'))); ?>
                    <?php echo $form->error($model, 'buyers_zipcode', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_contactno'); ?> 
                    <?php echo $form->textField($model, 'buyers_contactno', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_contactno'))); ?>
                    <?php echo $form->error($model, 'buyers_contactno', array('class' => 'text-red')); ?>                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_address'); ?>
                    <?php echo $form->textArea($model, 'buyers_address', array('maxlength' => 200, 'rows' => 4, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_address'))); ?>
                    <?php echo $form->error($model, 'buyers_address', array('class' => 'text-red')); ?>
                </div>
            </div>
        </div> 

        <div class="row">
            <div class="col-md-12">
                <h3>Other Information:</h3>
                <hr/>
            </div>
            <div class="col-md-6">                
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_facebook'); ?>
                    <?php echo $form->textField($model, 'buyers_facebook', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_facebook'))); ?>
                    <?php echo $form->error($model, 'buyers_facebook', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_twitter'); ?>
                    <?php echo $form->textField($model, 'buyers_twitter', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_twitter'))); ?>
                    <?php echo $form->error($model, 'buyers_twitter', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_linkedin'); ?>
                    <?php echo $form->textField($model, 'buyers_linkedin', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_linkedin'))); ?>
                    <?php echo $form->error($model, 'buyers_linkedin', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_skype'); ?>
                    <?php echo $form->textField($model, 'buyers_skype', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_skype'))); ?>
                    <?php echo $form->error($model, 'buyers_skype', array('class' => 'text-red')); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_website'); ?>
                    <?php echo $form->textField($model, 'buyers_website', array('maxlength' => 100, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_website'))); ?>
                    <?php echo $form->error($model, 'buyers_website', array('class' => 'text-red')); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'buyers_summary'); ?>
                    <?php echo $form->textArea($model, 'buyers_summary', array('maxlength' => 500, 'rows' => 4, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('buyers_summary'))); ?>
                    <?php echo $form->error($model, 'buyers_summary', array('class' => 'text-red')); ?>
                </div>
            </div>
        </div>


        <div class="row">            
            <div class="col-md-12">
                <?php if (!$model->isNewRecord) { ?>                    
                    <div class="form-group">
                        <?php echo $form->labelEx($model, 'buyers_status'); ?>
                        <?php echo $form->checkBox($model, 'buyers_status', array('class' => 'checkbox-inline')); ?>
                        <?php echo $form->error($model, 'buyers_status', array('class' => 'text-red')); ?>
                    </div>                    
                <?php } ?>
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::submitButton(Yii::t('lang', 'add') . ' ' . Yii::t('lang', 'buyer'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                    echo '&nbsp;&nbsp;';
                    echo CHtml::resetButton(Yii::t('lang', 'reset'), array('class' => 'btn btn-orange btn-square', 'id' => 'btnReset'));
                } else {
                    echo CHtml::submitButton(Yii::t('lang', 'update') . ' ' . Yii::t('lang', 'buyer'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSave'));
                }
                ?>
            </div>
        </div>

    </div>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

    $(function() {

        /*********************************************************/
        /*   User Image Block Start   */
        /*********************************************************/
        $('#Buyers_buyers_image').on('change', function() {
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
                        $("#imagePreview").attr("src", '<?php echo!empty($model->buyers_image) ? Utils::UserImagePath() . $model->buyers_image : ($model->buyers_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
                        setTimeout(function() {
                            $('#statusMsg').removeClass('alert alert-danger').html('');
                        }, 3000);
                    } else {
                        var reader = new FileReader();
                        reader.readAsDataURL(files[0]);
                        reader.onloadend = function(event) {
                            $("#imagePreview").attr("src", event.target.result);
                            $("#span_close").html('<span id="close" style="display:none" title="Click here to delete this image"><i class="fa fa-times fa-2x"></i></span>');
                        }
                    }
                } else {
                    $('#statusMsg').addClass('alert alert-danger').html('Please upload a valid Image File.');
                    $(this).val('');
                    $("#imagePreview").attr("src", '<?php echo!empty($model->buyers_image) ? Utils::UserImagePath() . $model->buyers_image : ($model->buyers_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
                    setTimeout(function() {
                        $('#statusMsg').removeClass('alert alert-danger').html('');
                    }, 3000);
                }
            } else {
                $('#statusMsg').addClass('alert alert-danger').html('Please upload a valid Image File.');
                $(this).val('');
                $("#imagePreview").attr("src", '<?php echo!empty($model->buyers_image) ? Utils::UserImagePath() . $model->buyers_image : ($model->buyers_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
                setTimeout(function() {
                    $('#statusMsg').removeClass('alert alert-danger').html('');
                }, 3000);
            }
        });

        $("#imagePreview").mouseover(function() {
            $("#close").show();
        });
        $("#close").mouseover(function() {
            $("#close").show();
        });
        $("#span_close").mouseover(function() {
            $("#close").show();
        });
        $("#close").mouseout(function() {
            $("#close").hide();
        });
        $("#imagePreview").mouseout(function() {
            $("#close").hide();
        });

        $("#close").on("click", function() {
            var img_data = '<?php echo $model->buyers_image; ?>';
            if (img_data) {
                $.post(
                        '<?php echo Yii::app()->request->baseUrl; ?>/user/removeImage',
                        {'id': '<?php echo $model->buyers_id; ?>'},
                function(data) {
                    if (data == 1) {
                        $('#statusMsg').addClass('alert alert-success').html('Photo deleted successfully.');
                        setTimeout(function() {
                            $('#statusMsg').removeClass('alert alert-danger').html('');
                        }, 3000);
                        //window.location.reload();
                    } else {
                        $('#statusMsg').addClass('alert alert-danger').html('System Error.');
                        setTimeout(function() {
                            $('#statusMsg').removeClass('alert alert-danger').html('');
                        }, 3000);
                    }
                });
            } else {
                $("#imagePreview").attr("src", '<?php echo ($model->buyers_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
                $('#User_buyers_image').val('');
                $("#span_close").html("");
            }
        });

        $("#span_close").on("click", function() {
            $("#imagePreview").attr("src", '<?php echo ($model->buyers_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
            $('#User_buyers_image').val('');
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
        width: 180px;
        /*        height: 350px;*/
        margin: 0 auto;
        text-align: center;
    }
</style>