<?php

class LangController extends Controller {

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
                'actions' => array('create', 'update', 'delete', 'index'),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Lang;

        $this->performAjaxValidation($model);

        if (isset($_POST['Lang'])) {
            $model->attributes = $_POST['Lang'];

            try {
                /* For English */
                $model1 = new Lang;
                $model1->attributes = $_POST['Lang'];
                $model1->lang_shortcode = 'en';
                $model1->lang_attribute_t = $_POST['Lang']['en_t'];
                $model1->save();

                /* For Swedish */
                $model2 = new Lang;
                $model2->attributes = $_POST['Lang'];
                $model2->lang_shortcode = 'sv';
                $model2->lang_attribute_t = $_POST['Lang']['sv_t'];
                $model2->save();

                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Language created successfully.');
            } catch (Exception $ex) {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', 'Operation Failed due to lack of connectivity.');
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
        $other = Lang::model()->findByAttributes(array(
            "lang_attribute" => $model->lang_attribute), 'lang_shortcode <> "' . $model->lang_shortcode . '"'
        );
        if ($model->lang_shortcode == 'sv') {
            $model->en_t = $other->lang_attribute_t;
            $model->sv_t = $model->lang_attribute_t;
        } else {
            $model->en_t = $model->lang_attribute_t;
            $model->sv_t = $other->lang_attribute_t;
        }

        $this->performAjaxValidation($model);

        if (isset($_POST['Lang'])) {

            $attrib = $_POST['Lang']['lang_attribute'];
            

            $model1 = $this->loadModel($_POST['id']);            
            if ($model1->lang_shortcode == 'en') {
                $model1->lang_attribute_t = $_POST['Lang']['en_t'];
            } else if ($model1->lang_shortcode == 'sv') {
                $model1->lang_attribute_t = $_POST['Lang']['sv_t'];
            }

            $model2 = Lang::model()->findByAttributes(array(
                "lang_attribute" => $model1->lang_attribute), 'lang_shortcode <> "' . $model1->lang_shortcode . '"'
            );                        
            if ($model2->lang_shortcode == 'sv') {
                $model2->lang_attribute_t = $_POST['Lang']['sv_t'];
            } else if ($model2->lang_shortcode == 'en') {
                $model2->lang_attribute_t = $_POST['Lang']['en_t'];
            }
            
            $model1->lang_attribute = $attrib;
            $model2->lang_attribute = $attrib;
//            print_r($_POST);
//            die;

            if ($model1->update() && $model2->update()) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Language updated successfully.');
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
            if (!isset($_GET['ajax'])) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Language deleted successfully.');
            } else {
                echo '<div class="alert alert-success alert-dismissable" id="successmsg">Language deleted successfully.</div>';
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
        $model = new Lang('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET[
                        'Lang'])) {
            $model->attributes = $_GET ['Lang'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Lang the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Lang::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Lang $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'lang-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
