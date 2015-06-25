<?php

class DashboardController extends Controller {

    public $layout = '//layouts/dashboard_column1';

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {

        if (isset(Yii::app()->session['admin_data'])) {
            Yii::app()->user->setFlash('msg', 'Already logged in');
            $this->render('index');
        } else {
            $this->actionSellers();
        }
    }

    public function actionChangePassword() {

        if (isset(Yii::app()->session['admin_data'])) {
            $model = new User;
            $this->render('changepassword', array('model' => $model));
        } else {
            $this->redirect('sellers');
        }
    }

    /**
     * Displays the forgot password page
     */
    public function actionForgotpassword() {
        $this->layout = '//layouts/login';
        $model = new LoginForm;

        if (isset($_POST['LoginForm'])) {
            $email = $_POST['LoginForm']['username'];

            $utils = new Utils;
            $seller = Sellers::model()->findByAttributes(array('sellers_email' => strtolower($email)));

            if (empty($seller)) {
                $flag = 1;
            } else {
                $flag = 2;

                $template = Template::model()->findByAttributes(array('template_alias' => 'seller_forgot_password_template'));
                $subject = $template->template_subject;
                $message = $template->template_content;

                $path = Yii::app()->params['site_url'];
                $userdata['seller_username'] = $seller->sellers_username;
                $userdata['seller_name'] = $seller->sellers_fname . ' ' . $seller->sellers_lname;
                $userdata['seller_email'] = $seller->sellers_email;
                $userdata['seller_password'] = $utils->passwordDecrypt($seller->sellers_password);

                $subject = $this->replace($userdata, $subject);
                $message = $this->replace($userdata, $message);

                $this->Send($userdata['seller_email'], $userdata['seller_name'], $subject, $message);
            }

            switch ($flag) {
                case 1:
                    Yii::app()->user->setFlash('type', 'danger');
                    Yii::app()->user->setFlash('message', 'The E-mail ID is not found in our database. Please check your E-mail ID.');
                    break;
                case 2:
                    Yii::app()->user->setFlash('type', 'success');
                    Yii::app()->user->setFlash('message', 'A Mail has been sent. Please check your Inbox for Mail. Thanks!');
                    break;
                default :
                    Yii::app()->user->setFlash('type', 'danger');
                    Yii::app()->user->setFlash('message', 'Unknown error. Please contact Site Administrator.');
                    break;
            }
        }

        $this->render('forgotpassword', array('model' => $model));
    }

    /**
     * Performs the AJAX validation.
     * @param Appinfo $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'appinfo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
     *
     * Sellers Section
     * 
     */

    /**
     * Displays the login page for Sellers
     */
    public function actionSellers() {
        $this->layout = '//layouts/login';

        if (isset(Yii::app()->session['admin_data'])) {
            Yii::app()->user->setFlash('msg', 'Already logged in');
            $this->redirect('index');
        } else {
            $this->layout = 'login';

            $model = new SellersLoginForm;

            if (isset($_POST['ajax']) && $_POST['ajax'] === 'sellers-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            if (isset($_POST['SellersLoginForm'])) {
                $model->attributes = $_POST['SellersLoginForm'];                
                if ($model->validate() && $model->login()) {
                    $this->redirect(Yii::app()->createAbsoluteUrl('dashboard/index'));
                } else {
                    Yii::app()->user->setFlash('msg', 'Invalid Email ID or Password.');
                }
            }

            $this->render('sellers_login', array('model' => $model));
        }
    }

    /**
     * Sellers Profile Page
     */
    public function actionProfile() {
        if (isset(Yii::app()->session['admin_data'])) {

            $sellers_id = Yii::app()->session['admin_data']['admin_id'];
            $model = Sellers::model()->findByPk($sellers_id);

            $this->performAjaxValidation($model);

            if (isset($_POST['Sellers'])) {
                $model->attributes = $_POST['Sellers'];                

                if (isset($_POST['btnSaveProfile'])) {
                    if ($model->save()) {
                        Yii::app()->user->setFlash('type', 'success');
                        Yii::app()->user->setFlash('message', 'Basic Information updated successfully.');
                    } else {
                        Yii::app()->user->setFlash('type', 'danger');
                        Yii::app()->user->setFlash('message', 'Operation Failed due to lack of connectivity.');
                    }
                }

                if (isset($_POST['btnSaveProfilePicture'])) {
                    $sellers_image = CUploadedFile::getInstance($model, 'sellers_image');
                    $random_name = rand(1111, 9999) . date('Ymdhi');

                    if (!empty($sellers_image)) {

                        $extension = strtolower($sellers_image->getExtensionName());
                        $filename = "{$random_name}.{$extension}";
                        $model->sellers_image = $filename;
                        $sellers_image->saveAs(Utils::UserImageBasePath() . $filename);

                        /* ------ Create Image Thumbnail Start ----- */
                        $temp_path = Utils::UserImageBasePath() . $filename;
                        $img_thumbnail_path = Utils::UserThumbnailImageBasePath() . $filename;
                        
                        $this->CreateThumbForImages(200, 200, $temp_path, $img_thumbnail_path);
                        /* ------ Create Image Thumbnail End ----- */
                    }

                    if ($model->save()) {
                        Yii::app()->user->setFlash('type', 'success');
                        Yii::app()->user->setFlash('message', 'Profile photo changed successfully.');
                    } else {
                        Yii::app()->user->setFlash('type', 'danger');
                        Yii::app()->user->setFlash('message', 'Operation Failed due to lack of connectivity.');
                    }
                }

                if (isset($_POST['btnSavePassword'])) {
                    if ($model->save()) {
                        Yii::app()->user->setFlash('type', 'success');
                        Yii::app()->user->setFlash('message', 'Password changed successfully.');
                    } else {
                        Yii::app()->user->setFlash('type', 'danger');
                        Yii::app()->user->setFlash('message', 'Operation Failed due to lack of connectivity.');
                    }
                }
            }

            $this->render('sellers_profile', array('model' => $model));
        } else {
            $this->redirect('sellers');
        }
    }

    /*
     *
     * Common Section
     * 
     */

    /**
     * Logs out the current User and redirect to their specific Login Page.
     */
    public function actionLogout() {
        unset(Yii::app()->session['admin_data']);
        $this->redirect('sellers');
    }

    public function actionGetTables() {
        $connection = Yii::app()->db; //get connection
        $dbSchema = $connection->schema;
        $tables = $dbSchema->getTables(); //returns array of tbl schema's

        $options = array();
        foreach ($tables as $tbl) {//for example
            $options[trim($tbl->rawName, '`')] = $tbl->name;
        }
        $dropDown = CHtml::dropDownList('TemplateCategory[template_category_table_name]', $tables[0]->rawName, $options, array('class' => 'form-control', 'empty' => 'Please Select Table Name'));
        echo $dropDown;
    }

    public function actionGetFieldNamesByTableName() {
        $tableName = $_POST['tableName'];

        $connection = Yii::app()->db; //get connection
        $dbSchema = $connection->schema;
        $tables = $dbSchema->getTable($tableName); //returns array of tbl schema's


        $options = array();
        foreach ($tables->columns as $tbl) {//for example            
            $options[trim($tbl->rawName, '`')] = $tbl->name;
        }
        $dropDown = CHtml::listBox('TemplateCategory[template_category_field_names]', $tables->columns[0], $options, array('class' => 'form-control', 'size' => '10', 'multiple' => 'TRUE',));
        echo $dropDown;
        //die;
    }

}
