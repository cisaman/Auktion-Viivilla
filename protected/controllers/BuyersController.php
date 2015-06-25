<?php

class BuyersController extends Controller {

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
                'actions' => array('create', 'update', 'delete', 'users', 'removeImage', 'index', 'view', 'setNewPassword'),
                'users' => array('Administrator'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('removeImage'),
                'users' => array('Sellers'),
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

        $history_id = isset($_REQUEST['history_id']) ? trim($_REQUEST['history_id']) : 1;

        $history = Bid::model()->GetProductsBidByBuyerID($id, $history_id);

        $total = count($history);
        $limit = 5;

        $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
        $sort_by = isset($_REQUEST['sort_by']) ? trim($_REQUEST['sort_by']) : "expiry_date";
        $order_by = isset($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : "ASC";
        $offset = ($page - 1) * $limit;

        if ($history_id == 1) {
            $history = Bid::model()->OngoingAuctionByBuyersID($offset, $limit, $id);
            $total = Bid::model()->OngoingAuctionCountByBuyersID($id);
        } else if ($history_id == 2) {
            $history = Bid::model()->ClosedAuctionByBuyersID($offset, $limit, $id);
            $total = Bid::model()->ClosedAuctionCountByBuyersID($id);
        } else if ($history_id == 3) {
            $r = Bid::model()->getPaidUnpaidStatusOfAuctionByBuyersID($offset, $limit, $id);
            $total = $r['total_paid'];
            $history = $r['product_array_paid'];
        } else if ($history_id == 4) {
            $r = Bid::model()->getPaidUnpaidStatusOfAuctionByBuyersID($offset, $limit, $id);
            $total = $r['total_unpaid'];
            $history = $r['product_array_unpaid'];
        } else {
            $r = Bid::model()->getPaidUnpaidStatusOfAuctionByBuyersIDFORALL($offset, $limit, $id);
            $total = $r['totals'];
            $history = $r['product_array_total'];
        }

//        if ($page == 1) {
//            $temp_index = 0;
//            $temp_limit = $limit;
//            $history = array_slice($history, $temp_index, $temp_limit);
//        } else {
//            $temp_index = $offset;
//            $temp_limit = $limit;
//            $history = array_slice($history, $temp_index, $temp_limit);
//        }       

        $pages = new CPagination($total);
        $pages->setPageSize($limit);

        if (isset($_REQUEST['by'])) {
            $this->renderPartial('view', array(
                'model' => $this->loadModel($id),
                'history' => $history,
                'history_id' => $history_id,
                'pages' => $pages,
                'number' => $temp_index + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        } else {
            $this->render('view', array(
                'model' => $this->loadModel($id),
                'history' => $history,
                'pages' => $pages,
                'number' => $temp_index + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        }
    }

    public function actionRemoveImage() {
        $user_id = $_POST['id'];
        $model = $this->loadModel($user_id);

        try {
            if (file_exists(Utils::UserThumbnailImageBasePath() . $model->buyers_image)) {
                unlink(Utils::UserThumbnailImageBasePath() . $model->buyers_image);
            }

            if (file_exists(Utils::UserImageBasePath() . $model->buyers_image)) {
                unlink(Utils::UserImageBasePath() . $model->buyers_image);
            }

            $model->buyers_image = '';
            $model->update();
            echo 1;
        } catch (Exception $e) {
            echo 2;
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionIndex() {
        $model = new Buyers('search');
        $model->unsetAttributes();
        if (isset($_GET['ajax'])) {
            $model->attributes = $_GET['Buyers'];

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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new User;

        $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $utils = new Utils();
            $model->user_password = $utils->passwordEncrypt($model->user_password);
            $model->user_roleID = 2;

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
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Sellers created successfully.');
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', 'Operation Failed due to lack of connectivity.');
            }
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index') );
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

        if (isset($_POST['Buyers'])) {
            $model->attributes = $_POST['Buyers'];

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

            if ($model->update()) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Buyer updated successfully.');
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', 'Operation Failed due to lack of connectivity.');
            }
            $this->redirect(array
                ('index'));
        }

        $this->render('update', array(
            'model' => $model,));
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
            if (!isset($_GET['ajax'])) {
                Yii::app()->user->setFlash('type', 'Buyer deleted successfully.');
                Yii::app()->user->setFlash('message', 'Buyer deleted successfully.');
            } else {
                echo '<div class="alert alert-success alert-dismissable" id="successmsg">Buyer deleted successfully.</div>';
            }
        }

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Buyers::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST[
                        'ajax']) && $_POST['ajax'] === 'buyers-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSetNewPassword($id) {
        $model = $this->loadModel($id);

        $utils = new Utils;
        $u_password = $utils->getRandomPassword();
        $u_fullname = $model->buyers_fname . ' ' . $model->buyers_lname;
        $u_username = $model->buyers_nickname;
        $u_email = $model->buyers_email;

        $model->buyers_password = $utils->passwordEncrypt($u_password);
        $model->buyers_token = '';
        $model->buyers_status = 1;

        if ($model->update()) {

            $template = Template::model()->findByAttributes(array('template_alias' => 'set_new_password_template'));
            $subject = $template->template_subject;
            $message = $template->template_content;

            $userdata['username'] = $u_username;
            $userdata['user_fullname'] = $u_fullname;
            $userdata['user_email'] = $u_email;
            $userdata['user_password'] = $u_password;
            $to = $u_email;

            $subject = $this->replace($userdata, $subject);
            $message = $this->replace($userdata, $message);

            if ($this->Send($to, $u_fullname, $subject, $message)) {
                $result = array('type' => 'success', 'msg' => 'Buyers password reset successfully. Mail is sent.');
            } else {
                $result = array('type' => 'warning', 'msg' => 'Buyers password reset successfully. Mail is not sent. Try again later.');
            }
        } else {
            $result = array('type' => 'danger', 'msg' => 'Buyers password reset failed. Try again later.');
        }

        echo json_encode($result);
    }

}
