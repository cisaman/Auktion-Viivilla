<?php

class LogController extends Controller {

    public $layout = '//layouts/dashboard_column1';

    protected function beforeAction($event) {
        if (!isset(Yii::app()->session['admin_data'])) {
            $this->redirect(Yii::app()->createAbsoluteUrl('dashboard/sellers'));
        }
        return TRUE;
    }

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'view'),
                'users' => array('Administrator'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'view'),
                'users' => array('Sellers'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionIndex() {
        $model = new Log('search');
        $model->unsetAttributes();
        $model->attributes = $_GET['Log'];

        if (isset($_GET['ajax'])) {
            $this->renderPartial('index', array(
                'model' => $model,
            ));
        } else {
            $this->render('index', array(
                'model' => $model,
            ));
        }
    }

    public function loadModel($id) {
        $model = Log::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

}
