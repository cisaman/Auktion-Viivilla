<?php if (Yii::app()->user->hasFlash('message')): ?>
    <div class="alert alert-<?php echo Yii::app()->user->getFlash('type'); ?>" id="successmsg">
        <?php
        echo Yii::app()->user->getFlash('message');
        $model->password = '';
        ?>
    </div>
<?php endif; ?>

<div style="display: none;" class="right-toggle">
    <div class="right-in-open">        

        <div class="left-in">
            <?php if ($hide_title != 1) { ?>
                <h4><?php echo Yii::t('lang', 'login'); ?></h4>
            <?php } ?>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'buyers-login-form',
                'action' => array('site/login'),
                'enableAjaxValidation' => TRUE,
                'enableClientValidation' => TRUE,
                'clientOptions' => array(
                    'validateOnSubmit' => TRUE,
                    'validateOnChange' => TRUE,
                ),
                'htmlOptions' => array(
                    'autocomplete' => 'off',
                ),
                'focus' => array($model, 'username'),
            ));
            ?>                               

            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username', array('class' => 'fill-part', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('username'))); ?>
            <?php echo $form->error($model, 'username'); ?>

            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('class' => 'fill-part', 'autocomplete' => 'off', 'placeholder' => $model->getAttributeLabel('password'))); ?>
            <?php echo $form->error($model, 'password'); ?>

            <?php echo CHtml::submitButton(Yii::t('lang', 'login'), array('class' => 'log-in-box', 'id' => 'btnLogin')); ?>
            <input type="hidden" value="" id="redirect_url" name="redirect_url" />
            <?php $this->endWidget(); ?>

            <span class="forgot">
                <a href="<?php echo Yii::app()->createAbsoluteUrl('site/forgotpassword'); ?>"><?php echo Yii::t('lang', 'forgot_password'); ?></a>
            </span>
        </div>
        <div class="right-in">
            <?php if ($hide_title != 1) { ?>
                <h4><?php echo Yii::t('lang', 'sign_in_with'); ?></h4>
            <?php } ?>           

            <a class="facebook">
                <i class="fa fa-facebook"></i> facebook
                <fb:login-button size="xlarge" onlogin="checkLoginState();"></fb:login-button>      
            </a>

            <a class="twitter" href="<?php echo Yii::app()->createAbsoluteUrl('site/twitter'); ?>"><i class="fa fa-twitter"></i>twitter</a>

            <button class="g-signin google"
                    data-scope="email"
                    data-clientid="630849500510-v9339f527h41q5uh8ukh503p6c63fucj.apps.googleusercontent.com"
                    data-callback="onSignInCallback"
                    data-theme="dark"
                    data-cookiepolicy="single_host_origin">
                <i class="fa fa-google-plus"></i> google
            </button>
        </div>
    </div>
</div>

<!-- --------------------For Facebook Log In-------------------- -->
<script type="text/javascript">
    $(function(){
        // This is called with the results from from FB.getLoginStatus().
        function statusChangeCallback(response) {
            if (response.status === 'connected') {
                testAPI();
            }
        }

        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });
        }

        window.fbAsyncInit = function() {
            FB.init({
                appId: '314215545450967',
                xfbml: true,
                version: 'v2.2'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        function testAPI() {
            FB.api('/me', function(response) {
                //console.log(response);      

                $.ajax({
                    url: "<?php echo Utils::GetBaseUrl(); ?>/site/registerbysocial",
                    data: ({info: response, type: 1}),
                    type: "post",
                    success: function(result) {
                        //console.log(result);
                        if (result == 1) {
                            alert("<?php echo Yii::t('lang', 'welcome'); ?> " + response.name + '!\n\n<?php echo Yii::t("lang", "social_loggin_success_message") . '. ' . Yii::t("lang", "happy_bidding") ?>');
                            location.href = 'myaccount';
                        } else {
                            alert('<?php echo Yii::t('lang', 'sorry_msg') ?>');
                        }
                    }
                });
            });
        }
    });
</script>
<style type="text/css">
    .fb_iframe_widget {left: 0;opacity: 0;position: absolute !important;top: 0;width: 142px !important;}
    ._4z_e.img{display: none !important;}
    .facebook :hover, .twitter:hover {color: #fff !important;}     
    .fb_iframe_widget span, .fb_iframe_widget span iframe {width:  142px !important;}
    a.facebook {position: relative !important; color: #fff !important;}
    ._4z_b._4z_8._4z_c {width: 142px !important;}
</style>
<!-- --------------------For Facebook Log In-------------------- -->


<!-- --------------------For Google Log In-------------------- -->
<script src="https://plus.google.com/js/client:plusone.js" async></script>

<script type="text/javascript">

    var login = 0;

    
        /* Handler for the signin callback triggered after the user selects an account.*/
        function onSignInCallback(resp) {
            if (resp.error !== 'immediate_failed' && login == 1) {
                gapi.client.load('plus', 'v1', apiClientLoaded);
            } else {
                login = 1;
            }
        }

        /* Sets up an API call after the Google API client loads.*/
        function apiClientLoaded() {
            gapi.client.plus.people.get({userId: 'me'}).execute(handleEmailResponse);
        }

        /**
         * Response callback for when the API client receives a response.
         * @param resp The API response object with the user email and profile information.
         */
        function handleEmailResponse(response) {
            //console.log(resp);
            if (response.displayName !== '') {
                alert("<?php echo Yii::t('lang', 'welcome'); ?> " + response.displayName + '!\n\n<?php echo Yii::t("lang", "social_loggin_success_message") . '. ' . Yii::t("lang", "happy_bidding") ?>');
            } else {
                //console.log(response.emails[0].value);
                alert("<?php echo Yii::t('lang', 'welcome'); ?> " + response.emails[0].value + '!\n\n<?php echo Yii::t("lang", "social_loggin_success_message") . '. ' . Yii::t("lang", "happy_bidding") ?>');
            }

            $.ajax({
                url: "<?php echo Utils::GetBaseUrl(); ?>/site/registerbysocial",
                data: ({info: response, type: 2}),
                type: "post",
                success: function(result) {
                    if (result == 1) {
                        location.href = 'myaccount';
                    } else {
                        alert('<?php echo Yii::t('lang', 'sorry_msg') ?>');
                    }
                }
            });
        }
   

</script>
<!-- --------------------For Google Log In-------------------- -->