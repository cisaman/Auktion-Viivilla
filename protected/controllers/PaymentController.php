<?php

class PaymentController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout = false;

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
        $model = new Payment;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Payment'])) {
            $model->attributes = $_POST['Payment'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->_id));
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Payment'])) {
            $model->attributes = $_POST['Payment'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->_id));
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Payment');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Payment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Payment']))
            $model->attributes = $_GET['Payment'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Payment the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Payment::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Payment $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPay() {
        $this->layout = false;
        $custom = $_POST['user_id'];
        $paypalManager = Yii::app()->getModule('SimplePaypal')->paypalManager;
        $paypalManager->addField('item_name', $_POST['item_name']);
        $paypalManager->addField('item_number', $_POST['item_id']);
        $paypalManager->addField('amount', $_POST['amount']);
        $paypalManager->addField('custom', $custom);
        $paypalManager->addField('shipping', $_POST['shipping']);
        //$paypalManager->dumpFields();   // for printing paypal form fields        
        //die;
        $data = $paypalManager->submitPaypalPost();

        //print_r($data);die;

        $this->render('pay', array(
            'data' => $data,
        ));
    }

    public function actionConfirm() {

        if (isset($_GET['q']) && $_GET['q'] == 'success' && (isset($_POST["txn_id"]) && isset($_POST["txn_type"]))) {
            $user_id = $_REQUEST['custom'];

            $user = Buyers::model()->findByPk($user_id);
            $to = $user->buyers_email;
            $subject = 'Auktion Viivilla - Payment Status';
            $path = Yii::app()->params['site_url'];
            //$to = "bhaiyyalal.b@cisinlabs.com";

            $user_name = ucwords($user->buyers_fname . ' ' . $user->buyers_lname);
            $userdata['path'] = $path;
            $userdata['username'] = $user_name;
            $userdata['transaction_id'] = $_POST['txn_id'];
            $userdata['transaction_status'] = $_POST['payment_status'];
            $userdata['site_name'] = $path;

            //Product Id, Product Name, Product Temp Price
            $payment = Payment::model()->findByAttributes(array('payment_transaction_id' => $_POST['txn_id']));
            $product_id = $payment->payment_productID;
            $payment_amount = $payment->payment_amount;

            $product = Product::model()->findByPk($product_id);
            $slug = strtolower(str_replace(' ', '-', $product->product_name));
            $url = Yii::app()->createAbsoluteUrl('product/' . $product->product_id . '/' . $slug);

            $template = Template::model()->findByAttributes(array('template_alias' => 'payment_status_template'));
            $subject = $template->template_subject;
            $message = $template->template_content;

            $userdata['item_url'] = $url;
            $userdata['item_number'] = $product->product_id;
            $userdata['item_name'] = $product->product_name;
            $userdata['item_temp_price'] = $product->product_temp_current_price;
            $userdata['item_amount'] = $payment_amount;

            $subject = $this->replace($userdata, $subject);
            $message = $this->replace($userdata, $message);

            $this->Send($to, $user_name, $subject, $message);

            if (isset($_REQUEST['payment_status']) && $_REQUEST['payment_status'] == "Pending") {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Din betalning är nu genomförd. Transaktions-Id är ' . $_POST["txn_id"] . '.');
                $this->redirect(array('site/summary'));
            } else {
                Yii::app()->user->setFlash('type', 'warning');
                Yii::app()->user->setFlash('message', 'Din betalning väntar. Transaktions-Id är ' . $_POST["txn_id"] . '.');
                $this->redirect(array('site/summary'));
            }
        } else {
            Yii::app()->user->setFlash('type', 'danger');
            Yii::app()->user->setFlash('message', 'Din transaktion minskat. Vänligen kontakta sajtadministratör.');
            $this->redirect(array('site/summary'));
        }
    }

    public function actionSummary() {
        $this->render(array('summary'));
    }

    /*
     * Function for notify url
     */

    public function actionNotify() {
//        $headers = "From:Aman <aman.r@cisinlabs.com>\r\n" .
//                "Reply-To: rahul.g@cisinlabs.com\r\n" .
//                "MIME-Version: 1.0\r\n" .
//                "Content-Type: text/plain; charset=UTF-8";
//        $strData = "Rahul";
//        foreach ($_REQUEST as $key => $obj) {
//            $strData .= $key . '=>' . $obj . "\n";
//        }
//        mail("rahul.g@cisinlabs.com", "Payment Status - theNewEdu.co", $strData, $headers);


        if ($_POST['payment_status'] == 'Completed') {
            $model = new Payment;
            $model->payment_productID = $_POST['item_number'];
            $model->payment_buyersID = $_POST['custom'];
            $model->payment_amount = $_POST['mc_gross'];
            $model->payment_payer_id = $_POST['payer_id'];
            $model->payment_payer_email = $_POST['payer_email'];
            $model->payment_date = $_POST['payment_date'];
            $model->payment_gateway = '1';
            $model->payment_type = '1';

            $model->payment_status = $_POST['payment_status'];
            //$model->payment_status = 'Completed'; //Change This line when it is live

            $max = Payment::model()->findByAttributes(array(
                'payment_status' => 'Completed',
                    ), array(
                'order' => 'payment_invoiceno DESC'
                    )
            );

            if ($max->payment_invoiceno == 0) {
                $num = 1001;
            } else {
                $num = $max->payment_invoiceno + 1;
            }
            $model->payment_invoiceno = $num;

            $model->payment_transaction_id = $_POST['txn_id'];
            $model->save();
        } else if ($_POST['payment_status'] == 'Refunded') {

            $r = Payment::model()->findByAttributes(array('payment_productID' => $_POST['item_number'], 'payment_buyersID' => $_POST['custom'], 'payment_type' => 1));

            $original_amount = $r->payment_amount;
            $refunded_amount = $_POST['mc_gross'];
            $refund = $original_amount + $refunded_amount;

            $model = new Payment;
            $model->payment_productID = $_POST['item_number'];
            $model->payment_buyersID = $_POST['custom'];
            $model->payment_amount = -($refunded_amount);
            $model->payment_payer_id = $_POST['payer_id'];
            $model->payment_payer_email = $_POST['payer_email'];
            $model->payment_date = $_POST['payment_date'];
            $model->payment_gateway = '1';
            $model->payment_type = '0';
            $model->payment_refund = $refund;
            $model->payment_refund_invoiceno = $r->payment_invoiceno;
            //$model->payment_remark = 'Frakt återbetalning';
            $model->payment_remark = isset($_POST['memo']) ? $_POST['memo'] : '';

            $model->payment_status = $_POST['payment_status'];

            $max = Payment::model()->findByAttributes(array(), array('order' => 'payment_invoiceno DESC'));

            if ($max->payment_invoiceno == 0) {
                $num = 1001;
            } else {
                $num = $max->payment_invoiceno + 1;
            }
            $model->payment_invoiceno = $num;

            $model->payment_transaction_id = $_POST['txn_id'];
            $model->save();
        }


        //if ($model->save()) {
        //mail("aman.r@cisinlabs.com", "on_save...", $data, $headers);
        //} else {
        //mail("aman.r@cisinlabs.com", "on_error...", $data, $headers);
        //}
    }

    /*
     * Function for cancel url
     */

    public function actionCancel() {
        Yii::app()->user->setFlash('type', 'danger');
        Yii::app()->user->setFlash('message', 'Transaktionen är nu avbruten.');
        $this->redirect(array('site/summary'));
    }

}
