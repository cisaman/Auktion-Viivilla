<?php

class SiteController extends Controller {

    public $layout = '//layouts/site_column1';

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            $this->layout = '//layouts/error';

            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                if ($error['code'] == 404) {
                    $this->render('error', $error);
                    die;
                } else {
                    $this->render('maintain', $error);
                    die;
                }
            }
            print_r($error['code']);
            die;
        }
    }

    // public function beforeAction($event) {
    //     $this->layout = '//layouts/error';
    //     $this->render('maintain');
    //     exit();
    // }


    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'foreColor' => 0xEE2827,
                'minLength' => 5,
                'maxLength' => 5,
                'testLimit' => 1,
                'width' => 200,
                'padding' => 10,
                'transparent' => true
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /*
     *  Home Page Action
     */

    public function actionIndex() {
        try {
            /* Object of Product Model */
            $product = new Product();

            /* Recent Products for Auction by Product Created Date */
            $recent = $product->getProducts('product_created', 'DESC', 10, 0);

            /* Products for Auction By Product Expiry Date ASC */
            $total = $product->count("product_expiry_date >= '" . date('Y-m-d H:i:s') . "' AND product_publish_date <= '" . date('Y-m-d H:i:s') . "'");
            $limit = 30;
            $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
            $sort_by = isset($_REQUEST['sort_by']) ? trim($_REQUEST['sort_by']) : "expiry_date";
            $order_by = isset($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : "ASC";
            $offset = ($page - 1) * $limit;
            $all = $product->getProducts("product_" . $sort_by, $order_by, $limit, $offset);

            $pages = new CPagination($total);
            $pages->setPageSize($limit);

            if (isset($_REQUEST['by'])) {
                $this->renderPartial('index_ajax', array(
                    'recent' => $recent,
                    'all' => $all,
                    'pages' => $pages,
                    'sort_by' => $sort_by,
                    'order_by' => $order_by,
                ));
            } else {
                $this->render('index_ajax', array(
                    'recent' => $recent,
                    'all' => $all,
                    'pages' => $pages,
                    'sort_by' => $sort_by,
                    'order_by' => $order_by,
                ));
            }
        } catch (CDbException $x) {
            $string = file_get_contents(Yii::getPathOfAlias('webroot.protected.views.site') . DIRECTORY_SEPARATOR . "maintain.php");
            print_r($string);
            die;
        }
    }

    /*
     *  send mail to kundtjanst@smediagroup.se by blb
     */

    public function actionProduct_mail() {
        $pid = $_POST['pid'];
        $path = Yii::app()->params['site_url'];
        $to = Yii::app()->params['adminEmail'];

        $model = Product::model()->findByPk($pid);

        $sql = "insert into tbl_contact(contact_name, contact_email, contact_phone, contact_message, contact_subject, contact_productID, contact_created)" .
                " values (:contact_name, :contact_email, :contact_phone, :contact_message, :contact_subject, :contact_productID, :contact_created)";

        $parameters = array(
            ":contact_name" => $_POST['yname'],
            ":contact_email" => $_POST['ymail'],
            ":contact_phone" => $_POST['yphone'],
            ":contact_message" => $_POST['ymsg'],
            ":contact_subject" => $model->product_name,
            ":contact_productID" => $pid,
            ":contact_created" => date('Y-m-d H:i:s'),
        );

        Yii::app()->db->createCommand($sql)->execute($parameters);

        //Contact Us Mail to Administrator
        $template = Template::model()->findByAttributes(array('template_alias' => 'contact_mail_from_product_details_page'));
        $subject = $template->template_subject;
        $message = $template->template_content;

        $userdata['product_code'] = $model->product_id;
        $userdata['product_name'] = $model->product_name;
        $userdata['product_link'] = $path . '/auktion/' . $model->product_id . '/' . strtolower(str_replace(' ', '-', $model->product_name));
        $userdata['user_name'] = $_POST['yname'];
        $userdata['user_email'] = $_POST['ymail'];
        $userdata['user_phone'] = $_POST['yphone'];
        $userdata['user_message'] = $_POST['ymsg'];

        $subject = $this->replace($userdata, $subject);
        $message = $this->replace($userdata, $message);
        $this->Send($to, $userdata['user_name'], $subject, $message);


        //Thank You Mail
        $template = Template::model()->findByAttributes(array('template_alias' => 'thank_you_template'));
        $subject = $template->template_subject;
        $message = $template->template_content;
        $subject = $this->replace($userdata, $subject);
        $message = $this->replace($userdata, $message);
        $this->Send($userdata['user_email'], $userdata['user_name'], $subject, $message);
    }

    public function actionGet_allprice() {
        $product = new Product();
        $recent1 = $product->getProducts('product_created', 'desc', 10, 0);
        $recent2 = $product->getProducts('product_created', 'asc', 10, 0);
        $limit = 60;
        $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
        $sort_by = isset($_REQUEST['sort_by']) ? trim($_REQUEST['sort_by']) : "expiry_date";
        $order_by = isset($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : "ASC";
        $offset = ($page - 1) * $limit;
        $all = $product->getProducts("product_" . $sort_by, $order_by, $limit, $offset);

        $result = array();
        $out = array_merge(array_merge($recent1, $all), $recent2);
        foreach ($out as $row) {
            $result[$row['p_id']] = $row;
        }
        $result = array_values($result);

        echo json_encode($result);
    }

    public function actionAbout() {
        $page = new Pages;
        $page = $page->model()->findByPk(4);

        $this->render('page', array(
            'page' => $page
        ));
    }

    /*
     *  Terms and Conditions Actions
     */

    public function actionTerms_Conditions() {
        $page = new Pages;
        $page = $page->model()->findByPk(5, 'page_status=1');

        $faqs = Faqs::model()->findAll(array('order' => 'faqs_order'), array('faqs_status' => 1));

        $this->render('page', array(
            'page' => $page,
            'faqs' => $faqs
        ));
    }

    /*
     *  Auction Package Action
     */

    public function actionPackage() {
        $page = new Pages;
        $page = $page->model()->findByPk(6, 'page_status=1');

        $this->render('page', array(
            'page' => $page
        ));
    }

    /*
     *  Contact Page Action
     */

    public function actionContact() {
        $page = new Pages;
        $page = $page->model()->findByPk(2, 'page_status=1');

        $model = new Contact;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-contact-form') {

            $posted_code = '';
            if (!empty($_POST['Contact']['verifyCode']->verifyCode)) {
                $posted_code = $_POST['Contact']['verifyCode']->verifyCode;
            }
            // echo CActiveForm::validate($model);            
            $code = Yii::app()->controller->createAction('captcha')->verifyCode;
            if ($code != $posted_code) {
                $model->verifyCode = $code;
                echo '[]';
            } else {
                echo '{"Contact_verifyCode":["Verifieringskoden st\u00e4mmer inte."]}';
            }

            Yii::app()->end();
        }

        if (isset($_POST['Contact'])) {
            $model->attributes = $_POST['Contact'];

            if ($model->save()) {

                $template = Template::model()->findByAttributes(array('template_alias' => 'thank_you_template'));
                $subject = $template->template_subject;
                $message = $template->template_content;

                $to = $model->contact_email;
                $user_name = ucfirst($model->contact_name);
                $userdata['user_name'] = $user_name;
                $msg = $this->replace($userdata, $message);

                $this->Send($to, $user_name, $subject, $msg);

                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Ditt medddelande har blivit skickat');
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'sorry_msg'));
            }
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('site/contact'));
        }

        $this->render('contact', array(
            'model' => $model,
            'page' => $page
        ));
    }

    /*
     *  Services Action
     */

    public function actionServices() {
        $this->render('services');
    }

    /*
     *  My Account Action
     */

    public function actionMyAccount() {

        if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
            $id = Yii::app()->session['user_data']['buyers_id'];
            $name = Buyers::model()->getFullName($id);
            $slug = strtolower(str_replace(' ', '-', $name));

            $this->render('account', array('user' => $name, 'id' => $id, 'slug' => $slug));
        } else {
            $this->redirect('/');
        }
    }

    /*
     *  Language Translation for English and Swedish Action
     */

    public function actionLanguage() {
        $code = $_REQUEST['code'];
        Yii::app()->user->setState('lang', $code);
    }

    /*
     *  Register User Action
     */

    public function actionRegister() {
        $this->layout = '//layouts/site_column1';

        if (isset(Yii::app()->session['user_data'])) {
            $this->redirect('myaccount');
        } else {
            $model = new Buyers('register');

            if (isset($_POST['ajax']) && $_POST['ajax'] === 'buyers-register-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            if (isset($_POST['Buyers'])) {
                $model->attributes = $_POST['Buyers'];
                $utils = new Utils();
                $model->buyers_password = $utils->passwordEncrypt($model->password_real);
                $model->buyers_roleID = 3;
                $model->buyers_city = $_POST['Buyers']['buyers_location'];
                $model->buyers_registertype = 'Normal';
                $model->buyers_status = 0;
                $model->buyers_token = sha1(date('Y-m-d H:i:s'));

                $buyers_image = CUploadedFile::getInstance($model, 'buyers_image');
                $random_name = rand(1111, 9999) . date('Ymdhi');

                if (!empty($buyers_image)) {
                    $extension = strtolower($buyers_image->getExtensionName());
                    $filename = "{$random_name}.{$extension}";
                    $model->buyers_image = $filename;
                    $buyers_image->saveAs(Utils::UserImageBasePath() . $filename);

                    /* ------ Create Image Thumbnail Start ----- */
                    $temp_path = Utils::UserImageBasePath() . $filename;
                    $img_thumbnail_path = Utils::UserThumbnailImageBasePath() . $filename;

                    $obj = new ImageThumbnail;
                    $obj->CreateImageThumbnail($temp_path, $img_thumbnail_path, $extension);
                    /* ------ Create Image Thumbnail End ----- */
                }

                if ($model->save()) {
                    $email = $model->buyers_email;
                    $buyers_token = $model->buyers_token;
                    $user_name = $model->buyers_fname . " " . $model->buyers_lname;

                    $this->SendEmail($email, $user_name, $buyers_token);

                    $msg_type = 'success';
                    $msg_text = 'Du är nu registrerad. Vänligen kontrollera din mail och verifiera din mailadress.';
                } else {
                    $msg_type = 'danger';
                    $msg_text = Yii::t('lang', 'sorry_msg');
                }
                Yii::app()->session['message'] = array('type' => $msg_type, 'msg' => $msg_text);
                $this->redirect('register');
            }

            $this->render('register', array(
                'model' => $model
            ));
        }
    }

    public function SendEmail($email, $user_name, $token) {
        $template = Template::model()->findByAttributes(array('template_alias' => 'mail_verification_template'));
        $subject = $template->template_subject;
        $message = $template->template_content;

        $utils = new Utils;
        $path = Yii::app()->params['site_url'];
        $href = $path . "site/verify?mailcode=abc123&mail=" . $email . "&token=" . $token;

        $to = $email;
        //$to = 'rahul.g@cisinlabs.com';
        //$to = 'aman.btech12@gmail.com';
        //$to = 'aman123@mailinator.com';

        $userdata['verification_link'] = $href;
        $userdata['user_name'] = $user_name;

        $message = $this->replace($userdata, $message);
        $this->Send($to, $user_name, $subject, $message);
    }

    /*
     *  Verfiy Email of User Action
     */

    public function actionVerify() {

        $mail = $_REQUEST['mail'];
        $token = $_REQUEST['token'];

        $model = Buyers::model()->findByAttributes(array('buyers_email' => $mail));

        if (!empty($model)) {
            if ($model->buyers_token == $token) {
                $model->buyers_status = 1;
                $model->buyers_token = '';

                if ($model->update()) {
                    Yii::app()->user->setFlash('type', 'success');
                    Yii::app()->user->setFlash('message', 'Grattis! Ditt konto är nu verifierad, vänligen logga in för att bjuda på produkterna. Lycka till!');
                } else {
                    Yii::app()->user->setFlash('type', 'danger');
                    Yii::app()->user->setFlash('message', 'Det gick inte att verifiera ditt konto, vänligen kontakta oss.');
                }
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', 'Det gick inte att verifiera ditt konto, vänligen kontakta oss.');
            }
        } else {
            Yii::app()->user->setFlash('type', 'danger');
            Yii::app()->user->setFlash('message', 'Det gick inte att verifiera ditt konto, vänligen kontakta oss.');
        }
        $this->redirect(array('site/status'));
    }

    /*
     *  Status after Account Activation Action
     */

    public function actionStatus() {
        $this->render('status');
    }

    /*
     *  Login Action
     */

    public function actionLogin() {
        if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
            $this->redirect('/');
        } else {
            $model = new BuyersLoginForm;

            if (isset($_POST['ajax']) && $_POST['ajax'] === 'buyers-login-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            if (isset($_POST['BuyersLoginForm'])) {
                $model->attributes = $_POST['BuyersLoginForm'];

                if (isset($_POST['redirect_url']) && !empty($_POST['redirect_url'])) {
                    Yii::app()->session['redirect_url'] = $_POST['redirect_url'];
                } else {
                    if (empty(Yii::app()->session['redirect_url'])) {
                        Yii::app()->session['redirect_url'] = Yii::app()->createAbsoluteUrl('site/myaccount');
                    }
                }

                if ($model->validate()) {
                    $id = $model->login();
                }

                switch ($id) {
                    case 1:
                        Yii::app()->user->setFlash('type', 'danger');
                        Yii::app()->user->setFlash('message', Yii::t('lang', 'invalid_emailid'));
                        break;
                    case 2:
                        Yii::app()->user->setFlash('type', 'danger');
                        Yii::app()->user->setFlash('message', Yii::t('lang', 'invalid_password'));
                        break;
                    case 3:

                        $my_buyers_id = Yii::app()->session['user_data']['buyers_id'];
                        Buyers::model()->updateLastLogin($my_buyers_id);

                        $this->redirect(Yii::app()->session['redirect_url']);
                        break;
                    case 4:
                        Yii::app()->user->setFlash('type', 'danger');
                        Yii::app()->user->setFlash('message', Yii::t('lang', 'invalid_email_password'));
                        break;
                    case 5:
                        Yii::app()->user->setFlash('type', 'danger');
                        Yii::app()->user->setFlash('message', 'Ditt konto är inte aktiverad.<br/>Vänligen kontrollera din mail och verifiera din mailadress.');
                        break;
                    default :
                        Yii::app()->user->setFlash('type', 'danger');
                        Yii::app()->user->setFlash('message', Yii::t('lang', 'msg_error'));
                        break;
                }
            }

            $this->render('login', array('model' => $model));
        }
    }

    /*
     *  Logout Action
     */

    public function actionLogout() {
        unset(Yii::app()->session['user_data']);
        Yii::app()->user->logout();
        $this->redirect('/');
    }

    /*
     *  Forgot Password Action
     */

    public function actionForgotpassword() {
        $this->layout = '//layouts/site_column1';

        if (isset($_POST['btnForgotPassword'])) {
            $email = $_POST['buyers_email'];

            $model = Buyers::model()->findByAttributes(array('buyers_email' => $email));
            if (!empty($model)) {

                $utils = new Utils();
                $template = Template::model()->findByAttributes(array('template_alias' => 'set_new_password_template'));
                $subject = $template->template_subject;
                $message = $template->template_content;

                $userdata['username'] = $model->buyers_nickname;
                $userdata['user_fullname'] = $model->buyers_fname . ' ' . $model->buyers_lname;
                $userdata['user_email'] = $model->buyers_email;

                $password = $utils->getRandomPassword();
                $userdata['user_password'] = $password;

                $subject = $this->replace($userdata, $subject);
                $message = $this->replace($userdata, $message);

                if ($this->Send($userdata['user_email'], $userdata['user_fullname'], $subject, $message)) {

                    $loadNew = Buyers::model()->findByPk($model->buyers_id);
                    $loadNew->buyers_password = $utils->passwordEncrypt($password);
                    $loadNew->buyers_token = '';
                    $loadNew->buyers_status = 1;
                    $loadNew->update();

                    Yii::app()->user->setFlash('type', 'success');
                    Yii::app()->user->setFlash('message', 'Lösenordet har skickats till registrerad mailadress.');
                } else {
                    Yii::app()->user->setFlash('type', 'danger');
                    Yii::app()->user->setFlash('message', 'Lösenord skickade misslyckades. Försök igen senare!');
                }
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'invalid_emailid'));
            }
        }

        $this->render('forgotpassword');
    }

    /*
     *  Social Login and Register Action
     */

    public function actionRegisterBySocial() {
        $model = new Buyers('social');

        if (isset($_REQUEST['type']) && !empty($_REQUEST['type'])) {

            $id = $_REQUEST['type'];

            switch ($_REQUEST['type']) {
                case 1:
                    $email = $_REQUEST['info']['email'];

                    if (isset($_REQUEST['info']['first_name']) && !empty($_REQUEST['info']['first_name'])) {
                        $first_name = $_REQUEST['info']['first_name'];
                    } else {
                        $first_name = '';
                    }

                    if (isset($_REQUEST['info']['last_name']) && !empty($_REQUEST['info']['last_name'])) {
                        $last_name = $_REQUEST['info']['last_name'];
                    } else {
                        $last_name = '';
                    }

                    if (isset($_REQUEST['info']['gender']) && !empty($_REQUEST['info']['gender'])) {
                        $gender = ($_REQUEST['info']['gender'] == 'male') ? 'M' : 'F';
                    } else {
                        $gender = '';
                    }

                    $type = 'Facebook';
                    break;

                case 2:
                    $email = $_REQUEST['info']['emails'][0]['value'];

                    if (isset($_REQUEST['info']['name']['givenName']) && !empty($_REQUEST['info']['name']['givenName'])) {
                        $first_name = $_REQUEST['info']['name']['givenName'];
                    } else {
                        $first_name = '';
                    }

                    if (isset($_REQUEST['info']['name']['familyName']) && !empty($_REQUEST['info']['name']['familyName'])) {
                        $last_name = $_REQUEST['info']['name']['familyName'];
                    } else {
                        $last_name = '';
                    }

                    if (isset($_REQUEST['info']['gender']) && !empty($_REQUEST['info']['gender'])) {
                        $gender = ($_REQUEST['info']['gender'] == 'male') ? 'M' : 'F';
                    } else {
                        $gender = '';
                    }

                    $type = 'Google';
                    break;
            }
        }

        $social_id = $_REQUEST['info']['id'];

        $user = Buyers::model()->findByAttributes(array('buyers_socialID' => $social_id, 'buyers_registertype' => $type));

        if (!empty($user)) {
//            echo 'a';
//            echo $user->buyers_id;die;

            Buyers::model()->updateLastLogin($user->buyers_id);

            $model->setSession($user->buyers_id, $user->buyers_roleID, 'User');
            echo 1;
        } else {
            $model->buyers_fname = $first_name;
            $model->buyers_lname = $last_name;
            $model->buyers_gender = $gender;
            $model->buyers_registertype = $type;
            $model->buyers_roleID = 3;
            $model->buyers_status = 1;
            //$model->buyers_nickname = strtolower($first_name) . '_' . strtolower($last_name);
            //$model->buyers_email
            $model->buyers_socialID = $social_id;

            if ($model->save()) {
//                echo 'b';
//                echo $model->buyers_id;die;
                Buyers::model()->updateLastLogin($model->buyers_id);
                $model->setSession($model->buyers_id, $model->buyers_roleID, 'User');
                echo 1;
            } else {
//                echo 'c';
//                print_r($model->getErrors());
//                die;
                echo 0;
            }
        }
    }

    /*
     *  Twiiter Login Action
     */

    public function actionTwitter() {
        $twitter = Yii::app()->twitter->getTwitter();
        $request_token = $twitter->getRequestToken();

        Yii::app()->session['oauth_token'] = $token = $request_token['oauth_token'];
        Yii::app()->session['oauth_token_secret'] = $request_token['oauth_token_secret'];

        if ($twitter->http_code == 200) {
            $url = $twitter->getAuthorizeURL($token);
            $this->redirect($url);
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    /*
     *  Twiiter Call Back Action
     */

    public function actionTwitterCallBack() {
        /* If the oauth_token is old redirect to the connect page. */
        if (isset($_REQUEST['oauth_token']) && Yii::app()->session['oauth_token'] !== $_REQUEST['oauth_token']) {
            Yii::app()->session['oauth_status'] = 'oldtoken';
        }

        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $twitter = Yii::app()->twitter->getTwitterTokened(Yii::app()->session['oauth_token'], Yii::app()->session['oauth_token_secret']);

        /* Request access tokens from twitter */
        $access_token = $twitter->getAccessToken($_REQUEST['oauth_verifier']);

        /* Save the access tokens. Normally these would be saved in a database for future use. */
        Yii::app()->session['access_token'] = $access_token;

        /* Remove no longer needed request tokens */
        unset(Yii::app()->session['oauth_token']);
        unset(Yii::app()->session['oauth_token_secret']);

        if (200 == $twitter->http_code) {
            /* The user has been verified and the access tokens can be saved for future use */
            Yii::app()->session['status'] = 'verified';

            //get an access twitter object
            $twitter = Yii::app()->twitter->getTwitterTokened($access_token['oauth_token'], $access_token['oauth_token_secret']);

            //get user details
            $user = $twitter->get("account/verify_credentials");

            $model = Buyers::model()->findByAttributes(array('buyers_socialID' => $user->id));

            if (count($model) > 0) {

                Buyers::model()->updateLastLogin($model->buyers_id);

                $model->setSession($model->buyers_id, $model->buyers_roleID, 'User');
                $this->redirect('/site/myaccount');
            } else {
                $model = new Buyers;

                $name = explode(' ', $user->name);
                if (count($name) == 1) {
                    $model->buyers_fname = $name[0];
                } else {
                    $model->buyers_fname = $name[0];
                    $model->buyers_lname = $name[1];
                }
                $model->buyers_registertype = 'Twitter';
                $model->buyers_roleID = 3;
                $model->buyers_status = 1;
                $model->buyers_socialID = $user->id;
                $model->buyers_lastlogin = date('Y-m-d H:i:s');

                if ($model->save()) {
                    $model->setSession($model->buyers_id, $model->buyers_roleID, 'User');
                    $this->redirect('site/myaccount');
                } else {
                    Yii::app()->user->setFlash('type', 'danger');
                    Yii::app()->user->setFlash('message', Yii::t('lang', 'invalid_email_password'));
                    $this->redirect('/site/login');
                }
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    /*
     *  Get Single Product Information Action
     */

    public function actionProduct($id, $title) {
        $model = new Product;
        $product = $model->getSingleProduct($id);

        $this->render('product-details', array(
            'product' => $product
        ));
    }

    /*
     *  Get Author Information Action
     */

    public function actionAuthor($id, $name) {
        $model = new User;
        $author = $model->getSingleUser($id);

        $this->render('author-details', array(
            'author' => $author
        ));
    }

    /*
     *  Search for Author Products Action
     */

    public function actionSearch($id, $name) {
        $product = new Product;

        $total = $product->model()->count('product_userID=' . $id);
        $limit = 9;
        $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
        $sort_by = isset($_REQUEST['sort_by']) ? trim($_REQUEST['sort_by']) : "expiry_date";
        $order_by = isset($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : "ASC";
        $offset = ($page - 1) * $limit;

        $all = $product->getAllProductsOfAuthor("product_" . $sort_by, $order_by, $limit, $offset, $id);

        $pages = new CPagination($total);
        $pages->setPageSize($limit);

        if (isset($_REQUEST['by'])) {
            $this->renderPartial('search', array(
                'all' => $all,
                'pages' => $pages,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        } else {
            $this->render('search', array(
                'all' => $all,
                'pages' => $pages,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        }
    }

    /*
     *  Bid Setting Action
     */

    public function actionBid() {

        $msg = '';
        $high_bid = '';
        $b_outbid_msg = '';
        $c_val = '';
        $exp_set = 0;
        $new_dif = 0;
        $new_val = 0;

        try {
            $pid = $_POST['pid'];
            $uid = $_POST['uid'];
            $val = $_POST['val'];
//            echo $this->checkAddress($uid);
//            echo $this->checkAvailability($uid);
//            die;
            if ($this->checkAddress($uid)) {
                if ($this->checkEmailVerified($uid)) {
                    if ($this->checkAvailability($uid)) {
                        if (!empty($pid) && !empty($uid) && !empty($val)) {

                            $classBid = new Bid;
                            $classProduct = new Product;

                            $product = $classProduct->model()->findByPk($pid);
                            $dif = $product->product_bid_diff_price;

                            $aman_db_value = $product->product_temp_current_price + $product->product_bid_diff_price;
                            if ($val < $aman_db_value) {
                                echo json_encode(array('check_status' => 'Vänligen försök igen!'));
                                exit();
                            }

                            //Case 1
                            $testProductExistsInBidTable = $classBid->count('bid_productID=' . $pid);
                            if ($testProductExistsInBidTable == 0) {
                                //echo 'First';die;
                                //First Bid for the Product
                                $new_val = $product->product_bid_diff_price;
                                $new_dif = $product->product_bid_diff_price + $new_val;

                                $addFirstBid = new Bid;
                                $addFirstBid->bid_productID = $pid;
                                $addFirstBid->bid_buyersID = $uid;
                                $addFirstBid->bid_value = $val;
                                $addFirstBid->bid_diff = $dif;

                                $ss = Bid::model()->findByAttributes(array('bid_productID' => $pid), array('order' => 'bid_created DESC'));
                                if (!empty($ss)) {
                                    if ($ss->bid_value == $val) {
                                        echo json_encode(array('check_status' => 'Vänligen försök igen!'));
                                        exit();
                                    }
                                }

                                if ($addFirstBid->save()) {
                                    $product->product_temp_current_price = $new_val;
                                    if ($product->save()) {
                                        $msg = Yii::t('lang', 'bid_success_msg');
                                    }
                                } else {
                                    $msg = Yii::t('lang', 'bid_fail_msg');
                                }
                            } else {
                                //echo 'Second';die;
                                //Second Bid for the Product

                                $bid = $classBid->findByAttributes(array('bid_productID' => $pid), array('order' => 'bid_created DESC', 'limit' => 1,));
                                $max = Bid::model()->findByAttributes(array('bid_productID' => $pid), array('order' => 'bid_value DESC', 'limit' => 1,));

                                $b_diff = $val - $max->bid_value;

                                $path = Yii::app()->params['site_url'];
                                $m_product = Product::model()->findByPk($pid);

                                //For Positive Value
                                if ($b_diff > 0) {

                                    $b_outbid = 0;
                                    $b_outbid_msg = '';

                                    //When Calculated difference is greater than Bid Difference for the Product
                                    if ($b_diff > $bid->bid_diff) {
                                        $new_val = $max->bid_value + $bid->bid_diff;
                                        $new_dif = $new_val + $bid->bid_diff;
                                    }
                                    //When Calculated difference is less than Bid Difference for the Product
                                    else {
                                        $new_val = $max->bid_value + $b_diff;
                                        $new_dif = $new_val + $bid->bid_diff;
                                    }

                                    $case = 1;
                                    $session_buyers_id = Yii::app()->session['user_data']['buyers_id'];
                                    if ($session_buyers_id == $max->bid_buyersID) {
                                        $template = Template::model()->findByAttributes(array('template_alias' => 'bid_over_max_bid_template'));
                                        $case = 1;
                                        $buyers1 = Buyers::model()->findByPk($session_buyers_id);
                                    } else {
                                        $template = Template::model()->findByAttributes(array('template_alias' => 'increase_bid_template'));
                                        $case = 2;
                                        $buyers1 = Buyers::model()->findByPk($max->bid_buyersID);
                                    }

                                    $subject = $template->template_subject;
                                    $message = $template->template_content;

                                    $userdata['product_code'] = $m_product->product_id;
                                    $userdata['product_name'] = $m_product->product_name;
                                    $userdata['product_link'] = $path . '/auktion/' . $m_product->product_id . '/' . strtolower(str_replace(' ', '-', $m_product->product_name));
                                    $userdata['user_name'] = $buyers1->buyers_fname . ' ' . $buyers1->buyers_lname;
                                    $userdata['user_email'] = $buyers1->buyers_email;
                                    
                                    if ($case == 2) {
                                        $userdata['user_price'] = $new_val;
                                        $userdata['bidder_name'] = Buyers::model()->findByPk($session_buyers_id)->buyers_nickname;
                                    } else {
                                        $userdata['max_bid'] = $val;
                                        $userdata['leading_bid'] = $new_val;
                                    }

                                    $subject = $this->replace($userdata, $subject);
                                    $message = $this->replace($userdata, $message);

                                    if ($this->Send($userdata['user_email'], $userdata['user_name'], $subject, $message)) {
                                        if ($case == 1) {
                                            $logdata['title'] = 'Bid Over Max Bid Mail';
                                            $logdata['userid'] = $session_buyers_id;
                                        } else {
                                            $logdata['title'] = 'Increase Bid Mail';
                                            $logdata['userid'] = $max->bid_buyersID;
                                        }

                                        $logdata['productid'] = $pid;
                                        $logdata['message'] = $message;
                                        Log::createLog($logdata);
                                    }
                                }
                                //For Negative Value
                                else {
                                    $b_outbid = 1;
                                    $b_outbid_msg = Yii::t('lang', 'out_bid_msg');

                                    $b_diff = $max->bid_value - $val;
                                    if ($b_diff <= $bid->bid_diff) {
                                        $new_val = $b_diff + $val;
                                        $new_dif = $new_val + $bid->bid_diff;
                                    } else {
                                        $new_val = $bid->bid_diff + $val;
                                        $new_dif = $new_val + $bid->bid_diff;
                                    }

                                    $session_buyers_id = Yii::app()->session['user_data']['buyers_id'];
                                    $buyers1 = Buyers::model()->findByPk($uid);

                                    $my_max_bid_user_id = Bid::model()->findByAttributes(array('bid_productID' => $pid), array('order' => 'bid_value DESC'));

                                    if ($session_buyers_id == $my_max_bid_user_id->bid_buyersID) {
                                        
                                    } else {
                                        if ($my_max_bid_user_id->bid_buyersID != $uid) {
                                            $template = Template::model()->findByAttributes(array('template_alias' => 'increase_bid_template'));
                                            $subject = $template->template_subject;
                                            $message = $template->template_content;

                                            $userdata['product_code'] = $m_product->product_id;
                                            $userdata['product_name'] = $m_product->product_name;
                                            $userdata['product_link'] = $path . '/auktion/' . $m_product->product_id . '/' . strtolower(str_replace(' ', '-', $m_product->product_name));
                                            $userdata['user_name'] = $buyers1->buyers_fname . ' ' . $buyers1->buyers_lname;
                                            $userdata['user_email'] = $buyers1->buyers_email;
                                            $userdata['user_price'] = $new_val;
                                            $userdata['bidder_name'] = Buyers::model()->findByPk($my_max_bid_user_id->bid_buyersID)->buyers_nickname;

                                            $subject = $this->replace($userdata, $subject);
                                            $message = $this->replace($userdata, $message);

                                            if ($this->Send($userdata['user_email'], $userdata['user_name'], $subject, $message)) {
                                                $logdata['title'] = 'Increase Bid Template Mail';
                                                $logdata['userid'] = $uid;
                                                $logdata['productid'] = $pid;
                                                $logdata['message'] = $message;
                                                Log::createLog($logdata);
                                            }
                                        }
                                    }
                                }

                                $product->product_temp_current_price = $new_val;

                                $saveBid = new Bid;
                                $saveBid->bid_productID = $pid;
                                $saveBid->bid_buyersID = $uid;
                                $saveBid->bid_value = $val;
                                $saveBid->bid_diff = $dif;
                                $saveBid->bid_outbid = $b_outbid;

                                $now = strtotime(date('Y-m-d H:i:s'));
                                $exp = strtotime($product->product_expiry_date);
                                $diff = $exp - $now;

                                if ($diff <= 60) {
                                    $product->product_expiry_date = date('Y-m-d H:i:s', strtotime('+3 minutes', $now));
                                    $exp_set = 1;
                                }

                                $ss = Bid::model()->findByAttributes(array('bid_productID' => $pid, 'bid_buyersID' => $uid), array('order' => 'bid_created DESC'));
                                if (!empty($ss)) {
                                    if ($ss->bid_value == $val) {
                                        echo json_encode(array('check_status' => 'Vänligen försök igen!'));
                                        exit();
                                    }
                                }

                                if ($saveBid->save()) {
                                    if ($product->save()) {
                                        $msg = Yii::t('lang', 'bid_success_msg');
                                    }
                                } else {
                                    $msg = Yii::t('lang', 'bid_fail_msg');
                                }
                            }
                        } else {
                            $msg = Yii::t('lang', 'bid_fail_msg');
                        }
                    } else {
                        $c_val = 101;
                        $msg = Yii::t('lang', 'cant_bid_pay_winner_amount_msg');
                    }
                    $addressmsg = '';
                } else {
                    $addressmsg = 'Din mailadress är inte verifierad, vänligen verifiera din mailadress för att lägga bud.';
                }
            } else {
                $addressmsg = Yii::t('lang', 'invalid_contact_information_msg');
            }
        } catch (Exception $e) {
            $msg = Yii::t('lang', 'bid_fail_msg');
        }

        echo json_encode(array('check_status' => '', 'status' => $msg, 'c_val' => $c_val, 'dif' => $new_dif, 'val' => $new_val, 'high_bid' => $high_bid, 'exp_set' => $exp_set, 'out_bid' => $b_outbid_msg, 'address' => $addressmsg));
    }

    /*
     *  Get User Profile Action
     */

    public function actionProfile() {
        if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
            $id = Yii::app()->session['user_data']['buyers_id'];
            $user = Buyers::model()->findByPk($id);

            if (isset($_POST['Buyers'])) {

                if (empty($user->buyers_email)) {
                    $user->buyers_status = 0;
                    $user->buyers_token = sha1(date('Y-m-d H:i:s'));
                }

                $user->attributes = $_POST['Buyers'];
                $user->buyers_city = $user->buyers_location = $_POST['Buyers']['buyers_location'];


                if ($user->save()) {

                    $result = Buyers::model()->findByAttributes(array('buyers_email' => $user->buyers_email));
                    if ($result->buyers_status == 0) {
                        $email = base64_encode("$user->buyers_email");
                        $buyers_token = $user->buyers_token;

                        $path = Yii::app()->params['site_url'];

                        $template = Template::model()->findByAttributes(array('template_alias' => 'mail_verification_template'));
                        $subject = $template->template_subject;
                        $message = $template->template_content;

                        //$href = $path . "site/verify?mail=" . $email . "&token=" . $buyers_token;
                        $href = $path . "site/verify?mailcode=abc123&mail=" . $email . "&token=" . $token;

                        $user_name = ucfirst($result['buyers_fname']) . " " . ucfirst($result['buyers_lname']);

                        $to = $user->buyers_email;

                        $userdata['verification_link'] = $href;
                        $userdata['user_name'] = $user_name;

                        $message = $this->replace($userdata, $message);
                        $this->Send($to, $user_name, $subject, $message);
                    }

                    Yii::app()->user->setFlash('type', 'success');
                    Yii::app()->user->setFlash('message', Yii::t('lang', 'profile_update_msg'));
                } else {
                    Yii::app()->user->setFlash('type', 'danger');
                    Yii::app()->user->setFlash('message', Yii::t('lang', 'sorry_msg'));
                }
            }

            $this->render('profile', array('user' => $user));
        } else {
            $this->redirect('/');
        }
    }

    /*
     *  Get User Bidding History Action
     */

    public function actionHistory() {
        if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
            $id = Yii::app()->session['user_data']['buyers_id'];
            $user = Buyers::model()->getFullName($id);

            $this->render('bidding_history', array('user' => $user));
        } else {
            $this->redirect('/');
        }
    }

    /*
     *  Get User Bidding History - for Ongoing, Closed, Unpaid, Paid, All Auctions Action
     */

    public function actionShowHistory($id) {
        if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
            $buyers_id = Yii::app()->session['user_data']['buyers_id'];
            $user = Buyers::model()->getFullName($buyers_id);

            $fun_id = $id;
            $history_type = Bid::model()->getFunctionType($fun_id);

            //$result = Bid::model()->getBiddedProducts($buyers_id, $fun_id);
            $result = Bid::model()->GetProductsBidByBuyerID($buyers_id, $fun_id);
//            echo '<pre>';
//            print_r($result);
//            die;

            $this->render('show_history', array(
                'user' => $user,
                'history_id' => $fun_id,
                'history_type' => $history_type,
                'result' => $result,
            ));
        } else {
            $this->redirect('/');
        }
    }

    public function actionOngoingAuctions() {
        if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
            $buyers_id = Yii::app()->session['user_data']['buyers_id'];
            $user = Buyers::model()->getFullName($buyers_id);

            $limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
            $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
            $offset = ($page - 1) * $limit;

            $result = Bid::model()->OngoingAuctionByBuyersID($offset, $limit, $buyers_id);
            $total = Bid::model()->OngoingAuctionCountByBuyersID($buyers_id);

            $pages = new CPagination($total);
            $pages->setPageSize($limit);

            if (isset($_REQUEST['by'])) {
                $this->renderPartial('ongoing_auctions', array(
                    'user' => $user,
                    'result' => $result,
                    'pages' => $pages,
                ));
            } else {
                $this->render('ongoing_auctions', array(
                    'user' => $user,
                    'result' => $result,
                    'pages' => $pages
                ));
            }
        } else {
            $this->redirect('/');
        }
    }

    public function actionClosedAuctions() {
        if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
            $buyers_id = Yii::app()->session['user_data']['buyers_id'];
            $user = Buyers::model()->getFullName($buyers_id);

            $limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
            $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
            $offset = ($page - 1) * $limit;

            $result = Bid::model()->ClosedAuctionByBuyersID($offset, $limit, $buyers_id);
            $total = Bid::model()->ClosedAuctionCountByBuyersID($buyers_id);

            $pages = new CPagination($total);
            $pages->setPageSize($limit);

            if (isset($_REQUEST['by'])) {
                $this->renderPartial('closed_auctions', array(
                    'user' => $user,
                    'result' => $result,
                    'pages' => $pages,
                ));
            } else {
                $this->render('closed_auctions', array(
                    'user' => $user,
                    'result' => $result,
                    'pages' => $pages
                ));
            }
        } else {
            $this->redirect('/');
        }
    }

    public function actionPaidAuctions() {
        if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
            $buyers_id = Yii::app()->session['user_data']['buyers_id'];
            $user = Buyers::model()->getFullName($buyers_id);

            $limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
            $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
            $offset = ($page - 1) * $limit;

            $r = Bid::model()->getPaidUnpaidStatusOfAuctionByBuyersID($offset, $limit, $buyers_id);
            $total = $r['total_paid'];
            $result = $r['product_array_paid'];

            $pages = new CPagination($total);
            $pages->setPageSize($limit);

            if (isset($_REQUEST['by'])) {
                $this->renderPartial('paid_auctions', array(
                    'user' => $user,
                    'result' => $result,
                    'pages' => $pages,
                ));
            } else {
                $this->render('paid_auctions', array(
                    'user' => $user,
                    'result' => $result,
                    'pages' => $pages
                ));
            }
        } else {
            $this->redirect('/');
        }
    }

    public function actionUnpaidAuctions() {
        if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
            $buyers_id = Yii::app()->session['user_data']['buyers_id'];
            $user = Buyers::model()->getFullName($buyers_id);

            $limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
            $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
            $offset = ($page - 1) * $limit;

            $r = Bid::model()->getPaidUnpaidStatusOfAuctionByBuyersID($offset, $limit, $buyers_id);
            $total = $r['total_unpaid'];
            $result = $r['product_array_unpaid'];

            $pages = new CPagination($total);
            $pages->setPageSize($limit);

            if (isset($_REQUEST['by'])) {
                $this->renderPartial('unpaid_auctions', array(
                    'user' => $user,
                    'result' => $result,
                    'pages' => $pages,
                ));
            } else {
                $this->render('unpaid_auctions', array(
                    'user' => $user,
                    'result' => $result,
                    'pages' => $pages
                ));
            }
        } else {
            $this->redirect('/');
        }
    }

    public function actionAllAuctions() {
        if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
            $buyers_id = Yii::app()->session['user_data']['buyers_id'];
            $user = Buyers::model()->getFullName($buyers_id);

            $limit = isset($_GET['limit']) ? $_GET['limit'] : 50;
            $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
            $offset = ($page - 1) * $limit;

            $r = Bid::model()->getPaidUnpaidStatusOfAuctionByBuyersIDFORALL($offset, $limit, $buyers_id);
            $total = $r['totals'];
            $result = $r['product_array_total'];

            $pages = new CPagination($total);
            $pages->setPageSize($limit);

            if (isset($_REQUEST['by'])) {
                $this->renderPartial('all_auctions', array(
                    'user' => $user,
                    'result' => $result,
                    'pages' => $pages,
                ));
            } else {
                $this->render('all_auctions', array(
                    'user' => $user,
                    'result' => $result,
                    'pages' => $pages
                ));
            }
        } else {
            $this->redirect('/');
        }
    }

    public function actionSearchterm() {
        $src = $_GET['keyword'];
        $src = trim(str_replace("+", " ", $src));
        $product = new Product;
        $total = $product->model()->count("product_publish_date <= '" . date('Y-m-d H:i:s') . "'    AND  product_status=1  AND product_name Like '%$src%'");
        $limit = 9;
        $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
        $sort_by = isset($_REQUEST['sort_by']) ? trim($_REQUEST['sort_by']) : "expiry_date";
        $order_by = isset($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : "ASC";
        $offset = ($page - 1) * $limit;

        $all = $product->getAllProductsbyterm("product_" . $sort_by, $order_by, $limit, $offset, $src);

        $pages = new CPagination($total);
        $pages->setPageSize($limit);

        if (isset($_REQUEST['by'])) {
            $this->renderPartial('search', array(
                'all' => $all,
                'pages' => $pages,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        } else {
            $this->render('search', array(
                'all' => $all,
                'pages' => $pages,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        }
    }

    public function actionGet_exp() {
        $sql = 'SELECT product_expiry_date as exp FROM  tbl_product  where product_id=' . $_POST['pid'];
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $exp = $command->queryRow();
        if (!empty($exp)) {
            $now = strtotime(date('Y-m-d H:i:s'));
            $exp = strtotime($exp['exp']);
            $diff = $exp - $now;
            if ($diff > 0) {
                echo $diff;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }

    public function checkAddress($uid) {
        $model = Buyers::model()->findByPk($uid);
        if (empty($model->buyers_email) || empty($model->buyers_nickname) || empty($model->buyers_fname) || empty($model->buyers_lname) || empty($model->buyers_address) || empty($model->buyers_city) || empty($model->buyers_zipcode) || empty($model->buyers_contactno)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function checkEmailVerified($uid) {
        $model = Buyers::model()->findByPk($uid);
        if ($model->buyers_status == 0) {

            $email = base64_encode("$model->buyers_email");
            $buyers_token = $model->buyers_token;

            $path = Yii::app()->params['site_url'];

            $template = Template::model()->findByAttributes(array('template_alias' => 'mail_verification_template'));
            $subject = $template->template_subject;
            $message = $template->template_content;

            //$href = $path . "site/verify?mail=" . $email . "&token=" . $buyers_token;
            $href = $path . "site/verify?mailcode=abc123&mail=" . $email . "&token=" . $token;
            $result = Buyers::model()->findByAttributes(array('buyers_email' => $model->buyers_email));
            $user_name = ucfirst($result['buyers_fname']) . " " . ucfirst($result['buyers_lname']);

            $to = $model->buyers_email;

            $userdata['verification_link'] = $href;
            $userdata['user_name'] = $user_name;

            $message = $this->replace($userdata, $message);
            $this->Send($to, $user_name, $subject, $message);

            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function checkAvailability($uid) {

        $connection = Yii::app()->db;
        $command = $connection->createCommand('SELECT distinct bid_productID, p.product_expiry_date as exp FROM `tbl_bid` b INNER JOIN tbl_product p ON b.bid_productID=p.product_id where bid_buyersID=' . $uid . ' AND p.product_expiry_date <NOW()');
        $products = $command->queryAll();

        $str = '';
        $flag = 0;

        if (count($products) > 0) {

            //print_r($products);
            foreach ($products as $product) {
                $result = Bid::model()->showWinnersWithPrice($product['bid_productID']);
                $result = json_decode($result);
                $exp_date = date('Y-m-d H:i:s', strtotime("+3 day", strtotime($product['exp'])));
                $cur_date = date('Y-m-d H:i:s');
                
                if (count($result->result) > 0) {
                    foreach ($result->result as $res) {

                        if ($res->winner_userid == $uid) {

                            $payment = Payment::model()->findAllByAttributes(array(
                                'payment_productID' => $product['bid_productID'],
                                'payment_buyersID' => $uid,
                            ));

                            if (count($payment) > 0) {
                                foreach ($payment as $key) {
                                   if ($key->payment_status == 'Pending') {
                                        if ($exp_date < $cur_date) {
                                            $flag = 1;
                                        }
                                    }
                                    if ($key->payment_status == 'Completed') {
                                       $flag = 0 ;
                                    }
                                }
                            } else {
                                if ($exp_date < $cur_date) {
                                    $flag = 1;
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            if ($flag == 1) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    function actionGet_updbid() {
        $connection = Yii::app()->db;
        $command = $connection->createCommand('SELECT product_expiry_date,product_temp_current_price as bid_val ,(product_temp_current_price+product_bid_diff_price) as bid_diff from  tbl_product where product_id=' . $_POST['pid']);
        $products = $command->queryRow();
        $now = strtotime(date('Y-m-d H:i:s'));
        $exp = strtotime($products['product_expiry_date']);
        $products['product_expiry_date'] = $exp - $now;
        echo json_encode($products);
    }

    public function actionSummary() {
        if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
            $id = Yii::app()->session['user_data']['buyers_id'];
            $name = Buyers::model()->getFullName($id);
            $slug = strtolower(str_replace(' ', '-', $name));

            $model = Payment::model()->findAllByAttributes(array('payment_buyersID' => $id, 'payment_status' => 'Completed'));

            $this->render('payment_summary', array('user' => $name, 'id' => $id, 'slug' => $slug, 'model' => $model));
        } else {
            $this->redirect('/');
        }
    }

    public function actionInvoice() {

        $info = explode('__', $_REQUEST['info']);
        $payment_id = $info[0];
        $download = (isset($info[1]) && !empty($info[1])) ? $info[1] : '';

        $payment = Payment::model()->findByPk($payment_id);

        $product_id = $payment->payment_productID;
        $buyers_id = $payment->payment_buyersID;
        $invoice_type = $payment->payment_type;
        $parent_invoiceno = $payment->payment_refund_invoiceno;
        $refund_msg = $payment->payment_remark;

        if ($invoice_type == 1) {
            $amount_paid = $payment->payment_amount;
        } else {
            $amount_paid = $payment->payment_refund;
        }

        $invoice_no = $payment->payment_invoiceno;
        $invoice_datetime = $payment->payment_created;

        $buyer = Buyers::model()->findByPk($buyers_id);
        $product = Product::model()->findByPk($product_id);

        $sellers_id = $product->product_sellersID;
        $seller = Sellers::model()->findByPk($sellers_id);

        if ($invoice_type == 1) {
            $shipping_price = $product->product_shipping_price;
            $amount = (double) $amount_paid - (double) $shipping_price;
        } else {
            $amount = (double) $amount_paid;
        }

        $my = Product::model()->getAmountToPay($product->product_id, $amount, $invoice_type);
        $my = json_decode($my);

//        if ($invoice_type == 1) {
        $tax_price_1 = $my->tax_price_1 + $my->shipping_tax_price;
        $total_amount = $my->shipping_tax_price + $my->tax_price_1 + $my->tax_price_2 + $my->tax_price_3;
        $grand_total_amount = $total_amount + $my->product_amount + $my->shipping_price;
//        } else {
//            $tax_price_1 = $my->tax_price_1;
//            $total_amount = $my->tax_price_1 + $my->tax_price_2 + $my->tax_price_3;
//            $grand_total_amount = $total_amount + $my->product_amount;
//        }

        $userdata['buyer_name'] = $buyer->buyers_fname . ' ' . $buyer->buyers_lname;
        $userdata['buyer_address'] = $buyer->buyers_address;
        $userdata['buyer_zip'] = $buyer->buyers_zipcode;
        $userdata['buyer_city'] = $buyer->buyers_city;
        $userdata['buyer_contactno'] = $buyer->buyers_contactno;
        $userdata['buyer_nickname'] = $buyer->buyers_nickname;

        $userdata['seller_username'] = $seller->sellers_username;
        $userdata['seller_name'] = $seller->sellers_fname . ' ' . $seller->sellers_lname;
        $userdata['seller_address'] = $seller->sellers_address;
        $userdata['seller_zip'] = $seller->sellers_zipcode;
        $userdata['seller_city'] = $seller->sellers_city;
        $userdata['seller_contactno'] = !empty($seller->sellers_contactno) ? $seller->sellers_contactno : '';
        $userdata['seller_nickname'] = $seller->sellers_username;

        $userdata['product_no'] = $product->product_id;
        $userdata['product_name'] = $product->product_name;
        $userdata['product_amount'] = money_format('%i', $my->product_amount);
        $userdata['product_quantity'] = money_format('%i', 1);
        $userdata['product_discount'] = $product->product_tax;
        $userdata['shipping_price'] = money_format('%i', $my->shipping_price);
        $userdata['tax_price_1'] = money_format('%i', $tax_price_1);
        $userdata['tax_price_2'] = money_format('%i', $my->tax_price_2);
        $userdata['tax_price_3'] = money_format('%i', $my->tax_price_3);
        $userdata['total_amount'] = money_format('%i', $total_amount);
        $userdata['grand_total_amount'] = money_format('%i', $grand_total_amount);

        $winner_number = Bid::model()->showWinnersWithPriceOfBuyers($product->product_id, $buyer->buyers_id);
        $userdata['winner_number'] = $winner_number;

        $userdata['invoice_no'] = $invoice_no;
        $userdata['invoice_datetime'] = date('Y-m-d H:i', strtotime($invoice_datetime));
        $userdata['parent_invoiceno'] = $parent_invoiceno;
        $userdata['paytype'] = 'Paypal';
        $userdata['refund_msg'] = $refund_msg;
        //}
        // print_r($userdata);
        // print_r($invoice_type);
        // die;

        if ($download == 'd') {
            $this->DownloadInvoice($userdata, $invoice_type);
        } else {
            if ($invoice_type == 1) {
                $template = Invoice::model()->findByAttributes(array('invoice_alias' => 'confirmation_of_payment'));
            } else {
                $template = Invoice::model()->findByAttributes(array('invoice_alias' => 'credit_of_payment'));
            }
            $message = $template->invoice_content;
            $msg = $this->replace($userdata, $message);
            echo $msg;
            die;
        }
    }

    public function DownloadInvoice($userdata, $invoice_type) {
        if ($invoice_type == 1) {
            //echo 'a';die;
            $template = Invoice::model()->findByAttributes(array('invoice_alias' => 'confirmation_of_payment'));
            //print_r($template);die;
        } else {
            //echo 'b';die;
            $template = Invoice::model()->findByAttributes(array('invoice_alias' => 'credit_of_payment'));
        }
        $message = $template->invoice_content;

        $msg = $this->replace($userdata, $message);

        $mPDF1 = Yii::app()->ePdf->mpdf();
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');


        $stylesheet = file_get_contents('http://auktion.viivilla.se/bootstrap/site/css/invoice.css');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($msg, 2);

        $mPDF1->Output('Invoice-#' . $userdata['invoice_no'] . '.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
    }

    public function actionCheckEmail() {
        $email = $_POST['email'];

        $buyer = Buyers::model()->findAllByAttributes(array('buyers_email' => $email));

        if (!empty($buyer)) {
            echo 0; //Email ID already exists
        } else {
            echo 1; //Email ID is available
        }
    }

    public function actionCheckUsername() {
        $username = $_POST['username'];

        $buyer = Buyers::model()->findAllByAttributes(array('buyers_nickname' => $username));

        if (!empty($buyer)) {
            echo 0; //Username already exists
        } else {
            echo 1; //Username is available
        }
    }

    public function actionHighBidder() {
        $pid = $_POST['pid'];
        $highbidder_nickname = Bid::model()->getHighestBidderNickName($pid);
        if (!empty($highbidder_nickname)) {
            echo $highbidder_nickname;
        } else {
            echo 0;
        }
    }

    public function actionGetReservePriceMsg() {
        $pid = $_POST['pid'];
        $uid = $_POST['uid'];
        $flag = 0;

        $m = Bid::model()->findAllByAttributes(array('bid_productID' => $pid, 'bid_buyersID' => $uid));
        if (count($m) > 0) {
            $model = Bid::model()->findByAttributes(
                    array('bid_productID' => $pid, 'bid_buyersID' => $uid), array('order' => 'bid_value DESC', 'limit' => 1, 'offset' => 0)
            );
            $flag = $model->bid_value;
        }

        echo $flag;
    }

    public function actionGetServerTime() {
        echo strtotime(date('Y-m-d H:i:s'));
    }

    public function actionSendMesssages() {


        $connection = Yii::app()->db;
        $command = $connection->createCommand('select * from tbl_product WHERE product_mailsend=0 AND product_expiry_date < "' . date('Y-m-d H:i:s') . '" LIMIT 5');
        $model = $command->queryAll();

        // $model = Product::model()->findAll(array(
        //                             'condition' => 'product_mailsend=:status AND product_expiry_date <:date',
        //                             'params' => array(':status' => 0, ':date' => date('Y-m-d H:i:s')),
        //                         ), array('limit' => 5));

        if (!empty($model)) {
            $path = Yii::app()->params['site_url'];

            foreach ($model as $product) {

                $result = Bid::model()->showWinnersWithPrice($product['product_id']);
                $result = json_decode($result);

                if (!empty($result->result)) {
                    foreach ($result->result as $users) {

                        $template = Template::model()->findByAttributes(array('template_alias' => 'notification_mail_for_payment'));
                        $subject = $template->template_subject;
                        $message = $template->template_content;

                        $buyers_id = $users->winner_userid;

                        $buyers = Buyers::model()->findByPk($buyers_id);

                        $slug = Product::createSlug($product['product_name']);
                        $link = Yii::app()->createAbsoluteUrl('site/auktion/', array('id' => $product['product_id'], 'title' => $slug));

                        $to = $buyers->buyers_email;
                        $userdata['product_code'] = $product['product_id'];
                        $userdata['product_name'] = $product['product_name'];
                        $userdata['product_link'] = $link;
                        $userdata['winner_status'] = $users->winner_number;
                        $userdata['username'] = $buyers->buyers_nickname;
                        $userdata['amount'] = $users->winner_price;

                        $subject = $this->replace($userdata, $subject);
                        $message = $this->replace($userdata, $message);

                        if ($this->Send($to, $userdata['username'], $subject, $message)) {
                            echo 'Mail Sent';
                            $history = new WinnerMailHistory;
                            $history->history_productID = $product['product_id'];
                            $history->history_buyersID = $buyers_id;
                            $history->history_description = json_encode($userdata);
                            $history->history_message = $message;
                            $history->history_created = date('Y-m-d H:i:s');
                            $history->insert();
                        } else {
                            echo 'Send Fail!';
                        }
                    }
                }

                $command->update('tbl_product', array('product_mailsend' => 1), 'product_id=:id', array(':id' => $product['product_id']));
            }
        }
    }

    public function actionGetAllBidsOfTheUser() {
        $p_id = $_POST['p_id'];
        $u_id = $_POST['u_id'];
        $model = Bid::model()->getBids($u_id, $p_id);

        $str = '';
        if (!empty($model)) {
            foreach ($model as $m) {
                $str .= '<li>';
                $str .= '   <span style="width: 30%" class="bid-num">' . $m['b_value'] . ' Kr</span>';
                $str .= '   <span style="width: 65%" class="bid-time"><a href="javascript:void(0);">' . $m['b_created'] . '</a></span>';
                $str .= '</li>';
            }
        }

        echo $str;
    }

    public function actionSendEmailByAman($id) {
        $connection = Yii::app()->db;
        $command = $connection->createCommand("SELECT buyers_id, buyers_nickname, buyers_email, buyers_lname FROM `tbl_buyers` WHERE buyers_token != '' AND buyers_status=0 ORDER BY buyers_id LIMIT " . $id . ", 50");
        $users = $command->queryAll();

        if (!empty($users)) {
            echo '<table border="1">';
            foreach ($users as $user) {
                $template = Template::model()->findByAttributes(array('template_alias' => 'new_site_mail_template'));
                $subject = $template->template_subject;
                $message = $template->template_content;

                $email = $user['buyers_email'];
                $to = $email;
                if (empty($user['buyers_nickname'])) {
                    $user_name = $user['buyers_lname'];
                    $userdata['user_name'] = $user_name;
                } else {
                    $user_name = $user['buyers_nickname'];
                    $userdata['user_name'] = $user_name;
                }

                $message = $this->replace($userdata, $message);

                if ($this->Send($to, $user_name, $subject, $message)) {
                    echo '<tr style="color: green;"><td>' . $user_name . '</td><td>' . $email . '</td><td>Sent.</td></tr>';
                } else {
                    echo '<tr style="color: red;"><td>' . $user_name . '</td><td>' . $email . '</td><td>Sent Failed.</td></tr>';
                }
            }
            echo '</table>';
        }
    }

    public function actionSendEmailByAmanToCarlos() {
        $email = 'aman971@mailinator.com';
        $user_name = 'Aman Raikwar';

        $template = Template::model()->findByAttributes(array('template_alias' => 'new_site_mail_template'));
        $subject = $template->template_subject;
        $message = $template->template_content;

        $to = $email;
        $userdata['user_name'] = $user_name;

        $message = $this->replace($userdata, $message);
        if ($this->Send($to, $user_name, $subject, $message)) {
            echo '<p style="color:green;">Mail Sent : ' . $user_name . ' on Email Address : ' . $email . '</p>';
        } else {
            echo '<p style="color:red;">Mail Sent Failed : ' . $user_name . ' on Email Address : ' . $email . '</p>';
        }
    }

    /*
     *  Get Change Password Action
     */

    public function actionChangePassword() {
        if (!empty(Yii::app()->session['user_data']['buyers_id'])) {
            $id = Yii::app()->session['user_data']['buyers_id'];
            $user = Buyers::model()->findByPk($id);
            $model = new ChangePassword;
            $utils = new Utils;

            if (isset($_POST['ajax']) && $_POST['ajax'] === 'change-password-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            if (isset($_POST['ChangePassword'])) {
                $model->attributes = $_POST['ChangePassword'];
                if ($model->new_password == $model->repeat_new_password) {

                    $old = $utils->passwordDecrypt($user->buyers_password);

                    if ($old == $model->old_password) {
                        $s = Buyers::model()->findByPk($id);
                        $s->buyers_password = $utils->passwordEncrypt($model->new_password);
                        if ($s->update()) {
                            Yii::app()->user->setFlash('type', 'success');
                            Yii::app()->user->setFlash('message', 'Lösenordet är nu ändrad.');
                        } else {
                            Yii::app()->user->setFlash('type', 'danger');
                            Yii::app()->user->setFlash('message', 'Ändringen av lösenord mysslyckades. Prova igen!');
                        }
                    } else {
                        Yii::app()->user->setFlash('type', 'danger');
                        Yii::app()->user->setFlash('message', 'Nuvarande lösenordet är felaktigt!');
                    }
                } else {
                    Yii::app()->user->setFlash('type', 'danger');
                    Yii::app()->user->setFlash('message', 'Nya lösenordet matchar inte!');
                }

                $this->refresh();
            }

            $this->render('changepassword', array('model' => $model, 'user' => $user));
        } else {
            $this->redirect('/');
        }
    }

    public function actionTestInvoice() {
        $path = Yii::app()->basePath . '/../bootstrap/tcpdf/tcpdf.php';
        require_once($path);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        //$pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('Invoice #1000');
        //$pdf->SetSubject('TCPDF Tutorial');
        //$pdf->SetKeywords('Aman, PDF, example, test, guide');
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 006', PDF_HEADER_STRING);

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
//            require_once(dirname(__FILE__) . '/lang/eng.php');
//            $pdf->setLanguageArray($l);
//        }

        $pdf->SetFont('dejavusans', '', 10);
        $path = Yii::getPathOfAlias('webroot.bootstrap.invoices') . DIRECTORY_SEPARATOR . 'credit.html';
        $template = file_get_contents($path);
        $html = $template;
        //echo $html = $template;      die;
        // add a page
        $pdf->AddPage();

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('example_006.pdf', 'I');
    }

    public function actionRecreateInvoiceNo() {
        $count = 1001;
        $all = Payment::model()->findAll('', array('order' => 'payment_id'));
        foreach ($all as $single) {
            try {
                $s = Payment::model()->findByPk($single->payment_id);
                $s->payment_invoiceno = $count;
                $s->update();
                $count++;
            } catch (Exception $e) {
                echo "Payment ID: " . $single->payment_id . ", Error:" . $e . '<br/>';
            }
        }
    }

}
