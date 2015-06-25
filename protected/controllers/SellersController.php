<?php

class SellersController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/dashboard_column1';

    protected function beforeAction($event) {
        if (!isset(Yii::app()->session['admin_data'])) {
            $this->redirect(Yii::app()->createAbsoluteUrl('dashboard/sellers'));
        }
        return TRUE;
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('create', 'update', 'delete', 'removeImage', 'index', 'view', 'setNewPassword', 'getAllSellers'),
                'users' => array('Administrator'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Sellers;

        $this->performAjaxValidation($model);

        if (isset($_POST['Sellers'])) {
            $model->attributes = $_POST['Sellers'];
            $model->sellers_vatno = $_POST['Sellers']['sellers_vatno'];
            $model->sellers_website = $_POST['Sellers']['sellers_website'];

            $utils = new Utils();
            $model->sellers_password = $utils->passwordEncrypt($model->sellers_password);
            $model->sellers_roleID = 2;

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

//                $template = Template::model()->findByAttributes(array('template_alias' => 'seller_account_created_template'));
//                $subject = $template->template_subject;
//                $message = $template->template_content;
//
//                $path = Yii::app()->params['site_url'];
//                $userdata['seller_name'] = $model->sellers_fname . ' ' . $model->sellers_lname;
//                $userdata['seller_username'] = $model->sellers_username;
//                $userdata['seller_email'] = $model->sellers_email;
//                $userdata['seller_password'] = $utils->passwordDecrypt($model->sellers_password);
//                $userdata['seller_photo'] = $path . '/bootstrap/uploads/user/' . $model->sellers_image;
//                $userdata['seller_address'] = $model->sellers_address;
//                $userdata['seller_city'] = $model->sellers_city;
//                $userdata['seller_country'] = $model->sellers_country;
//                $userdata['seller_zipcode'] = $model->sellers_zipcode;
//                $userdata['seller_contactno'] = $model->sellers_contactno;
//
//                $subject = $this->replace($userdata, $subject);
//                $message = $this->replace($userdata, $message);
                //if ($this->Send($userdata['seller_email'], $userdata['seller_name'], $subject, $message)) {
                //Yii::app()->user->setFlash('type', 'success');
                //Yii::app()->user->setFlash('message', 'Seller added successfully. Mail is sent.');
                //} else {
                //Yii::app()->user->setFlash('type', 'warning');
                //Yii::app()->user->setFlash('message', 'Seller added successfully. Mail is not sent. Try again later.');
                //}
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Seller added successfully.');
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', 'Operation Failed due to lack of connectivity.');
            }
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);

        if (isset($_POST['Sellers'])) {
            $model->attributes = $_POST['Sellers'];

            $model->sellers_vatno = $_POST['Sellers']['sellers_vatno'];
            $model->sellers_website = $_POST['Sellers']['sellers_website'];

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
                Yii::app()->user->setFlash('message', 'Seller updated successfully.');
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', 'Operation Failed due to lack of connectivity.');
            }
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

        if ($model->delete()) {

            $image_name = $model->sellers_image;
            if (file_exists(Utils::UserImageBasePath() . $image_name)) {
                unlink(Utils::UserImageBasePath() . $image_name);
            }

            if (file_exists(Utils::UserThumbnailImageBasePath() . $image_name)) {
                unlink(Utils::UserThumbnailImageBasePath() . $image_name);
            }

            if (!isset($_GET['ajax'])) {
                Yii::app()->user->setFlash('type', 'Seller deleted successfully.');
                Yii::app()->user->setFlash('message', 'Seller deleted successfully.');
            } else {
                echo '<div class="alert alert-success alert-dismissable" id="successmsg">Seller deleted successfully.</div>';
            }
        }

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Sellers('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ajax'])) {
            $model->attributes = $_GET['Sellers'];

            $this->renderPartial('index', array(
                'model' => $model,
            ));
        } else {
            $this->render('index', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Sellers the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Sellers::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Sellers $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sellers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSetNewPassword($id) {
        $model = $this->loadModel($id);

        $utils = new Utils;
        $u_password = $utils->getRandomPassword();
        $u_fullname = $model->sellers_fname . ' ' . $model->sellers_lname;
        $u_username = $model->sellers_username;
        $u_email = $model->sellers_email;

        $model->sellers_password = $utils->passwordEncrypt($u_password);

        if ($model->save()) {

            $template = Template::model()->findByAttributes(array('template_alias' => 'set_new_password_template'));
            $subject = $template->template_subject;
            $message = $template->template_content;

            $userdata['user_fullname'] = $u_fullname;
            $userdata['username'] = $u_username;
            $userdata['user_email'] = $u_email;
            $userdata['user_password'] = $u_password;
            $userdata['site_name'] = $path;
            $userdata['path'] = $path;
            $to = $u_email;

            $subject = $this->replace($userdata, $subject);
            $message = $this->replace($userdata, $message);

            if ($this->Send($to, $u_fullname, $subject, $message)) {
                $result = array('type' => 'success', 'msg' => 'Seller password reset successfully. Mail is sent.');
            } else {
                $result = array('type' => 'warning', 'msg' => 'Seller password reset successfully. Mail is not sent. Try again later.');
            }
        } else {
            $result = array('type' => 'danger', 'msg' => 'Seller password reset failed. Try again later.');
        }

        echo json_encode($result);
    }

    public function actionGetAllSellers() {
        $model = Sellers::model()->findAll(array('order' => 'sellers_username', 'condition' => 'sellers_id!=:x', 'params' => array(':x' => '25')));
        $sellers = array();

        foreach ($model as $m) {
            $sellers[] = array('id' => $m->sellers_id, 'name' => $m->sellers_username);
        }

        echo json_encode($sellers);
    }

}
