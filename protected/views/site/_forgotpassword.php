<?php if (Yii::app()->user->hasFlash('message')): ?>
    <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?>" id="successmsg">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
<?php endif; ?>

<div class="reg-in">   

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'forgot-password-form',
        'action' => array('site/forgotpassword'),
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

    <div class="uppper-field">
        <input type="text" name="buyers_email" id="buyers_email" placeholder="<?php echo Yii::t('lang', 'email_id'); ?>" class="fill-part"/>
        <div id="buyers_email_error"></div>
    </div>   

    <div class="check-form">
        <?php echo CHtml::submitButton(Yii::t('lang', 'forgot_password'), array('class' => 'log-in-box', 'id' => 'btnForgotPassword', 'name' => 'btnForgotPassword')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>


<script type="text/javascript">
    $(function() {

        $('html, body').animate({
            scrollTop: $('.register-here').offset().top - 70
        }, 1500);

        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
            return pattern.test(emailAddress);
        }
        ;

        $('#btnForgotPassword').click(function() {
            if ($('#buyers_email').val() == '') {
                $('#buyers_email_error').css('color', 'red');
                $('#buyers_email_error').html('Please enter Email ID.');
                $('#buyers_email').focus();
                return false;
            } else {
                if (!isValidEmailAddress($('#buyers_email').val())) {
                    $('#buyers_email_error').css('color', 'red');
                    $('#buyers_email_error').html('Invalid Email ID.');
                    $('#buyers_email').focus();
                    return false;
                }
            }
        });

    });
</script>