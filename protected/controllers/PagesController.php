<?php

class PagesController extends Controller {

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
        $model = new Pages;

        $this->performAjaxValidation($model);

        if (isset($_POST['Pages'])) {
            $model->attributes = $_POST['Pages'];
            $model->page_content = $_POST['Pages']['page_content'];

            if ($model->save()) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'pages') . ' ' . Yii::t('lang', 'msg_create'));
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

        if (isset($_POST['Pages'])) {

            $old_data = $model->page_content;
            $new_data = $_POST['Pages']['page_content'];

            if (!empty($old_data)) {
                $doc = new DOMDocument();
                $doc->loadHTML($old_data);
                $xml = simplexml_import_dom($doc);
                $images = $xml->xpath('//img');

                if (!empty($new_data)) {
                    $new_doc = new DOMDocument();
                    $new_doc->loadHTML($new_data);
                    $new_xml = simplexml_import_dom($new_doc);
                    $new_images = $new_xml->xpath('//img');
                }

                foreach ($images as $img) {
                    $src = $img['src'];
                    $array = pathinfo($src);
                    $file = $array['basename'];

                    if (!empty($new_data)) {
                        foreach ($new_images as $new_img) {
                            $new_src = $new_img['src'];
                            $new_array = pathinfo($new_src);
                            $new_file = $new_array['basename'];

                            if ($file != $new_file) {
                                $src = Yii::app()->basePath . '/../bootstrap/ckeditor/upload_dir/' . $file;
                                if (file_exists($src)) {
                                    unlink($src);
                                }
                            }
                        }
                    }
//                    } else {
//                        $src = Yii::app()->basePath . '/../bootstrap/ckeditor/upload_dir/' . $file;
//                        if (file_exists($src)) {
//                            unlink($src);
//                        }
//                    }
                }
            }

            $model->attributes = $_POST['Pages'];
            $model->page_content = $new_data;
            $model->page_status = $_POST['Pages']['page_status'];

            //print_r($model->page_content);die;

            if ($model->save()) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'pages') . ' ' . Yii::t('lang', 'msg_update'));
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
        $model->page_status = 0;

        if ($model->save()) {
            if (!isset($_GET['ajax'])) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'pages') . ' ' . Yii::t('lang', 'msg_deactive'));
            } else {
                echo '<div class="alert alert-success alert-dismissable" id="successmsg">' . Yii::t('lang', 'pages') . ' ' . Yii::t('lang', 'msg_deactive') . '</div>';
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
        $model = new Pages('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Pages'])) {
            $model->attributes = $_GET['Pages'];
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Category the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Pages::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Category $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pages-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
