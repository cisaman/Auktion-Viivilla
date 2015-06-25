<?php

class ContactController extends Controller {

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
                'actions' => array('view', 'delete', 'index', 'reply', 'replyList'),
                'users' => array('Administrator'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index'),
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

        $model = $this->loadModel($id);
        $model->contact_status = 0;
        $model->update();

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Contact;

        $this->performAjaxValidation($model);

        if (isset($_POST['Contact'])) {
            $model->attributes = $_POST['Contact'];

            if ($model->save()) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'contact') . ' ' . Yii::t('lang', 'msg_create'));
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'msg_error'));
            }
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

        $this->render('create', array(
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

        //$this->performAjaxValidation($model);

        if (isset($_POST['Contact'])) {
            $model->attributes = $_POST['Contact'];
            $model->contact_status = $_POST['Contact']['contact_status'];

            if ($model->save()) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'contact') . ' ' . Yii::t('lang', 'msg_update'));
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'msg_error'));
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
            if (!isset($_GET['ajax'])) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'contact') . ' ' . Yii::t('lang', 'msg_delete'));
            } else {
                echo '<div class="alert alert-success alert-dismissable" id="successmsg">' . Yii::t('lang', 'contact') . ' ' . Yii::t('lang', 'msg_delete') . '</div>';
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
        $model = new Contact('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Contact'])) {
            $model->attributes = $_GET['Contact'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Contact the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Contact::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Contact $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'contact-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionReply() {
        $contact_id = $_POST['id'];
        $reply_message = $_POST['message'];

        $model = $this->loadModel($contact_id);

        $obj = new Reply;
        $obj->reply_message = $reply_message;
        $obj->reply_contactID = $contact_id;

        if ($obj->save()) {

            $to = $model->contact_email;
            //$to = 'aman.r@cisinlabs.com';

            $userdata['subject_line'] = $model->contact_subject;
            $userdata['contact_name'] = $model->contact_name;
            $userdata['reply_message'] = $reply_message;

            if (!empty($model->contact_productID)) {
                $p = Product::model()->findByPk($model->contact_productID);
                $userdata['product_id'] = $p->product_id;
                $userdata['product_name'] = $p->product_name;
                $userdata['project_link'] = Yii::app()->params['site_url'] . '/product/' . $p->product_id . '/' . Product::model()->createSlug($p->product_name);

                $template = Template::model()->findByAttributes(array('template_alias' => 'reply_mail_template_for_product'));
            } else {
                $template = Template::model()->findByAttributes(array('template_alias' => 'reply_mail_template'));
            }

            $subject = $template->template_subject;
            $message = $template->template_content;

            $subject = $this->replace($userdata, $subject);
            $message = $this->replace($userdata, $message);

            if ($this->Send($to, $userdata['contact_name'], $subject, $message)) {
                $res = array('flag' => 1);
            } else {
                $res = array('flag' => 0);
            }
        } else {
            $res = array('flag' => 0);
        }

        echo json_encode($res);
    }

    public function actionReplyList() {

        $contact_id = $_POST['id'];
        $model = Reply::model()->findAllByAttributes(array('reply_contactID' => $contact_id), array('order' => 'reply_created DESC'));
        $result = array();

        if (count($model) > 0) {
            $flag = 1;
            foreach ($model as $m) {
                $result[] = array(
                    'message' => $m->reply_message,
                    'datetime' => $m->reply_created
                );
            }
        } else {
            $flag = 0;
        }

        $res = array('flag' => $flag, 'data' => $result);
        echo json_encode($res);
    }

}
