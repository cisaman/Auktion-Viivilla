<?php

class ProductController extends Controller {

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
                'actions' => array('index', 'create', 'update', 'delete', 'upload', 'getimages', 'storeimages', 'del_temp_img', 'copy', 'view', 'biddinghistory', 'forwardMail', 'show', 'transactionHistory', 'refund', 'paymentDetails', 'ongoingAuctions', 'closedAuctions', 'paidAuctions', 'unpaidAuctions', 'allAuctions', 'order', 'typehead'),
                'users' => array('Administrator'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'create', 'update', 'delete', 'upload', 'getimages', 'storeimages', 'del_temp_img', 'copy', 'view', 'order'),
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
        $model = new Product;

        $this->performAjaxValidation($model);

        if (isset($_POST['Product'])) {

            $model->product_publish_unpublish = 0;
            if ($_POST['btnPublish'] == 'Publish') {
                $model->product_publish_unpublish = 1;
            }

            $model->attributes = $_POST['Product'];
            $model->product_description = $_POST['Product']['product_description'];
            $model->product_categoryID = implode(',', $_POST['Product']['product_categoryID']);
            //$model->product_sellersID = $_POST['Product']['product_sellersID'];
            $model->product_sellersID = $_POST['sellerid'];
            $model->product_temp_current_price = $model->product_current_price;

            if (isset($_POST['gallery']) && !empty($_POST['gallery'])) {
                $gallery = $_POST['gallery'];
                $model->product_attachments = implode(',', $gallery);
            }

            $product_featuredimage = CUploadedFile::getInstance($model, 'product_featuredimage');
            $random_name = rand(1111, 9999) . date('Ymdhi');

            if (!empty($product_featuredimage)) {

                $extension = strtolower($product_featuredimage->getExtensionName());
                $filename = "{$random_name}.{$extension}";
                $model->product_featuredimage = $filename;
                $product_featuredimage->saveAs(Utils::ProductImageBasePath() . $filename);

                /* ------ Create Image Thumbnail Start ----- */
                $temp_path = Utils::ProductImageBasePath() . $filename;
                $img_thumbnail_path = Utils::ProductImageThumbnailBasePath() . $filename;

                $this->CreateThumbForImages(305, 210, $temp_path, $img_thumbnail_path);
                /* ------ Create Image Thumbnail End ----- */
            }

            //print_r($model->attributes);die;

            if ($model->save()) {

                if (isset($_POST['remgallery'])) {
                    $remgallery = $_POST['remgallery'];
                }

                if (!empty($remgallery)) {
                    foreach ($remgallery as $filename) {
                        $this->actionDel_temp_img($filename);
                    }
                }

                if (count($gallery) > 0) {
                    foreach ($gallery as $filename) {
                        //rename(Utils::ProductImageTempBasePath() . $filename, Utils::ProductImageBasePath() . $filename);
                        $this->CreateThumbForImages(640, 488, Utils::ProductImageTempBasePath() . $filename, Utils::ProductImageBasePath() . $filename);

                        /* ------ Create Image Thumbnail Start ----- */
                        $name_array = explode(".", strtolower($filename));
                        $count = count($name_array);
                        $extension = $name_array[$count - 1];

                        $temp_path = Utils::ProductImageBasePath() . $filename;
                        $img_thumbnail_path = Utils::ProductImageThumbnailBasePath() . $filename;

                        $this->CreateThumbForImages(100, 67, $temp_path, $img_thumbnail_path);
                        /* ------ Create Image Thumbnail End ----- */
                    }
                }


                Yii::app()->user->setFlash('flag', '1');
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', 'Product created successfully.');
                $this->redirect(array('/product/update/' . $model->product_id));
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', 'Operation Failed due to lack of connectivity.');
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }


            //$this->redirect(array('/product/update/' . $model->product_id . '/' . strtolower(str_replace(' ', '-', $model->product_name))));
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

        $gallery = array();
        $remgallery = array();

        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];

            if (isset($_POST['btnPublish'])) {
                $model->product_status = 1;
            } else if (isset($_POST['btnPublish'])) {
                $model->product_status = 0;
            } else {
                $model->product_status = 0;
            }


            $old_data = $model->product_description;
            $new_data = $_POST['Product']['product_description'];

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
                }
            }

            $model->product_description = $new_data;

            $model->product_categoryID = implode(',', $_POST['Product']['product_categoryID']);
            //$model->product_status = $_POST['Product']['product_status'];
            //$model->product_sellersID = $_POST['Product']['product_sellersID'];
            $model->product_sellersID = $_POST['sellerid'];
            //$model->product_temp_current_price = $model->product_current_price;

            if (isset($_POST['gallery']) && !empty($_POST['gallery'])) {
                $gallery = $_POST['gallery'];
                $model->product_attachments = implode(',', $gallery);
            }

            $product_featuredimage = CUploadedFile::getInstance($model, 'product_featuredimage');
            $random_name = rand(1111, 9999) . date('Ymdhi');

            if (!empty($product_featuredimage)) {

                $extension = strtolower($product_featuredimage->getExtensionName());
                $filename = "{$random_name}.{$extension}";
                $model->product_featuredimage = $filename;
                $product_featuredimage->saveAs(Utils::ProductImageBasePath() . $filename);

                /* ------ Create Image Thumbnail Start ----- */
                $temp_path = Utils::ProductImageBasePath() . $filename;
                $img_thumbnail_path = Utils::ProductImageThumbnailBasePath() . $filename;

                $this->CreateThumbForImages(305, 210, $temp_path, $img_thumbnail_path);
                /* ------ Create Image Thumbnail End ----- */
            }

//            print_r($model->attributes);
//            die;

            if ($model->save()) {

                if (isset($_POST['gallery'])) {
                    $gallery = $_POST['gallery'];
                }

                if (isset($_POST['remgallery'])) {
                    $remgallery = $_POST['remgallery'];
                }

                if (!empty($remgallery)) {
                    foreach ($remgallery as $filename) {
                        $this->actionDel_temp_img($filename);
                    }
                }

                if (count($gallery) > 0) {
                    foreach ($gallery as $filename) {
                        if (file_exists(Utils::ProductImageTempBasePath() . $filename)) {
                            //rename(Utils::ProductImageTempBasePath() . $filename, Utils::ProductImageBasePath() . $filename);
                            $this->CreateThumbForImages(640, 488, Utils::ProductImageTempBasePath() . $filename, Utils::ProductImageBasePath() . $filename);

                            /* ------ Create Image Thumbnail Start ----- */
                            $name_array = explode(".", strtolower($filename));
                            $count = count($name_array);
                            $extension = $name_array[$count - 1];

                            $temp_path = Utils::ProductImageBasePath() . $filename;
                            $img_thumbnail_path = Utils::ProductImageThumbnailBasePath() . $filename;

                            $this->CreateThumbForImages(100, 67, $temp_path, $img_thumbnail_path);
                            /* ------ Create Image Thumbnail End ----- */
                        }
                    }
                }

                Yii::app()->user->setFlash('type', 'success');
                if (isset($_POST['btnPublish'])) {
                    Yii::app()->user->setFlash('message', 'Product published successfully.');
                } else if (isset($_POST['btnPublish'])) {
                    Yii::app()->user->setFlash('message', 'Product unpublished successfully.');
                } else {
                    Yii::app()->user->setFlash('message', 'Product unpublished successfully.');
                }
            } else {
                Yii::app()->user->setFlash('type', 'danger');
                Yii::app()->user->setFlash('message', 'Operation Failed due to lack of connectivity.');
            }
            //print_r($model->getErrors());die;
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

        $old_data = $model->product_description;

        if (!empty($old_data)) {
            $doc = new DOMDocument();
            $doc->loadHTML($old_data);
            $xml = simplexml_import_dom($doc);
            $images = $xml->xpath('//img');

            foreach ($images as $img) {
                $src = $img['src'];
                $array = pathinfo($src);
                $file = $array['basename'];

                $src = Yii::app()->basePath . '/../bootstrap/ckeditor/upload_dir/' . $file;
                if (file_exists($src)) {
                    unlink($src);
                }
            }
        }

        if (!empty($model->product_attachments)) {
            $gallery = explode(',', $model->product_attachments);
            foreach ($gallery as $filename) {
                $this->actionDel_temp_img($filename);
            }
        }

        if ($model->delete()) {
            if (!isset($_GET['ajax'])) {
                Yii::app()->user->setFlash('type', 'success');
                Yii::app()->user->setFlash('message', Yii::t('lang', 'product') . ' ' . Yii::t('lang', 'msg_delete'));
            } else {
                echo '<div class="alert alert-success alert-dismissable" id="successmsg">' . Yii::t('lang', 'product') . ' ' . Yii::t('lang', 'msg_delete') . '</div>';
            }
        }

//        if (!isset($_GET['ajax'])) {
//            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
//        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Product('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ajax'])) {
            $model->attributes = $_GET['Product'];

            $this->renderPartial('index', array(
                'model' => $model,
            ));
        } else {
            $this->render('index', array(
                'model' => $model,
            ));
        }
    }

    public function actionShow($id) {
        $model = new Product();
        $model->unsetAttributes();
        if (isset($_GET['Product'])) {
            $model->attributes = $_GET['Product'];
        }

        $this->render('seller_products', array(
            'model' => $model,
            'sellers_id' => $id,
            'sellers_name' => Sellers::model()->getSellersFullName($id)
        ));
    }

    public function loadModel($id) {
        $model = Product::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUpload() {
        $rnd = rand(1111, 9999) . date('Ymdhi');
        $userfile_extn = explode(".", strtolower($_FILES['file']['name']));
        $count = count($userfile_extn);
        $fileName = $rnd . "." . $userfile_extn[$count - 1];

        if (move_uploaded_file($_FILES['file']["tmp_name"], Utils::ProductImageTempBasePath() . $fileName)) {
            echo json_encode(array('fname' => $fileName));
        } else {
            echo "1";
        }
    }

    public function actionGetimages($id) {
        $product_id = $id;

        $result = Product::model()->findByPk($product_id)->product_attachments;

        if ($result != '') {
            $data = explode(',', $result);
            foreach ($data as $d) {
                //$path = Yii::app()->basePath . "/../bootstrap/uploads/product/" . $d;
                $path = Utils::ProductImageBasePath() . $d;
                $obj['name'] = $d;
                $obj['size'] = filesize($path);
                $attachments[] = $obj;
            }
        }

        header('Content-type: text/json');
        header('Content-type: application/json');
        echo json_encode($attachments);
    }

    public function actionDel_temp_img($image) {
        if (file_exists(Utils::ProductImageTempBasePath() . $image)) {
            unlink(Utils::ProductImageTempBasePath() . $image);
        }

        if (file_exists(Utils::ProductImageBasePath() . $image)) {
            unlink(Utils::ProductImageBasePath() . $image);
        }

        if (file_exists(Utils::ProductImageThumbnailBasePath() . $image)) {
            unlink(Utils::ProductImageThumbnailBasePath() . $image);
        }
    }

    public function actionCopy($id) {

        $model = $this->loadModel($id);
        $model->product_id = null;
        $gallery = explode(",", $model->product_attachments);
        $new_gallery = array();
        foreach ($gallery as $row) {
            $new_name = date("Y-m-d-h-i-s") . "_" . $row;
            $file = Utils::ProductImageBasePath() . $row;
            $newfile = Utils::ProductImageBasePath() . $new_name;
            $filethumb = Utils::ProductImageThumbnailBasePath() . $row;
            $newthumb = Utils::ProductImageThumbnailBasePath() . $new_name;

            if (!copy($file, $newfile)) {
                echo "failed to copy file";
            }
            if (!copy($filethumb, $newthumb)) {
                echo "failed to copy thumb file";
            }
            $new_gallery[] = $new_name;
        }
        $model->product_attachments = implode($new_gallery, ",");
        $model->product_copy = $model->product_copy + 1;
        $model->product_temp_current_price = 0;
        //$model->product_bid_diff_price = 0;

        $model->isNewRecord = true;
        if ($model->save()) {
            $this->redirect(array("product/index"));
        }
    }

    public function actionBiddingHistory() {

        $history_id = isset($_REQUEST['history_id']) ? trim($_REQUEST['history_id']) : 1;

        $fun_id = $history_id;
        $history_type = Bid::model()->AdminGetFunctionType($fun_id);

        $limit = 5;
        $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
        $sort_by = isset($_REQUEST['sort_by']) ? trim($_REQUEST['sort_by']) : "value";
        $order_by = isset($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : "ASC";
        $offset = ($page - 1) * $limit;

        switch ($fun_id) {
            case 1:
                //Ongoing Auctions
                $result = Bid::model()->OngoingAuction($offset, $limit);
                $total = Bid::model()->OngoingAuctionCount();

                break;
            case 2:
                //Closed Auctions
                $result = Bid::model()->ClosedAuction($offset, $limit);
                $total = Bid::model()->ClosedAuctionCount();

                break;
            case 3:
                //Paid Auctions
                //$result = Bid::model()->PaidAuction($offset, $limit);
                //$total = Bid::model()->PaidAuctionCount();

                $r = Bid::getPaidUnpaidStatusOfAuction($offset, $limit);
                $total = count($r['total_paid']);
                $result = $r['product_array'];
                // echo count($result);
                // echo '<br/>';
                // echo $total;

                break;
            case 4:
                //Unpaid Auctions
                // $result = Bid::model()->UnpaidAuction($offset, $limit);
                // $total = Bid::model()->UnpaidAuctionCount();
                $r = Bid::getPaidUnpaidStatusOfAuction($offset, $limit);
                $total = count($r['total_unpaid']);
                $result = $r['product_array'];
                // echo count($result);
                // echo '<br/>';
                // echo $total;

                break;

            case 5:
                //All Auctions
                $result = Bid::model()->AllAuction($offset, $limit);
                $total = Bid::model()->AllAuctionCount();

                break;
            default :

                $result = Bid::model()->AllAuction($offset, $limit);
                $total = Bid::model()->AllAuctionCount();

                break;
        }

        $all = $result;

        $pages = new CPagination($total);
        $pages->setPageSize($limit);

        if (isset($_REQUEST['by'])) {
            $this->renderPartial('biddingHistory', array(
                'result' => $all,
                'history_id' => $fun_id,
                'history_type' => $history_type,
                'pages' => $pages,
                'number' => $offset + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        } else {
            $this->render('biddingHistory', array(
                'result' => $all,
                'history_id' => $fun_id,
                'history_type' => $history_type,
                'pages' => $pages,
                'number' => $offset + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        }
    }

    public function actionOngoingAuctions() {

        $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
        $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
        $sort_by = isset($_REQUEST['sort_by']) ? trim($_REQUEST['sort_by']) : "value";
        $order_by = isset($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : "ASC";
        $offset = ($page - 1) * $limit;

        $prod_id = (isset($_GET['prod_id']) && !empty($_GET['prod_id'])) ? $_GET['prod_id'] : '';
        $prod_name = (isset($_GET['prod_name']) && !empty($_GET['prod_name'])) ? $_GET['prod_name'] : '';
        $prod_expiry = (isset($_GET['prod_expiry']) && !empty($_GET['prod_expiry'])) ? $_GET['prod_expiry'] : '';
        $prod_sellers = (isset($_GET['sellers_id']) && !empty($_GET['sellers_id'])) ? $_GET['sellers_id'] : '';
        $search = array('p_id' => $prod_id, 'p_name' => $prod_name, 'p_expiry' => $prod_expiry, 'sellers_id' => $prod_sellers);

        $result = Bid::model()->OngoingAuction($offset, $limit, $search);
        $total = Bid::model()->OngoingAuctionCount($search);

        $pages = new CPagination($total);
        $pages->setPageSize($limit);

        if (isset($_REQUEST['by'])) {
            $this->renderPartial('ongoing_history', array(
                'result' => $result,
                'pages' => $pages,
                'number' => $offset + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        } else {
            $this->render('ongoing_history', array(
                'result' => $result,
                'pages' => $pages,
                'number' => $offset + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        }
    }

    public function actionClosedAuctions() {

        $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
        $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
        $sort_by = isset($_REQUEST['sort_by']) ? trim($_REQUEST['sort_by']) : "value";
        $order_by = isset($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : "ASC";
        $offset = ($page - 1) * $limit;

        $prod_id = (isset($_GET['prod_id']) && !empty($_GET['prod_id'])) ? $_GET['prod_id'] : '';
        $prod_name = (isset($_GET['prod_name']) && !empty($_GET['prod_name'])) ? $_GET['prod_name'] : '';
        $prod_expiry = (isset($_GET['prod_expiry']) && !empty($_GET['prod_expiry'])) ? $_GET['prod_expiry'] : '';
        $prod_sellers = (isset($_GET['sellers_id']) && !empty($_GET['sellers_id'])) ? $_GET['sellers_id'] : '';
        $search = array('p_id' => $prod_id, 'p_name' => $prod_name, 'p_expiry' => $prod_expiry, 'sellers_id' => $prod_sellers);

        $result = Bid::model()->ClosedAuction($offset, $limit, $search);
        $total = Bid::model()->ClosedAuctionCount($search);

        $pages = new CPagination($total);
        $pages->setPageSize($limit);

        if (isset($_REQUEST['by'])) {
            $this->renderPartial('closed_history', array(
                'result' => $result,
                'pages' => $pages,
                'number' => $offset + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        } else {
            $this->render('closed_history', array(
                'result' => $result,
                'pages' => $pages,
                'number' => $offset + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        }
    }

    public function actionPaidAuctions() {

        $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
        $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
        $sort_by = isset($_REQUEST['sort_by']) ? trim($_REQUEST['sort_by']) : "value";
        $order_by = isset($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : "ASC";
        $offset = ($page - 1) * $limit;

        $prod_id = (isset($_GET['prod_id']) && !empty($_GET['prod_id'])) ? $_GET['prod_id'] : '';
        $prod_name = (isset($_GET['prod_name']) && !empty($_GET['prod_name'])) ? $_GET['prod_name'] : '';
        $prod_expiry = (isset($_GET['prod_expiry']) && !empty($_GET['prod_expiry'])) ? $_GET['prod_expiry'] : '';
        $prod_sellers = (isset($_GET['sellers_id']) && !empty($_GET['sellers_id'])) ? $_GET['sellers_id'] : '';
        $search = array('p_id' => $prod_id, 'p_name' => $prod_name, 'p_expiry' => $prod_expiry, 'sellers_id' => $prod_sellers);

        $r = Bid::getPaidUnpaidStatusOfAuction($offset, $limit, $search);
        $total = $r['total_paid'];
        $result = $r['product_array_paid'];

        $pages = new CPagination($total);
        $pages->setPageSize($limit);

        if (isset($_REQUEST['by'])) {
            $this->renderPartial('paid_history', array(
                'result' => $result,
                'pages' => $pages,
                'number' => $offset + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        } else {
            $this->render('paid_history', array(
                'result' => $result,
                'pages' => $pages,
                'number' => $offset + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        }
    }

    public function actionUnpaidAuctions() {

        $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
        $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
        $sort_by = isset($_REQUEST['sort_by']) ? trim($_REQUEST['sort_by']) : "value";
        $order_by = isset($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : "ASC";
        $offset = ($page - 1) * $limit;

        $prod_id = (isset($_GET['prod_id']) && !empty($_GET['prod_id'])) ? $_GET['prod_id'] : '';
        $prod_name = (isset($_GET['prod_name']) && !empty($_GET['prod_name'])) ? $_GET['prod_name'] : '';
        $prod_expiry = (isset($_GET['prod_expiry']) && !empty($_GET['prod_expiry'])) ? $_GET['prod_expiry'] : '';
        $prod_sellers = (isset($_GET['sellers_id']) && !empty($_GET['sellers_id'])) ? $_GET['sellers_id'] : '';
        $search = array('p_id' => $prod_id, 'p_name' => $prod_name, 'p_expiry' => $prod_expiry, 'sellers_id' => $prod_sellers);

        $r = Bid::getPaidUnpaidStatusOfAuction($offset, $limit, $search);
        $total = $r['total_unpaid'];
        $result = $r['product_array_unpaid'];

        $pages = new CPagination($total);
        $pages->setPageSize($limit);

        if (isset($_REQUEST['by'])) {
            $this->renderPartial('unpaid_history', array(
                'result' => $result,
                'pages' => $pages,
                'number' => $offset + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        } else {
            $this->render('unpaid_history', array(
                'result' => $result,
                'pages' => $pages,
                'number' => $offset + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        }
    }

    public function actionAllAuctions() {

        $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
        $page = isset($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
        $sort_by = isset($_REQUEST['sort_by']) ? trim($_REQUEST['sort_by']) : "value";
        $order_by = isset($_REQUEST['order_by']) ? trim($_REQUEST['order_by']) : "ASC";
        $offset = ($page - 1) * $limit;

        $prod_id = (isset($_GET['prod_id']) && !empty($_GET['prod_id'])) ? $_GET['prod_id'] : '';
        $prod_name = (isset($_GET['prod_name']) && !empty($_GET['prod_name'])) ? $_GET['prod_name'] : '';
        $prod_expiry = (isset($_GET['prod_expiry']) && !empty($_GET['prod_expiry'])) ? $_GET['prod_expiry'] : '';
        $prod_sellers = (isset($_GET['sellers_id']) && !empty($_GET['sellers_id'])) ? $_GET['sellers_id'] : '';
        $search = array('p_id' => $prod_id, 'p_name' => $prod_name, 'p_expiry' => $prod_expiry, 'sellers_id' => $prod_sellers);

        $r = Bid::getPaidUnpaidStatusOfAuctionFORALL($offset, $limit, $search);
        $total = $r['total_unpaid'] + $r['total_paid'] + $r['totals'];
        $result = $r['product_array_total'];

        $pages = new CPagination($total);
        $pages->setPageSize($limit);

        if (isset($_REQUEST['by'])) {
            $this->renderPartial('all_history', array(
                'result' => $result,
                'pages' => $pages,
                'number' => $offset + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        } else {
            $this->render('all_history', array(
                'result' => $result,
                'pages' => $pages,
                'number' => $offset + 1,
                'sort_by' => $sort_by,
                'order_by' => $order_by,
            ));
        }
    }

    public function actionForwardMail() {
        $path = Yii::app()->params['site_url'];

        $template = Template::model()->findByAttributes(array('template_alias' => 'notification_mail_for_payment'));
        $subject = $template->template_subject;
        $message = $template->template_content;

        $to = $_GET['u_email'];
        //$to = 'aman66@mailinator.com';

        $userdata['product_code'] = $_GET['p_id'];
        $userdata['product_name'] = Product::model()->getProductName($_GET['p_id']);
        $userdata['product_link'] = $_GET['p_url'];
        $userdata['winner_status'] = $_GET['u_status'];
        $userdata['username'] = $_GET['u_name'];
        $userdata['amount'] = $_GET['amt'];

        $subject = $this->replace($userdata, $subject);
        $message = $this->replace($userdata, $message);

        if ($this->Send($to, $userdata['username'], $subject, $message)) {
            echo 1;

            $getID = Buyers::model()->findByAttributes(array('buyers_email' => $to))->buyers_id;

            $logdata['title'] = 'Notification Mail Sent';
            $logdata['userid'] = $getID;
            $logdata['productid'] = $userdata['product_code'];
            $logdata['message'] = $message;
            Log::createLog($logdata);
        } else {
            echo 0;
        }
    }

    public function actionTransactionHistory() {
        $model = new Payment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ajax'])) {
            $model->attributes = $_GET['Payment'];

            $this->renderPartial('transactionHistory', array(
                'model' => $model
            ));
        } else {
            $this->render('transactionHistory', array(
                'model' => $model
            ));
        }
    }

    public function actionRefund($id) {
        $amount = $_POST['amount'];
        $remark = !empty($_POST['message']) ? $_POST['message'] : '';

        $model = Payment::model()->findByPk($id);
        $model->payment_id = null;

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
        $model->payment_type = 0;
        $model->payment_refund = $amount;
        $model->payment_remark = $remark;
        $model->payment_refunddate = date('Y-m-d h:i:s');

        $model->isNewRecord = true;
        if ($model->save()) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function actionPaymentDetails($id) {
        $model = Payment::model()->findByPk($id);

        $this->render('payment-details', array(
            'model' => $model
        ));
    }

    public function actionOrder($id) {

        $winnerbid = $_POST['winnerbid'];
        $fee = $_POST['fee'];
        $shipping1 = $_POST['shipping1'];
        $shipping2 = $_POST['shipping2'];
        $remarks = $_POST['remarks'];

        $payment = Payment::model()->findByPk($id);
        $buyer = Buyers::model()->findByPk($payment->payment_buyersID);
        $product = Product::model()->findByPk($payment->payment_productID);
        $seller = Sellers::model()->findByPk($product->product_sellersID);

        $path = Yii::app()->params['site_url'];
        $to_product_id = $product->product_id;

        //For Buyer's Order Mail
        $template_buyer = Template::model()->findByAttributes(array('template_alias' => 'order_mail_for_buyer_template'));
        $subject_buyer = $template_buyer->template_subject;
        $message_buyer = $template_buyer->template_content;

        $to_buyer = $buyer->buyers_email;
        $to_buyer_id = $buyer->buyers_id;
        $to_buyer_username = $buyer->buyers_fname . ' ' . $buyer->buyers_lname;
        //$to = 'aman66@mailinator.com';
        $product_link = $path . '/auktion/' . $product->product_id . '/' . Product::createSlug($product->product_name);

        $buyerdata['buyer_firstname'] = $buyer->buyers_fname;
        $buyerdata['buyer_lastname'] = $buyer->buyers_lname;
        $buyerdata['buyer_email'] = $buyer->buyers_email;
        $buyerdata['buyer_contactno'] = $buyer->buyers_contactno;
        $buyerdata['buyer_address'] = $buyer->buyers_address . '-' . $buyer->buyers_zipcode . ', ' . $buyer->buyers_city . ', ' . $buyer->buyers_country;
        $buyerdata['product_id'] = $product->product_id;
        $buyerdata['product_name'] = $product->product_name;
        $buyerdata['product_link'] = $product_link;
        $buyerdata['winner_number'] = Bid::showWinnersWithPriceOfBuyers($product->product_id, $buyer->buyers_id);
        $buyerdata['seller_company'] = $seller->sellers_username;
        $buyerdata['seller_vatno'] = $seller->sellers_vatno != '' ? $seller->sellers_vatno : '-';
        $buyerdata['seller_address'] = $seller->sellers_address;
        $buyerdata['seller_zipcode'] = $seller->sellers_zipcode;
        $buyerdata['seller_city'] = $seller->sellers_city;
        $buyerdata['seller_country'] = $seller->sellers_country;
        $buyerdata['seller_firstname'] = $seller->sellers_fname;
        $buyerdata['seller_lastname'] = $seller->sellers_lname;
        $buyerdata['seller_email'] = $seller->sellers_email;
        $buyerdata['seller_contactno'] = $seller->sellers_contactno == 0 ? '' : $seller->sellers_contactno;
        $buyerdata['seller_website'] = $seller->sellers_website;

        $subject_buyer = $this->replace($buyerdata, $subject_buyer);
        $message_buyer = $this->replace($buyerdata, $message_buyer);
        $message_buyer = preg_replace("/\r|\n/", "", $message_buyer);
        $message_buyer = preg_replace('/\s+/', ' ', $message_buyer);

        $message_buyer = str_replace('<tr> <td><span style="font-size:14px">Telefonnummer</span></td> <td><span style="font-size:14px"></span></td> </tr>', '', $message_buyer);
        $message_buyer = str_replace('<tr> <td><span style="font-size:14px">hemsida</span></td> <td><span style="font-size:14px"></span></td> </tr>', '', $message_buyer);
        unset($buyerdata);

        //For Seller's Order Mail
        $template_seller = Template::model()->findByAttributes(array('template_alias' => 'order_mail_for_seller_part_1_-_template'));
        $subject_seller = $template_seller->template_subject;
        $message_seller = $template_seller->template_content;


        $to_seller = $seller->sellers_email;
        $to_seller_id = $seller->sellers_id;
        $to_seller_username = $seller->sellers_fname . ' ' . $seller->sellers_lname;
        //$to = 'aman66@mailinator.com';

        $sellerdata['buyer_firstname'] = $buyer->buyers_fname;
        $sellerdata['buyer_lastname'] = $buyer->buyers_lname;
        $sellerdata['buyer_email'] = $buyer->buyers_email;
        $sellerdata['buyer_contactno'] = $buyer->buyers_contactno;
        $sellerdata['buyer_address'] = $buyer->buyers_address . '-' . $buyer->buyers_zipcode . ', ' . $buyer->buyers_city . ', ' . $buyer->buyers_country;
        $sellerdata['product_id'] = $product->product_id;
        $sellerdata['product_name'] = $product->product_name;
        $sellerdata['product_link'] = $product_link;
        $sellerdata['winner_number'] = Bid::showWinnersWithPriceOfBuyers($product->product_id, $buyer->buyers_id);
        $sellerdata['seller_firstname'] = $seller->sellers_fname;
        $sellerdata['seller_lastname'] = $seller->sellers_lname;
        $sellerdata['remark_message'] = !empty($remarks) ? $remarks : '';
        $sellerdata['shipping_message'] = ($shipping2 == 'true') ? 'Obs, kom ihåg att fakturera kunden för frakten.' : '';

        $sellerdata['other_message'] = '';

        if ($winnerbid == 'true' || $fee == 'true' || $shipping1 == 'true') {
            $template_seller_2 = Template::model()->findByAttributes(array('template_alias' => 'order_mail_for_seller_part_2_-_template'));
            $message_seller_2 = $template_seller_2->template_content;

            $sellerdata_2['winner_number'] = '';
            if ($winnerbid == 'true') {
                $sellerdata_2['winner_number'] = ($payment->payment_amount - $product->product_shipping_price) . ' Kr';
            }

            $sellerdata_2['shipping_amount'] = '';
            if ($shipping1 == 'true') {
                $sellerdata_2['shipping_amount'] = $product->product_shipping_price . ' Kr';
            }

            $sellerdata_2['amount_with_fee'] = '';
            $sellerdata_2['total_amount'] = '';
            if ($fee == 'true') {
                if ($shipping1 == 'true') {
                    $sellerdata_2['amount_with_fee'] = '- ' . ($payment->payment_amount * 0.05) . ' Kr';
                    $sellerdata_2['total_amount'] = (($payment->payment_amount) - ($payment->payment_amount * 0.05)) . ' Kr';
                } else {
                    $sellerdata_2['amount_with_fee'] = '- ' . (($payment->payment_amount - $product->product_shipping_price) * 0.05) . ' Kr';
                    $sellerdata_2['total_amount'] = (($payment->payment_amount - $product->product_shipping_price) - (($payment->payment_amount - $product->product_shipping_price) * 0.05)) . ' Kr';
                }
            } else {
                if ($shipping1 == 'true') {
                    if ($winnerbid == 'true') {
                        $sellerdata_2['total_amount'] = ($payment->payment_amount) . ' Kr';
                    } else {
                        $sellerdata_2['total_amount'] = ($product->product_shipping_price) . ' Kr';
                    }
                } else {
                    $sellerdata_2['total_amount'] = ($payment->payment_amount - $product->product_shipping_price) . ' Kr';
                }
            }

            $message_seller_2 = $this->replace($sellerdata_2, $message_seller_2);
            $message_seller_2 = preg_replace("/\r|\n/", "", $message_seller_2);
            $message_seller_2 = preg_replace('/\s+/', ' ', $message_seller_2);

            $message_seller_2 = str_replace('<tr> <td><span style="font-size:14px">Vinnarbud ink moms</span></td> <td><span style="font-size:14px"></span></td> </tr>', '', $message_seller_2);
            $message_seller_2 = str_replace('<tr> <td><span style="font-size:14px">Frakt ink moms</span></td> <td><span style="font-size:14px"></span></td> </tr>', '', $message_seller_2);
            $message_seller_2 = str_replace('<tr> <td><span style="font-size:14px">Adm. Avgift 5%</span></td> <td><span style="font-size:14px"></span></td> </tr>', '', $message_seller_2);
            $message_seller_2 = str_replace('<tr> <td><span style="font-size:14px">Total</span></td> <td><span style="font-size:14px"></span></td> </tr>', '', $message_seller_2);
            $message_seller_2 = str_replace('<tr> <td><span style="font-size:14px">Att fakturera ink moms</span></td> <td><span style="font-size:14px"></span></td> </tr>', '', $message_seller_2);
            unset($sellerdata_2);

            $sellerdata['other_message'] = $message_seller_2;
        }


        $subject_seller = $this->replace($sellerdata, $subject_seller);
        $message_seller = $this->replace($sellerdata, $message_seller);
        $message_seller = preg_replace("/\r|\n/", "", $message_seller);
        $message_seller = preg_replace('/\s+/', ' ', $message_seller);

        //print_r($message_seller);
        unset($sellerdata);

        $message_seller = str_replace('<tr> <td><span style="font-size:14px"><strong><span style="color:red">OBS!!</span></strong> &Ouml;vrigt</span></td> <td><span style="font-size:14px"></span></td> </tr>', '', $message_seller);
        $message_seller = str_replace('<tr> <td><span style="font-size:14px">Frakt</span></td> <td><span style="font-size:14px"></span></td> </tr>', '', $message_seller);

        if ($this->Send($to_buyer, $to_buyer_username, $subject_buyer, $message_buyer, 'viivillamail@gmail.com')) {
            //if (1) {

            $logdata['title'] = 'Order Mail Sent to Buyer';
            $logdata['userid'] = $to_buyer_id;
            $logdata['usertype'] = 3;
            $logdata['productid'] = $to_product_id;
            $logdata['message'] = $message_buyer;
            Log::createLog($logdata);
            unset($logdata);

            if ($this->Send($to_seller, $to_seller_username, $subject_seller, $message_seller, 'viivillamail@gmail.com')) {
                //if (1) {

                $logdata['title'] = 'Order Mail Sent to Seller';
                $logdata['userid'] = $to_seller_id;
                $logdata['usertype'] = 2;
                $logdata['productid'] = $to_product_id;
                $logdata['message'] = $message_seller;
                Log::createLog($logdata);
                unset($logdata);

                $updateOrderInformation = Payment::model()->findByPk($payment->payment_id);
                $updateOrderInformation->payment_orderstatus = 1;
                $updateOrderInformation->payment_orderdatetime = date('Y-m-d H:i:s');
                if ($updateOrderInformation->update()) {
                    echo 1;
                } else {
                    echo 0;
                }
            }
        } else {
            echo 0;
        }
    }

    public function actionTypehead() {
        $this->render('demo');
    }

}
