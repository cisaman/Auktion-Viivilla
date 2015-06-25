<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' | Profile';
?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-user"></i> Profile</h1></li>
            </ol>
        </div>
    </div>    
</div>
<!-- end PAGE TITLE AREA -->

<div class="row">    
    <div class="col-lg-12">
        <div class="portlet portlet-default">
            <div class="portlet-heading">
                <div class="portlet-title">
                    <h4>Update Profile</h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-collapse collapse in" id="basicFormExample">
                <div class="portlet-body">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'district-form',
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
                        'focus' => array($model, 'user_firstname'),
                    ));
                    ?>                    

                    <div id="statusMsg"></div>

                    <?php if (Yii::app()->user->hasFlash('message')): ?>
                        <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?> alert-dismissable" id="successmsg">
                            <?php echo Yii::app()->user->getFlash('message'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo $form->labelEx($model, 'user_firstname'); ?>
                                        <?php echo $form->textField($model, 'user_firstname', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'First Name')); ?>
                                        <?php echo $form->error($model, 'user_firstname', array('class' => 'text-red')); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $form->labelEx($model, 'user_lastname'); ?>
                                        <?php echo $form->textField($model, 'user_lastname', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Last Name')); ?>
                                        <?php echo $form->error($model, 'user_lastname', array('class' => 'text-red')); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $form->labelEx($model, 'user_email'); ?>
                                        <?php echo $form->textField($model, 'user_email', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'E-mail ID', 'readonly' => 'TRUE')); ?>
                                        <?php echo $form->error($model, 'user_email', array('class' => 'text-red')); ?>
                                    </div>                                                                                                            
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-center">
                                        <?php echo $form->labelEx($model, 'user_image'); ?>
                                        <?php
                                        $flag = 1;
                                        $path = ($model->user_gender == 'M') ? Utils::UserImagePath_M() : Utils::UserImagePath_F();
                                        if (!empty($model->user_image)) {
                                            $path = Utils::UserImagePath() . $model->user_image;
                                            $flag = 0;
                                        }
                                        ?>                                        
                                        <div class="innerdiv">
                                            <img id="imagePreview" style="height: 180px;width: 150px" src="<?php echo $path; ?>"/>
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
                                        <?php echo $form->labelEx($model, 'user_gender'); ?>
                                        <?php echo $form->dropDownList($model, 'user_gender', $model->getGenderOptions(), array('class' => 'form-control', 'empty' => 'Please Select Gender')); ?>
                                        <?php echo $form->error($model, 'user_gender', array('class' => 'text-red')); ?>
                                    </div>
                                </div>                                
                                <div class="col-md-6">
                                    <div class="form-group">  
                                        <?php echo $form->labelEx($model, 'user_image'); ?>
                                        <?php echo $form->fileField($model, 'user_image', array('class' => 'form-control')); ?>
                                        <?php echo $form->error($model, 'user_image', array('class' => 'text-red')); ?>
                                        <p class="help-block text-green">(Upload only jpg, jpeg, png & gif images upto 2MB.)</p>
                                    </div>  
                                </div>
                                <div class="col-md-12">
                                    <?php echo CHtml::submitButton('Update Profile', array('class' => 'btn btn-green btn-square', 'id' => 'btnSave')); ?>
                                </div>
                            </div>
                        </div>                        
                    </div>                    

                    <?php $this->endWidget(); ?>

                </div>
            </div>
        </div>
    </div>            
</div>

<script type="text/javascript">

    $(function() {

        /*********************************************************/
        /*   User Image Block Start   */
        /*********************************************************/
        $('#User_user_image').on('change', function() {
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
                        $("#imagePreview").attr("src", '<?php echo!empty($model->user_image) ? Utils::UserImagePath() . $model->user_image : ($model->user_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
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
                    $("#imagePreview").attr("src", '<?php echo!empty($model->user_image) ? Utils::UserImagePath() . $model->user_image : ($model->user_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
                    setTimeout(function() {
                        $('#statusMsg').removeClass('alert alert-danger').html('');
                    }, 3000);
                }
            } else {
                $('#statusMsg').addClass('alert alert-danger').html('Please upload a valid Image File.');
                $(this).val('');
                $("#imagePreview").attr("src", '<?php echo!empty($model->user_image) ? Utils::UserImagePath() . $model->user_image : ($model->user_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
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
            var img_data = '<?php echo $model->user_image; ?>';
            if (img_data) {
                $.post(
                        '<?php echo Yii::app()->request->baseUrl; ?>/user/removeImage',
                        {'id': '<?php echo $model->user_id; ?>'},
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
                $("#imagePreview").attr("src", '<?php echo ($model->user_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
                $('#User_user_image').val('');
                $("#span_close").html("");
            }
        });

        $("#span_close").on("click", function() {
            $("#imagePreview").attr("src", '<?php echo ($model->user_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
            $('#User_user_image').val('');
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
        width: 150px;
        margin: 0 auto;
        text-align: center;
    }
</style>