<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'my_profile');

$id = Yii::app()->session['admin_data']['admin_id'];
$profile = User::model()->getProfile($id);
$firstname = $profile['user_firstname'];
$lastname = $profile['user_lastname'];
$name = $firstname . ' ' . $lastname;
$gender = $profile['user_gender'];
$photo = $profile['user_image'];
$role = Yii::app()->user->name;

if (!empty($photo)) {
    $photo = Utils::UserThumbnailImagePath() . $photo;
} else {
    $photo = ($gender == 'M') ? Utils::UserImagePath_M() : Utils::UserImagePath_F();
}
?>

<!-- begin PAGE TITLE AREA -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title">            
            <ol class="breadcrumb">
                <li><h1><i class="fa fa-user"></i> <?php echo Yii::t('lang', 'my_profile'); ?></h1></li>
            </ol>
        </div>
    </div>    
</div>
<!-- end PAGE TITLE AREA -->

<div class="row">
    <div class="col-lg-12">

        <div class="portlet portlet-default">
            <div class="portlet-body">

                <div id="statusMsg"></div>

                <?php if (Yii::app()->user->hasFlash('message')): ?>
                    <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?> alert-dismissable" id="successmsg">
                        <?php echo Yii::app()->user->getFlash('message'); ?>
                    </div>
                <?php endif; ?>

                <ul id="userTab" class="nav nav-tabs">
                    <li class="active"><a href="#overview" data-toggle="tab"><?php echo Yii::t('lang', 'overview'); ?></a>
                    </li>
                    <li class=""><a href="#profile-settings" data-toggle="tab"><?php echo Yii::t('lang', 'update'); ?> <?php echo Yii::t('lang', 'profile'); ?></a>
                    </li>
                </ul>
                <div id="userTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="overview">

                        <div class="row">
                            <div class="col-lg-3 col-md-3">                                
                                <img class="img-responsive img-profile" src="<?php echo $photo; ?>" alt="" style="height: 300px;width: 250px;"/>
                            </div>
                            <div class="col-lg-6 col-md-5">
                                <h1><?php echo $name; ?> <small><em><?php echo $role; ?></em></small></h1>                                
                            </div>                            
                        </div>

                    </div>
                    <div class="tab-pane fade" id="profile-settings">

                        <div class="row">
                            <div class="col-sm-3">
                                <ul id="userSettings" class="nav nav-pills nav-stacked">
                                    <li class="active"><a href="#basicInformation" data-toggle="tab"><i class="fa fa-user fa-fw"></i> <?php echo Yii::t('lang', 'basic_information'); ?></a></li>
                                    <li class=""><a href="#profilePicture" data-toggle="tab"><i class="fa fa-picture-o fa-fw"></i> <?php echo Yii::t('lang', 'profile_photo'); ?></a></li>
                                    <li class=""><a href="#changePassword" data-toggle="tab"><i class="fa fa-lock fa-fw"></i> <?php echo Yii::t('lang', 'change_password'); ?></a></li>
                                </ul>
                            </div>
                            <div class="col-sm-9">
                                <div id="userSettingsContent" class="tab-content">
                                    <div class="tab-pane fade active in" id="basicInformation">

                                        <?php
                                        $form = $this->beginWidget('CActiveForm', array(
                                            'id' => 'personalinformation-form',
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

                                        <h3><?php echo Yii::t('lang', 'personal_information'); ?>:</h3>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo $form->labelEx($model, 'user_firstname'); ?>
                                                    <?php echo $form->textField($model, 'user_firstname', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('user_firstname'))); ?>
                                                    <?php echo $form->error($model, 'user_firstname', array('class' => 'text-red')); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo $form->labelEx($model, 'user_lastname'); ?>
                                                    <?php echo $form->textField($model, 'user_lastname', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('user_lastname'))); ?>
                                                    <?php echo $form->error($model, 'user_lastname', array('class' => 'text-red')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo $form->labelEx($model, 'user_gender'); ?>
                                                    <?php echo $form->dropDownList($model, 'user_gender', $model->getGenderOptions(), array('class' => 'form-control', 'empty' => Yii::t('lang', 'please_select') . ' ' . $model->getAttributeLabel('user_gender'))); ?>
                                                    <?php echo $form->error($model, 'user_gender', array('class' => 'text-red')); ?>
                                                </div>                                        
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo $form->labelEx($model, 'user_email'); ?>
                                                    <?php echo $form->textField($model, 'user_email', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => $model->getAttributeLabel('user_email'), 'readonly' => 'TRUE')); ?>
                                                    <?php echo $form->error($model, 'user_email', array('class' => 'text-red')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <h3><?php echo Yii::t('lang', 'location_information'); ?>:</h3>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <?php echo $form->labelEx($model, 'user_address'); ?>
                                                    <?php echo $form->textField($model, 'user_address', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Address')); ?>
                                                    <?php echo $form->error($model, 'user_address', array('class' => 'text-red')); ?>
                                                </div>        
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo $form->labelEx($model, 'user_city'); ?>
                                                    <?php echo $form->textField($model, 'user_city', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'City')); ?>
                                                    <?php echo $form->error($model, 'user_city', array('class' => 'text-red')); ?>
                                                </div>        
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo $form->labelEx($model, 'user_country'); ?>
                                                    <?php echo $form->textField($model, 'user_country', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Country')); ?>
                                                    <?php echo $form->error($model, 'user_country', array('class' => 'text-red')); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo $form->labelEx($model, 'user_zip'); ?>
                                                    <?php echo $form->textField($model, 'user_zip', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Zip Code')); ?>
                                                    <?php echo $form->error($model, 'user_zip', array('class' => 'text-red')); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <?php echo $form->labelEx($model, 'user_contact'); ?>
                                                    <?php echo $form->textField($model, 'user_contact', array('maxlength' => 50, 'class' => 'form-control', 'placeholder' => 'Contact Number')); ?>
                                                    <?php echo $form->error($model, 'user_contact', array('class' => 'text-red')); ?>
                                                </div>
                                            </div>
                                        </div>

                                        <?php echo CHtml::submitButton(Yii::t('lang', 'update') . ' ' . Yii::t('lang', 'profile'), array('class' => 'btn btn-green btn-square', 'id' => 'btnSaveProfile', 'name' => 'btnSaveProfile')); ?>
                                        <button class="btn btn-square btn-orange"><?php echo Yii::t('lang', 'reset'); ?></button>

                                        <?php $this->endWidget(); ?>                                        
                                    </div>
                                    <div class="tab-pane fade" id="profilePicture">

                                        <?php $this->renderPartial('_profilepicture', array('model' => $model)); ?>

                                    </div>

                                    <div class="tab-pane fade" id="changePassword">                                        

                                        <?php $this->renderPartial('_changepassword', array('model' => $model)); ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.portlet-body -->
        </div>
        <!-- /.portlet -->


    </div>
    <!-- /.col-lg-12 -->
</div>

<script type="text/javascript">

    $(function () {

        /*********************************************************/
        /*   User Image Block Start   */
        /*********************************************************/
        $('#User_user_image').on('change', function () {
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
                    $("#imagePreview").attr("src", '<?php echo!empty($model->user_image) ? Utils::UserImagePath() . $model->user_image : ($model->user_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
                    setTimeout(function () {
                        $('#statusMsg').removeClass('alert alert-danger').html('');
                    }, 3000);
                }
            } else {
                $('#statusMsg').addClass('alert alert-danger').html('Please upload a valid Image File.');
                $(this).val('');
                $("#imagePreview").attr("src", '<?php echo!empty($model->user_image) ? Utils::UserImagePath() . $model->user_image : ($model->user_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
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
            var img_data = '<?php echo $model->user_image; ?>';
            if (img_data) {
                $.post(
                        '<?php echo Yii::app()->request->baseUrl; ?>/user/removeImage',
                        {'id': '<?php echo $model->user_id; ?>'},
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
                $("#imagePreview").attr("src", '<?php echo ($model->user_gender == "M" ? Utils::UserImagePath_M() : Utils::UserImagePath_F()) ?>');
                $('#User_user_image').val('');
                $("#span_close").html("");
            }
        });
        $("#span_close").on("click", function () {
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
        width: 250px;
        /*        height: 350px;*/
        /*        margin: 0 auto;*/
        /*        text-align: center;*/
    }
</style>

<script type="text/javascript">

    $(document).ready(function () {

        $('#old_password').blur(function () {
            if ($(this).val() == '') {
                $('#old_password_err').html('Please enter Old Password.');
            } else {
                $('#old_password_err').html('');
            }
        });

        $('#new_password').blur(function () {
            if ($(this).val() == '') {
                $('#new_password_err').html('Please enter New Password.');
                $(this).focus();
            } else {
                if ($(this).val().length < 6) {
                    $('#new_password_err').html('Password length should be between 6 to 16 charatcers.');
                    $(this).val('');
                    $(this).focus();
                } else {
                    $('#new_password_err').html('');
                }
            }
        });
        $('#new_password_again').blur(function () {
            if ($('#new_password').val() == '') {
                $('#new_password_err').html('Please enter New Password, then Re-type New Password.');
                $(this).val('');
                $('#new_password').focus();
            } else {
                if ($(this).val() == '') {
                    $('#new_password_again_err').html('Please Re-type New Password.');
                } else {
                    var new1 = $('#new_password').val();
                    var new2 = $(this).val();
                    if (new1 !== new2) {
                        $('#new_password_again_err').html('Both Passwords didn\'t match.');
                        $('#new_password').val('');
                        $(this).val('');
                        $('#new_password').focus();
                    } else {
                        $('#new_password_again_err').html('');
                    }
                }
            }
        });


        function testOldPassword() {
            var otpt = false;
            var value = $('#old_password').val();

            if (value != '') {
                $.ajax({
                    url: '<?php echo Yii::app()->request->baseUrl; ?>/users/checkPassword',
                    type: 'post',
                    data: {value: value},
                    async: false,
                    success: function (data) {
                        if (data == 1) {
                            $('#old_password_error').removeClass('text-red');
                            $('#old_password_error').addClass('text-green');
                            $('#old_password_error').html('Old Password is correct.');
                            otpt = true;
                        } else {
                            $('#old_password_error').addClass('text-red');
                            $('#old_password_error').removeClass('text-green');
                            $('#old_password_error').html('Old Password is incorrect.');
                            otpt = false;
                            //return data;
                        }
                    }
                });
            } else {
                $('#old_password_error').addClass('text-red');
                $('#old_password_error').removeClass('text-green');
                $('#old_password_error').html('');
            }
            return  otpt;
        }


        $('#old_password').click(function () {
            testOldPassword();
        });

        $('#password-form').submit(function () {

            var flag = 0;
            if ($('#old_password').val() == '') {
                $('#old_password_error').html('Please enter Old Password');
                flag++;
            } else {
                $('#old_password_error').html('');
            }
            if ($('#new_password').val() == '') {
                $('#new_password_error').html('Please enter New Password');
                flag++;
            } else if ($('#new_password').val().length < 6) {
                $('#new_password_error').html('New Password is too short.<br/> New Password should be minimum 6 characters long.');
                flag++;
            } else {
                $('#new_password_error').html('');
            }

            if (flag > 0) {
                return false;
            }
        });

        $('input[name=btnPassword]').click(function () {
            //return testOldPassword();
        });


    });

</script>