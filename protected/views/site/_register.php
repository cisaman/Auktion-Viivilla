<?php if (!empty(Yii::app()->session['message']['msg'])): ?>
    <div class="alert alert-<?php echo Yii::app()->session['message']['type']; ?>" id="successmsg">
        <?php echo Yii::app()->session['message']['msg']; ?>
    </div>
<?php endif; ?>
<?php Yii::app()->session['message'] = array(); ?>

<div class="reg-in">   

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'buyers-register-form',
        'action' => array('site/register'),
        'enableAjaxValidation' => TRUE,
        'enableClientValidation' => TRUE,
        'clientOptions' => array(
            'validateOnSubmit' => TRUE,
            'validateOnChange' => TRUE,
            'validateOnType' => TRUE,
        ),
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
            'autocomplete' => 'off'
        ),
    ));
    ?>         

    <?php
//    $model->buyers_email = 'aman.r@cisinlabs.com';
//    $model->password_real = 'Aman123$';
//    $model->password_repeat = 'Aman123$';
//    $model->buyers_nickname = 'aman';
//    $model->buyers_fname = 'Aman';
//    $model->buyers_lname = 'Raikwar';
//    $model->buyers_address = 'Indore';
//    $model->buyers_zipcode = '452001';
//    $model->buyers_location = 'India';
//    $model->buyers_contactno = '9425388641';
//    $model->buyers_jobtitle = 'SD';
    ?>

    <div class="uppper-field">        
        <?php echo $form->textField($model, 'buyers_email', array('class' => 'fill-part', 'placeholder' => $model->getAttributeLabel('buyers_email'))); ?>
        <?php echo $form->error($model, 'buyers_email'); ?>

        <?php echo $form->passwordField($model, 'password_real', array('class' => 'fill-part', 'placeholder' => $model->getAttributeLabel('password_real'))); ?>
        <?php echo $form->error($model, 'password_real'); ?>

        <?php echo $form->passwordField($model, 'password_repeat', array('class' => 'fill-part', 'placeholder' => $model->getAttributeLabel('password_repeat'))); ?>
        <?php echo $form->error($model, 'password_repeat'); ?>

        <?php echo $form->textField($model, 'buyers_nickname', array('maxlength' => 14, 'class' => 'fill-part', 'placeholder' => $model->getAttributeLabel('buyers_nickname'))); ?>
        <?php echo $form->error($model, 'buyers_nickname'); ?>

        <?php echo $form->textField($model, 'buyers_fname', array('class' => 'fill-part', 'placeholder' => $model->getAttributeLabel('buyers_fname'))); ?>
        <?php echo $form->error($model, 'buyers_fname'); ?>

        <?php echo $form->textField($model, 'buyers_lname', array('class' => 'fill-part', 'placeholder' => $model->getAttributeLabel('buyers_lname'))); ?>
        <?php echo $form->error($model, 'buyers_lname'); ?>

        <?php echo $form->textArea($model, 'buyers_address', array('class' => 'fill-part', 'maxlength' => 150, 'style' => 'resize:none;', 'placeholder' => $model->getAttributeLabel('buyers_address'))); ?>
        <?php echo $form->error($model, 'buyers_address'); ?>                    

        <?php echo $form->textField($model, 'buyers_zipcode', array('class' => 'fill-part numeric', 'maxlength' => 8, 'placeholder' => $model->getAttributeLabel('buyers_zipcode'))); ?>
        <?php echo $form->error($model, 'buyers_zipcode'); ?> 

        <?php echo $form->textField($model, 'buyers_location', array('class' => 'fill-part', 'placeholder' => $model->getAttributeLabel('buyers_location'))); ?>
        <?php echo $form->error($model, 'buyers_location'); ?> 

        <?php echo $form->textField($model, 'buyers_contactno', array('class' => 'fill-part numeric', 'maxlength' => 15, 'placeholder' => $model->getAttributeLabel('buyers_contactno'))); ?>
        <?php echo $form->error($model, 'buyers_contactno'); ?> 

    </div>

    <a class="download" href="javascript:void(0);">
        <img alt="download" src="<?php echo Utils::GetBaseUrl(); ?>/bootstrap/site/images/down-icon.png" />
        <?php echo Yii::t('lang', 'put_more_info'); ?>
    </a>

    <div class="lower-field">
        <ul class="reg-fill">
            <li>
                <div class="reg-left">
                    <?php echo $form->labelEx($model, 'buyers_jobtitle'); ?>
                </div>
                <div class="reg-right">
                    <?php echo $form->textField($model, 'buyers_jobtitle', array('class' => 'fill-part', 'placeholder' => $model->getAttributeLabel('buyers_jobtitle'))); ?>
                    <?php echo $form->error($model, 'buyers_jobtitle'); ?> 
                </div>
            </li>            
            <li>
                <div class="reg-left">
                    <?php echo $form->labelEx($model, 'buyers_dob'); ?>
                </div>
                <div class="reg-right">
                    <?php echo $form->textField($model, 'buyers_dob', array('class' => 'fill-part', 'placeholder' => $model->getAttributeLabel('buyers_dob'), 'readonly' => TRUE)); ?>
                    <?php echo $form->error($model, 'buyers_dob'); ?>
                </div>
            </li>
            <li>
                <div class="reg-left">
                    <?php echo $form->labelEx($model, 'buyers_gender'); ?>
                </div>
                <div class="reg-right">
                    <?php echo $form->radioButtonList($model, 'buyers_gender', $model->getGenderOptions(), array('template' => '{input}{label}', 'separator' => '', 'class' => 'radio_in')); ?>
                    <?php echo $form->error($model, 'buyers_gender'); ?>
                </div>
            </li>
            <li>
                <div class="reg-left"></div>
                <div class="reg-right">
                    <?php
                    $flag = 1;
                    $path = Utils::GetBaseUrl() . '/bootstrap/site/images/no-img.png';
                    if (!empty($model->buyers_image)) {
                        $path = Utils::UserImagePath() . $model->buyers_image;
                        $flag = 0;
                    }
                    ?>                                        
                    <div class="innerdiv">
                        <img id="imagePreview" style="height: 150px;width: 100%" src="<?php echo $path; ?>" class="img-responsive img-profile"/>
                        <span id="span_close">
                            <?php if ($flag == 0) { ?>
                                <span id="close" style="display:none" title="Click here to delete this image"><i class="fa fa-times fa-2x"></i></span>
                            <?php } ?>
                        </span>                                                
                    </div>
                </div>
            </li>
            <li>
                <div class="reg-left"></div>
                <div class="reg-right">            
                    <div >
                        <?php echo $form->fileField($model, 'buyers_image', array('class' => 'reg-btn')); ?>
                        <button class="reg-btn" type="button"><?php echo Yii::t('lang', 'upload_photo'); ?></button>
                    </div>
                    <?php echo $form->error($model, 'buyers_image', array('class' => 'text-red')); ?>

                    <p class="help-block text-orange"><?php echo Yii::t('lang', 'msg_images'); ?></p>

                </div>
            </li>
        </ul>                        
    </div>
    <div class="check-form">
        <div class="check-one">
            <span class="check-fill">
                <?php echo $form->checkBox($model, 'buyers_newsletter', array('checked' => '', 'class' => 'checking')); ?>                
            </span>
            <span class="check-fill">
                <?php echo Yii::t('lang', 'subscribe_for_newsletter'); ?>
            </span>
            <?php echo $form->error($model, 'buyers_newsletter'); ?>
        </div>
        <div class="check-one">
            <span class="check-fill">
                <?php echo $form->checkBox($model, 'buyers_agree', array('checked' => '', 'class' => 'checking')); ?>                
            </span>
            <span class="check-fill">
                <?php echo Yii::t('lang', 'accept_policy'); ?>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('site/terms_conditions'); ?>" target="_new"> <?php echo Yii::t('lang', 'viivilla_policy'); ?></a>                 
            </span>
            <?php echo $form->error($model, 'buyers_agree'); ?>
        </div>

        <?php echo CHtml::submitButton(Yii::t('lang', 'register'), array('class' => 'log-in-box', 'id' => 'btnLogin')); ?>

    </div>

    <?php $this->endWidget(); ?>

</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('#Buyers_password_real').keypress(function() {
            $('#Buyers_password_repeat').val('');
        });

        $("#successmsg").animate({opacity: 1.0}, 5000).fadeOut("slow");

    });
</script>

<link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/bootstrap-datepicker/datepicker3.css" rel="stylesheet"/>
<script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
        var end = new Date();
        var setend = end.getFullYear() - 18;
        var enddate = setend + '-12-31';

        $('#Buyers_buyers_dob').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            endDate: enddate
        });
    });

</script>


<script type="text/javascript">

    $(function() {

        $('html, body').animate({
            scrollTop: $('.register-here').offset().top - 70
        }, 1500);

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
                        $("#imagePreview").attr("src", '<?php echo!empty($model->buyers_image) ? Utils::UserImagePath() . $model->buyers_image : $path; ?>');
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
                    $("#imagePreview").attr("src", '<?php echo!empty($model->buyers_image) ? Utils::UserImagePath() . $model->buyers_image : $path; ?>');
                    setTimeout(function() {
                        $('#statusMsg').removeClass('alert alert-danger').html('');
                    }, 3000);
                }
            } else {
                $('#statusMsg').addClass('alert alert-danger').html('Please upload a valid Image File.');
                $(this).val('');
                $("#imagePreview").attr("src", '<?php echo!empty($model->buyers_image) ? Utils::UserImagePath() . $model->buyers_image : $path ?>');
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
                $("#imagePreview").attr("src", '<?php echo $path ?>');
                $('#Buyers_buyers_image').val('');
                $("#span_close").html("");
            }
        });
        $("#span_close").on("click", function() {
            $("#imagePreview").attr("src", '<?php echo $path ?>');
            $('#Buyers_buyers_image').val('');
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
    }
    #Buyers_buyers_image{
        opacity: 0;position: absolute;width: 150px;
    }
    .reg-btn {
        width: 150px;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {

        /* * **************************************************************************** */
        /* * Trim Multiple Whitespaces into Single Space for all input Elements Start Block */
        /* * **************************************************************************** */
        function trimspace(element) {
            var cat = $('#' + element).val();
            cat = cat.replace(/ +(?= )/g, '');
            if (cat != " ") {
                $('#' + element).val(cat);
            } else {
                $('#' + element).val($.trim(cat));
            }
        }

        $('input[type="text"]').on('keyup', function() {
            trimspace(this.id);
        });

        $('textarea').on('keyup', function() {
            trimspace(this.id);
        });
        /* * **************************************************************************** */
        /* * Trim Multiple Whitespaces into Single Space for all input Elements End Block */
        /* * **************************************************************************** */

        $('.numeric').keydown(function(e) {
            // If you want decimal(.) please use 190 in inArray.
            // Allow: backspace, delete, tab, escape, enter.
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                    // Allow: Ctrl+A
                            (e.keyCode == 65 && e.ctrlKey === true) ||
                            // Allow: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

//        $('.dateofbirth').datepicker({
//            format: 'dd-mm-yyyy'
//        });

        $('.non-numeric').bind('keyup blur', function() {
            var node = $(this);
            node.val(node.val().replace(/[^a-zA-Z ]/g, ''));
        });
    });
</script>