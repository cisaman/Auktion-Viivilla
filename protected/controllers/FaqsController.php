<?php

class FaqsController extends Controller {

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
                'actions' => array('create', 'update', 'delete', 'index', 'view', 'saveOrder'),
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

    public function actionCreate() {
        $model = new Faqs;

        $this->performAjaxValidation($model);

        if (isset($_POST['Faqs'])) {
            $model->attributes = $_POST['Faqs'];
            $model->faqs_ans = $_POST['description'];

            if ($model->save()) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'faqs') . ' ' . Yii::t('lang', 'msg_create'));
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

        $this->performAjaxValidation($model);

        if (isset($_POST['Faqs'])) {
            $model->attributes = $_POST['Faqs'];
            $model->faqs_ans = $_POST['description'];
            $model->faqs_status = $_POST['Faqs']['faqs_status'];

            if ($model->save()) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'faqs') . ' ' . Yii::t('lang', 'msg_update'));
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
                Yii::app()->user->setFlash('message', Yii::t('lang', 'faqs') . ' ' . Yii::t('lang', 'msg_delete'));
            } else {
                echo '<div class="alert alert-success alert-dismissable" id="successmsg">' . Yii::t('lang', 'faqs') . ' ' . Yii::t('lang', 'msg_delete') . '</div>';
            }
        }

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $model = new Faqs('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Faqs'])) {
            $model->attributes = $_GET['Faqs'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Faqs the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Faqs::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Faqs $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'faqs-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionSaveOrder() {
        $order = $_POST['list'];

        $total = count($order);
        $flag = 0;

        foreach ($order as $key => $value) {
            $faq = Faqs::model()->findByPk($value);
            if (!empty($faq)) {
                $faq->faqs_order = $key;
                $faq->update();
                $flag++;
            }
        }

        if ($flag == $total) {
            echo TRUE;
        } else {
            echo FALSE;
        }
    }

}
