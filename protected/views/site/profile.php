<?php
$this->pageTitle = Yii::app()->name . ' | ' . Yii::t('lang', 'profile');

$this->breadcrumbs = array(
    Yii::t('lang', 'profile'),
);

//$val = TRUE;
//if (!empty($user->buyers_socialID)) {
//    $val = FALSE;
//}
?>

<div class="col-lg-12 col-md-12 col-sm-12 product-page login-main bidding-end">
    <div class="row">
        <div class="login-page-detail">
            <div class="login-header">                
                <h1><?php echo Yii::t('lang', 'member'); ?> <?php echo $user->buyers_fname . ' ' . $user->buyers_lname; ?></h1>
            </div>
            <div class="bidding-main">
                <div class="bidd-inner">
                    <div class="bottom-head">
                        <h2><?php echo Yii::t('lang', 'profile'); ?></h2>
                    </div>
                    <div class="bid-history">

                        <?php if (Yii::app()->user->hasFlash('message')): ?>
                            <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?>" id="successmsg">
                                <?php echo Yii::app()->user->getFlash('message'); ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'buyers-profile-form',
                            'action' => array('site/profile'),
                            //'enableAjaxValidation' => TRUE,
                            //'enableClientValidation' => TRUE,
                            'clientOptions' => array(
                            //'validateOnSubmit' => TRUE,
                            //'validateOnChange' => TRUE,
                            ),
                            'htmlOptions' => array(
                                'autocomplete' => 'off',
                                'role' => 'form'
                            ),
                        ));
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 my_account">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <?php echo $form->label($user, 'buyers_email', array('class' => 'control-label  cstm-label')); ?> <span class="required">*</span>
                                    <?php
                                    $val = FALSE;
                                    if (!empty($user->buyers_email)) {
                                        $val = TRUE;
                                    }
                                    ?>
                                    <?php echo $form->textField($user, 'buyers_email', array('class' => 'form-control', 'readonly' => $val, 'placeholder' => $user->getAttributeLabel('buyers_email'))); ?>
                                    <div class="required" id="Buyers_buyers_email_em_"></div>
                                </div>
                                <div class="form-group">                                    
                                    <?php echo $form->label($user, 'buyers_nickname', array('class' => 'control-label  cstm-label')); ?> <span class="required">*</span>
                                    <?php
                                    $val = FALSE;
                                    if (!empty($user->buyers_nickname)) {
                                        $val = TRUE;
                                    }
                                    ?>
                                    <?php echo $form->textField($user, 'buyers_nickname', array('maxlength' => 14, 'class' => 'form-control', 'readonly' => $val, 'placeholder' => $user->getAttributeLabel('buyers_nickname'))); ?>
                                    <div class="required" id="Buyers_buyers_nickname_em_"></div>
                                </div>
                                <div class="form-group">                                    
                                    <?php echo $form->label($user, 'buyers_fname', array('class' => 'control-label  cstm-label')); ?> <span class="required">*</span>
                                    <?php echo $form->textField($user, 'buyers_fname', array('class' => 'form-control', 'placeholder' => $user->getAttributeLabel('buyers_fname'))); ?>
                                    <?php echo $form->error($user, 'buyers_fname'); ?>
                                </div>
                                <div class="form-group">                                    
                                    <?php echo $form->label($user, 'buyers_lname', array('class' => 'control-label  cstm-label')); ?> <span class="required">*</span>
                                    <?php echo $form->textField($user, 'buyers_lname', array('class' => 'form-control', 'placeholder' => $user->getAttributeLabel('buyers_lname'))); ?>
                                    <?php echo $form->error($user, 'buyers_lname'); ?>                                    
                                </div>                                
                                <div class="form-group">                                    
                                    <?php echo $form->label($user, 'buyers_gender', array('class' => 'control-label  cstm-label')); ?>
                                    <?php echo $form->dropDownList($user, 'buyers_gender', $user->getGenderOptions(), array('empty' => Yii::t('lang', 'please_select') . ' ' . $user->getAttributeLabel('buyers_gender'), 'class' => 'form-control')); ?>
                                    <?php echo $form->error($user, 'buyers_gender'); ?>
                                </div>
                                <div class="form-group">                                    
                                    <?php echo $form->label($user, 'buyers_jobtitle', array('class' => 'control-label  cstm-label')); ?>
                                    <?php echo $form->textField($user, 'buyers_jobtitle', array('class' => 'form-control', 'placeholder' => $user->getAttributeLabel('buyers_jobtitle'))); ?>
                                    <?php echo $form->error($user, 'buyers_jobtitle'); ?>
                                </div>
                                <div class="form-group">                                    
                                    <?php echo $form->label($user, 'buyers_dob', array('class' => 'control-label  cstm-label')); ?>
                                    <?php echo $form->textField($user, 'buyers_dob', array('class' => 'form-control', 'placeholder' => $user->getAttributeLabel('buyers_dob'))); ?>
                                    <?php echo $form->error($user, 'buyers_dob'); ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">                                
                                <div class="form-group">                                    
                                    <?php echo $form->label($user, 'buyers_address', array('class' => 'control-label  cstm-label')); ?> <span class="required">*</span>
                                    <?php echo $form->textArea($user, 'buyers_address', array('class' => 'form-control', 'rows' => 4, 'maxlength' => 150, 'style' => 'resize:none;', 'placeholder' => $user->getAttributeLabel('buyers_address'))); ?>
                                    <div class="required" id="Buyers_buyers_address_em_"></div>
                                </div>
                                <div class="form-group">
                                    <?php $user->buyers_location = $user->buyers_city; ?>
                                    <?php echo $form->label($user, 'buyers_location', array('class' => 'control-label  cstm-label')); ?> <span class="required">*</span>
                                    <?php echo $form->textField($user, 'buyers_location', array('class' => 'form-control', 'placeholder' => $user->getAttributeLabel('buyers_location'))); ?>
                                    <div class="required" id="Buyers_buyers_location_em_"></div>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->label($user, 'buyers_zipcode', array('class' => 'control-label  cstm-label ')); ?> <span class="required">*</span>
                                    <?php echo $form->textField($user, 'buyers_zipcode', array('class' => 'form-control numeric', 'placeholder' => $user->getAttributeLabel('buyers_zipcode'))); ?>
                                    <div class="required" id="Buyers_buyers_zipcode_em_"></div>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->label($user, 'buyers_contactno', array('class' => 'control-label  cstm-label ')); ?> <span class="required">*</span>
                                    <?php echo $form->textField($user, 'buyers_contactno', array('class' => 'form-control numeric', 'placeholder' => $user->getAttributeLabel('buyers_contactno'))); ?>
                                    <div class="required" id="Buyers_buyers_contactno_em_"></div>
                                </div>            
                                <div class="form-group">                                    
                                    <?php echo $form->label($user, 'buyers_website', array('class' => 'control-label  cstm-label')); ?>
                                    <?php echo $form->textField($user, 'buyers_website', array('class' => 'form-control', 'placeholder' => 'http://www.demo.com')); ?>
                                    <?php echo $form->error($user, 'buyers_website'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 cmnt-area">
                            <div class="form-group">                                
                                <?php echo $form->label($user, 'buyers_summary', array('class' => 'control-label  cstm-label')); ?>
                                <?php echo $form->textArea($user, 'buyers_summary', array('class' => 'form-control cstm-area', 'style' => 'resize:none;', 'maxlength' => 500, 'placeholder' => $user->getAttributeLabel('buyers_summary'))); ?>
                                <?php echo $form->error($user, 'buyers_summary'); ?>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 bottom-section">                                
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <?php echo $form->label($user, 'buyers_facebook', array('class' => 'control-label  cstm-label')); ?>
                                    <?php echo $form->textField($user, 'buyers_facebook', array('class' => 'form-control', 'placeholder' => 'http://www.facebook.com')); ?>
                                    <?php echo $form->error($user, 'buyers_facebook'); ?>
                                </div>	
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <?php echo $form->label($user, 'buyers_twitter', array('class' => 'control-label  cstm-label')); ?>
                                    <?php echo $form->textField($user, 'buyers_twitter', array('class' => 'form-control', 'placeholder' => 'http://www.twitter.com')); ?>
                                    <?php echo $form->error($user, 'buyers_twitter'); ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <?php echo $form->label($user, 'buyers_linkedin', array('class' => 'control-label  cstm-label')); ?>
                                    <?php echo $form->textField($user, 'buyers_linkedin', array('class' => 'form-control', 'placeholder' => 'http://www.linkedin.com')); ?>
                                    <?php echo $form->error($user, 'buyers_linkedin'); ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <?php echo $form->label($user, 'buyers_skype', array('class' => 'control-label  cstm-label')); ?>
                                    <?php echo $form->textField($user, 'buyers_skype', array('class' => 'form-control', 'placeholder' => $user->getAttributeLabel('buyers_skype'))); ?>
                                    <?php echo $form->error($user, 'buyers_skype'); ?>
                                </div>
                            </div>
                        </div>                            
                        <div class="col-lg-12 col-md-12 col-sm-12 btm-last-section">
                            <div class="col-lg-6 col-md-6 col-sm-6 btm-block">
                                <?php echo CHtml::submitButton(Yii::t('lang', 'save_changes'), array('class' => 'save-btn', 'id' => 'btnSaveChanged')); ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 btm-block1">
                                <?php echo CHtml::link(Yii::t('lang', 'back'), Yii::app()->createAbsoluteUrl('site/myaccount'), array('class' => 'login-back', 'id' => 'btnBack')); ?>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .acct-log{
        margin-top: 10px !important;
    }
    #account:hover{
        cursor: pointer !important;
    }
    .bid-history{
        overflow: hidden;
    }
    .save-btn{
        margin-top: 0px !important;
    }
    .btm-block1 {
        padding: 10px 0 !important;
    }
    .required {
        color: red;
    }
</style>

<script type="text/javascript">
    $('#viewprofile').click(function (e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
        return false;
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {

        $('html, body').animate({
            scrollTop: $('.bidd-inner').offset().top - 70
        }, 1500);

        $("#successmsg").animate({opacity: 1.0}, 5000).fadeOut("slow");

    });
</script>

<link href="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/css/plugins/bootstrap-datepicker/datepicker3.css" rel="stylesheet"/>
<script src="<?php echo Yii::app()->request->baseUrl ?>/bootstrap/dashboard/js/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var end = new Date();
        var setend = end.getFullYear() - 18;
        var enddate = setend + '-12-31';

        $('#Buyers_buyers_dob').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            endDate: enddate
        });

        function checkEmail() {
            res = true;

            if ($('#Buyers_buyers_email').val() == '') {

                $('#Buyers_buyers_email_em_').html('<?php echo Yii::t('lang', 'please_enter') . ' ' . Yii::t('lang', 'email_id'); ?>');
                $('#Buyers_buyers_email_em_').show();
                $('#Buyers_buyers_email').focus();
                $('#Buyers_buyers_email').css('border-color', 'red');
                res = false;
            } else {

                var email = $('#Buyers_buyers_email').val();
                if (!email.match(/^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/)) {
                    $('#Buyers_buyers_email_em_').html('<?php echo 'Invalid ' . Yii::t('lang', 'email_id'); ?>');
                    $('#Buyers_buyers_email_em_').show();
                    $('#Buyers_buyers_email').focus();
                    $('#Buyers_buyers_email').css('border-color', 'red');
                    res = false;
                } else {

                    $.ajax({
                        url: '<?php echo Utils::GetBaseUrl() ?>/site/checkEmail',
                        data: {email: email},
                        type: 'POST',
                        'async': false,
                        success: function (res) {
                            if (res == "0") {
                                $('#Buyers_buyers_email_em_').html('E-post-ID som du angivit används redan.');
                                $('#Buyers_buyers_email_em_').show();
                                $('#Buyers_buyers_email').focus();
                                $('#Buyers_buyers_email').css('border-color', 'red');
                                res = false;
                            } else {
                                $('#Buyers_buyers_email_em_').html('');
                                $('#Buyers_buyers_email_em_').hide();
                                $('#Buyers_buyers_email').css('border-color', '#ccc');
                                res = true;
                            }
                        }
                    });
                }
            }
            return res;
        }

        function checkUsername() {
            res = true;
            if ($('#Buyers_buyers_nickname').val() == '') {

                $('#Buyers_buyers_nickname_em_').html('<?php echo Yii::t('lang', 'please_enter') . ' ' . Yii::t('lang', 'nick_name'); ?>');
                $('#Buyers_buyers_nickname_em_').show();
                $('#Buyers_buyers_nickname').focus();
                $('#Buyers_buyers_nickname').css('border-color', 'red');
                res = false;
            } else {

                var username = $('#Buyers_buyers_nickname').val();
                $.ajax({
                    url: '<?php echo Utils::GetBaseUrl() ?>/site/checkUsername',
                    data: {username: username},
                    type: 'POST',
                    'async': false,
                    success: function (res) {
                        if (res == "0") {
                            $('#Buyers_buyers_nickname_em_').html('Smeknamnet används redan.');
                            $('#Buyers_buyers_nickname_em_').show();
                            $('#Buyers_buyers_nickname').focus();
                            $('#Buyers_buyers_nickname').css('border-color', 'red');
                            res = false;
                        } else {
                            $('#Buyers_buyers_nickname_em_').html('');
                            $('#Buyers_buyers_nickname_em_').hide();
                            $('#Buyers_buyers_nickname').css('border-color', '#ccc');
                            res = true;
                        }
                    }
                });
            }

            return  res;
        }

        function checkAddress() {
            if ($('#Buyers_buyers_address').val() == '') {
                $('#Buyers_buyers_address_em_').html('<?php echo Yii::t('lang', 'please_enter') . ' ' . Yii::t('lang', 'address'); ?>');
                $('#Buyers_buyers_address_em_').show();
                $('#Buyers_buyers_address').focus();
                $('#Buyers_buyers_address').css('border-color', 'red');
                return false;
            } else {
                $('#Buyers_buyers_address_em_').html('');
                $('#Buyers_buyers_address_em_').hide();
                $('#Buyers_buyers_address').css('border-color', '#ccc');
                return true;
            }
        }

        function checkLocation() {
            if ($('#Buyers_buyers_location').val() == '') {
                $('#Buyers_buyers_location_em_').html('<?php echo Yii::t('lang', 'please_enter') . ' ' . Yii::t('lang', 'location'); ?>');
                $('#Buyers_buyers_location_em_').show();
                $('#Buyers_buyers_location').focus();
                $('#Buyers_buyers_location').css('border-color', 'red');
                return false;
            } else {
                $('#Buyers_buyers_location_em_').html('');
                $('#Buyers_buyers_location_em_').hide();
                $('#Buyers_buyers_location').css('border-color', '#ccc');
                return true;
            }
        }

        function checkZipCode() {
            if ($('#Buyers_buyers_zipcode').val() == '') {
                $('#Buyers_buyers_zipcode_em_').html('<?php echo Yii::t('lang', 'please_enter') . ' ' . Yii::t('lang', 'zipcode'); ?>');
                $('#Buyers_buyers_zipcode_em_').show();
                $('#Buyers_buyers_zipcode').focus();
                $('#Buyers_buyers_zipcode').css('border-color', 'red');
                return false;
            } else {
                $('#Buyers_buyers_zipcode_em_').html('');
                $('#Buyers_buyers_zipcode_em_').hide();
                $('#Buyers_buyers_zipcode').css('border-color', '#ccc');
                return true;
            }
        }

        function checkContactno() {
            if ($('#Buyers_buyers_contactno').val() == '') {
                $('#Buyers_buyers_contactno_em_').html('<?php echo Yii::t('lang', 'please_enter') . ' ' . Yii::t('lang', 'contactno'); ?>');
                $('#Buyers_buyers_contactno_em_').show();
                $('#Buyers_buyers_contactno').focus();
                $('#Buyers_buyers_contactno').css('border-color', 'red');
                return false;
            } else {
                $('#Buyers_buyers_contactno_em_').html('');
                $('#Buyers_buyers_contactno_em_').hide();
                $('#Buyers_buyers_contactno').css('border-color', '#ccc');
                return true;
            }
        }

        function checkFirstName() {
            if ($('#Buyers_buyers_fname').val() == '') {
                $('#Buyers_buyers_fname_em_').html('<?php echo Yii::t('lang', 'please_enter') . ' ' . Yii::t('lang', 'first_name'); ?>');
                $('#Buyers_buyers_fname_em_').show();
                $('#Buyers_buyers_fname').focus();
                $('#Buyers_buyers_fname').css('border-color', 'red');
                return false;
            } else {
                $('#Buyers_buyers_fname_em_').html('');
                $('#Buyers_buyers_fname_em_').hide();
                $('#Buyers_buyers_fname').css('border-color', '#ccc');
                return true;
            }
        }
        
        function checkLastName() {
            if ($('#Buyers_buyers_lname').val() == '') {
                $('#Buyers_buyers_lname_em_').html('<?php echo Yii::t('lang', 'please_enter') . ' ' . Yii::t('lang', 'last_name'); ?>');
                $('#Buyers_buyers_lname_em_').show();
                $('#Buyers_buyers_lname').focus();
                $('#Buyers_buyers_lname').css('border-color', 'red');
                return false;
            } else {
                $('#Buyers_buyers_lname_em_').html('');
                $('#Buyers_buyers_lname_em_').hide();
                $('#Buyers_buyers_lname').css('border-color', '#ccc');
                return true;
            }
        }


        $('#Buyers_buyers_email').bind('blur', function () {
            if (!checkEmail()) {
                return false;
            }
        });

        $('#Buyers_buyers_nickname').blur(function () {
            if (!checkUsername()) {
                return false;
            }
        });

        $('#Buyers_buyers_fname').bind('blur', function () {
            if (!checkFirstName()) {
                return false;
            }
        });
        
        $('#Buyers_buyers_lname').bind('blur', function () {
            if (!checkLastName()) {
                return false;
            }
        });

        $('#Buyers_buyers_address').blur(function () {
            if (!checkAddress()) {
                return false;
            }
        });

        $('#Buyers_buyers_location').blur(function () {
            if (!checkLocation()) {
                return false;
            }
        });

        $('#Buyers_buyers_zipcode').blur(function () {
            if (!checkZipCode()) {
                return false;
            }
        });

        $('#Buyers_buyers_contactno').blur(function () {
            if (!checkContactno()) {
                return false;
            }
        });

        $('#btnSaveChanged').click(function () {

<?php if (empty($user->buyers_email)) { ?>
                if (!checkEmail()) {
                    return false;
                }
<?php } ?>

<?php if (empty($user->buyers_nickname)) { ?>
                if (!checkUsername()) {
                    return false;
                }
<?php } ?>


            if (!checkFirstName()) {
                return false;
            }
            
            if (!checkLastName()) {
                return false;
            }

            if (!checkAddress()) {
                return false;
            }

            if (!checkLocation()) {
                return false;
            }

            if (!checkZipCode()) {
                return false;
            }

            if (!checkContactno()) {
                return false;
            }
        });

    });

    $(document).ready(function () {

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

        $('input[type="text"]').on('keyup', function () {
            trimspace(this.id);
        });

        $('textarea').on('keyup', function () {
            trimspace(this.id);
        });
        /* * **************************************************************************** */
        /* * Trim Multiple Whitespaces into Single Space for all input Elements End Block */
        /* * **************************************************************************** */

        $('.numeric').keydown(function (e) {
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

        $('.non-numeric').bind('keyup blur', function () {
            var node = $(this);
            node.val(node.val().replace(/[^a-zA-Z ]/g, ''));
        });
    });

</script>