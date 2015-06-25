<?php

/**
 * This is the model class for table "{{product}}".
 *
 * The followings are the available columns in table '{{product}}':
 * @property integer $product_id
 * @property string $product_name
 * @property string $product_description
 * @property string $product_categoryID
 * @property double $product_reserve_price
 * @property double $product_current_price
 * @property double $product_shipping_price
 * @property double $product_buynow_price
 * @property double $product_bid_diff_price
 * @property integer $product_winners
 * @property string $product_expiry_date
 * @property string $product_attachments
 * @property integer $product_sellersID
 * @property integer $product_tax
 * @property integer $product_copy
 * @property string $product_created
 * @property string $product_updated
 * @property integer $product_status
 * @property string  $product_publish_date
 * @property string  $product_publish_unpublish
 *
 * The followings are the available model relations:
 * @property User $productUser
 */
class Product extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{product}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_name, product_sellersID, product_current_price, product_tax, product_bid_diff_price, product_winners, product_expiry_date, product_publish_date', 'required', 'message' => Yii::t('lang', 'please_enter') . ' {attribute}.'),
            array('product_categoryID', 'required', 'message' => Yii::t('lang', 'please_select') . ' {attribute}.'),
            array('product_winners, product_status', 'numerical', 'integerOnly' => true),
            array('product_reserve_price, product_current_price, product_shipping_price, product_buynow_price, product_bid_diff_price', 'numerical'),
            array('product_name', 'length', 'max' => 255),
            array('product_categoryID', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('product_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('product_id, product_name, product_description, product_categoryID, product_reserve_price, product_current_price, product_shipping_price, product_buynow_price, product_bid_diff_price, product_winners, product_expiry_date,product_publish_date, product_attachments, product_sellersID, product_tax, product_created, product_updated, product_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productSellers' => array(self::BELONGS_TO, 'User', 'product_sellersID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'product_id' => 'ID',
            'product_name' => Yii::t('lang', 'product') . ' ' . Yii::t('lang', 'name'),
            'product_description' => Yii::t('lang', 'description'),
            'product_categoryID' => Yii::t('lang', 'category'),
            'product_reserve_price' => Yii::t('lang', 'reserve_price'),
            'product_current_price' => Yii::t('lang', 'start_price'),
            'product_temp_current_price' => Yii::t('lang', 'current_price'),
            'product_shipping_price' => Yii::t('lang', 'shipping_price'),
            'product_buynow_price' => Yii::t('lang', 'buy_now_price'),
            'product_bid_diff_price' => Yii::t('lang', 'bid_diff_price'),
            'product_winners' => Yii::t('lang', 'no_of_winners'),
            'product_expiry_date' => Yii::t('lang', 'expiry') . ' ' . Yii::t('lang', 'date'),
            'product_publish_date' => 'Publish ' . Yii::t('lang', 'date'),
            'product_attachments' => Yii::t('lang', 'gallery_images'),
            'product_sellersID' => Yii::t('lang', 'seller'),
            'product_copy' => Yii::t('lang', 'copy'),
            'product_tax' => Yii::t('lang', 'tax'),
            'product_created' => Yii::t('lang', 'created') . ' ' . Yii::t('lang', 'date'),
            'product_updated' => Yii::t('lang', 'updated') . ' ' . Yii::t('lang', 'date'),
            'product_status' => Yii::t('lang', 'status'),
            'product_featuredimage' => Yii::t('lang', 'featured_image')
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($role_id, $id, $sellers_id) {
        //echo $role_id . '__' . $id . '__' . $sellers_id;        
        $criteria = new CDbCriteria;

        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('product_description', $this->product_description, true);
        $criteria->compare('product_categoryID', $this->product_categoryID, true);
        $criteria->compare('product_reserve_price', $this->product_reserve_price);
        $criteria->compare('product_current_price', $this->product_current_price);
        $criteria->compare('product_shipping_price', $this->product_shipping_price);
        $criteria->compare('product_buynow_price', $this->product_buynow_price);
        $criteria->compare('product_bid_diff_price', $this->product_bid_diff_price);
        $criteria->compare('product_winners', $this->product_winners);
        $criteria->compare('product_expiry_date', $this->product_expiry_date, true);
        $criteria->compare('product_publish_date', $this->product_publish_date, true);
        $criteria->compare('product_attachments', $this->product_attachments, true);
        $criteria->compare('product_copy', $this->product_copy, true);

        $user_id = Yii::app()->session['admin_data']['admin_id'];
        if ($role_id == 1 && $id == 1) {
            $criteria->compare('product_sellersID', $user_id); //Show Admin Products
        } else if ($role_id == 1 && $id == 2) {
            $criteria->compare('product_sellersID!', $user_id);
            $criteria->compare('product_sellersID', $this->product_sellersID); //Show Other Sellers Products
        } else if (!empty($sellers_id)) {
            $criteria->compare('product_sellersID', $sellers_id);
        }

        $criteria->compare('product_tax', $this->product_tax, true);
        $criteria->compare('product_created', $this->product_created, true);
        $criteria->compare('product_updated', $this->product_updated, true);
        $criteria->compare('product_status', $this->product_status);

        $limit = 10;
        if (isset($_GET['limitdata1'])) {
            $limit = $_GET['limitdata1'];
        } else if (isset($_GET['limitdata2'])) {
            $limit = $_GET['limitdata2'];
        } else if (isset($_GET['limitdata3'])) {
            $limit = $_GET['limitdata3'];
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'product_id DESC'
            ),
            'Pagination' => array(
                'PageSize' => $limit
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getProductName($id) {
        $result = Product::model()->findByPk(array('product_id' => $id), array('select' => 'product_name'));
        $name = $result->product_name;
        return $name;
    }

    public static function createSlug($name) {
        //$name = urlencode(strtolower(str_replace(' ', '-', $name)));
        $name = strtolower(str_replace(' ', '-', $name));

        $name = preg_replace('~[^\\pL0-9_]+~u', '-', $name);
        $name = trim($name, "-");
        $search = array('~', '`', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '+', '=', '{', '}', '[', ']', ':', ';', '"', '\'', '<', '>', '?', ',', '.', '/', '|');
        $name = str_replace($search, '', $name);
        //$name = iconv("utf-8", "us-ascii//TRANSLIT", $name);
        //$name = preg_replace('~[^-a-z0-9_]+~', '', $name);

        return $name;
    }

    public function getProducts($order_column, $order, $limit, $offset) {
        $products = Product::model()->findAllByAttributes(
                array('product_status' => 1), array(
            'condition' => 'product_expiry_date >= :date AND product_publish_date <= :date',
            'params' => array('date' => date('Y-m-d H:i:s')),
            'order' => $order_column . ' ' . $order,
            'limit' => $limit,
            'offset' => $offset
                )
        );

        $result = array();

        foreach ($products as $product) {
            if (!empty($product->product_featuredimage)) {
                $image_url = Utils::ProductImageThumbnailPath() . $product->product_featuredimage;
            } else {
                if (!empty($product->product_attachments)) {
                    $images = explode(',', $product->product_attachments);
                    //$index = array_rand($images, 1);
                    $image_url = Utils::ProductImageThumbnailPath() . $images[0];
                } else {
                    $image_url = Utils::GetBaseUrl() . '/bootstrap/site/images/default.jpeg';
                }
            }


            $now = strtotime(date('Y-m-d H:i:s'));
            $exp = strtotime($product->product_expiry_date);
            $diff = $exp - $now;

            $slug = Product::createSlug($product->product_name);

            $result[] = array(
                'p_id' => $product->product_id,
                'p_name' => $product->product_name,
                'p_image' => $image_url,
                'p_price' => $product->product_temp_current_price,
                'p_nextprice' => $product->product_temp_current_price + $product->product_bid_diff_price,
                'p_expiry' => $diff,
                'p_new_expiry' => $exp,
                'p_now' => $now,
                'p_slug' => $slug
            );
        }

        return $result;
    }

    public function getAllProductsOfAuthor($order_column, $order, $limit, $offset, $author_id) {
        $products = Product::model()->findAllByAttributes(
                array(
            'product_status' => 1,
            'product_sellersID' => $author_id
                ), array(
            'condition' => 'product_expiry_date >= :date AND product_publish_date <= :date',
            'params' => array('date' => date('Y-m-d H:i:s')),
            'order' => $order_column . ' ' . $order,
            'limit' => $limit,
            'offset' => $offset
                )
        );

        $result = array();

        foreach ($products as $product) {

            if (!empty($product->product_featuredimage)) {
                $image_url = Utils::ProductImagePath() . $product->product_featuredimage;
            } else {
                if (!empty($product->product_attachments)) {
                    $images = explode(',', $product->product_attachments);
                    //$index = array_rand($images, 1);
                    $image_url = Utils::ProductImagePath() . $images[0];
                } else {
                    $image_url = Utils::GetBaseUrl() . '/bootstrap/site/images/default.jpeg';
                }
            }

            $now = strtotime(date('Y-m-d H:i:s'));
            $exp = strtotime($product->product_expiry_date);
            $diff = $exp - $now;

            $slug = Product::createSlug($product->product_name);

            $result[] = array(
                'p_id' => $product->product_id,
                'p_name' => $product->product_name,
                'p_image' => $image_url,
                'p_price' => $product->product_temp_current_price,
                'p_expiry' => $diff,
                'p_new_expiry' => $exp,
                'p_slug' => $slug
            );
        }

        return $result;
    }

    public function getSingleProduct($id) {
        $product = Product::model()->findByPk($id);
        $sellers = Sellers::model()->findByPk($product->product_sellersID);

        $img_all = array();
        $img_thumb = array();

        /* Get All Image Attachment names into an array */
        $images = explode(',', $product->product_attachments);
        /* Loop start */
        if (!empty($images)) {
            foreach ($images as $img) {
                if ($img != '') {
                    /* Populate Main Image URLs in img_all array */
                    $img_all[] = Utils::ProductImagePath() . $img;
                    /* Populate Thumbnail Image URLs in img_all array */
                    $img_thumb[] = Utils::ProductImageThumbnailPath() . $img;
                }
            }
        }
        /* Loop End */

        /* Get DateTime Difference from Current DateTime */
        $now = strtotime(date('Y-m-d H:i:s'));
        $exp = strtotime($product->product_expiry_date);
        $diff = $exp - $now;

        /* Create Slug for URL */
        $p_slug = Product::createSlug($product->product_name);

        /* User Image for Seller Details */
        if (!empty($sellers->sellers_image)) {
            $sellers_image = Utils::UserThumbnailImagePath() . $sellers->sellers_image;
        } else {
            $sellers_image = Utils::NoImagePath();
        }

        /* User Joined Date for Seller Details */
        $joined = new DateTime($sellers->sellers_created);
        $current = new DateTime();
        $interval = $joined->diff($current);
        $sellers_joined = 'joined ' . (($interval->y != 0) ? $interval->y . ' years, ' : '') . (($interval->m != 0) ? $interval->m . ' months, ' : '') . (($interval->d != 0) ? $interval->d . ' days' : '') . ' ago.';

        /* User Member Since in above format - April 14, 2014 07:21 */
        $datetime = strtotime($sellers->sellers_created);
        $sellers_member_since = date("M j, Y G:i", $datetime);

        /* User Last Login in above format - August 18, 2014 6:00 am */
        //$datetime = strtotime($sellers->sellers_last_login);
        //$user_last_login = date("M j, Y G:ia", $datetime);

        /* Count total Products by the Same User who's Product we are viewing */
        $total_product = Product::model()->count('product_sellersID=' . $sellers->sellers_id);

        /* User Last 5 Products in Product Expiry Date */
        $random_products = $this->getAllProductsOfAuthor('product_expiry_date', 'ASC', 100, 0, $sellers->sellers_id);
        $u_products = array();
        if (!empty($random_products)) {
            $temp = count($random_products);
            if ($temp > 5) {
                $num = 5;
            } else {
                $num = $temp;
            }
            $random_keys = array_rand($random_products, $num);
            for ($i = 0; $i < $num; $i++) {
                $u_products[] = $random_products[$random_keys[$i]];
            }
        }

        if (empty($u_products[0])) {
            $u_products = array();
        }

        /* Create Slug for URL */
        $u_slug = Product::createSlug($sellers->sellers_fname . ' ' . $sellers->sellers_lname);

        /* Business Logic for the Auction Bidding between Product Table and Bid Table */
        $temp_current_price = $product->product_temp_current_price;
        $temp_diff = $product->product_temp_current_price + $product->product_bid_diff_price;
        /* Business Logic for the Auction Bidding between Product Table and Bid Table */


        /* Reserver Price Met Test */
        $max = Bid::model()->findByAttributes(
                array('bid_productID' => $product->product_id), array('order' => 'bid_value DESC', 'limit' => 1,)
        );
        $high_bid = 0;
        if (!empty($max)) {
            $high_bid = $max->bid_value;
        }
        /* Reserver Price Met Test */


        $result = array(
            'p_id' => $product->product_id,
            'p_name' => $product->product_name,
            'p_desc' => $product->product_description,
            'p_images' => $img_all,
            'p_thumbs' => $img_thumb,
            'p_price' => $temp_current_price,
            'p_biddifference' => $product->product_bid_diff_price,
            'p_biddiff' => $temp_diff,
            'p_reserve_price' => $product->product_reserve_price,
            'p_buynow_price' => $product->product_buynow_price,
            'p_shipping_price' => !empty($product->product_shipping_price) ? $product->product_shipping_price : 0,
            'p_expiry' => $diff,
            'p_expiry_date' => $exp,
            'p_now' => $now,
            'p_userid' => $product->product_sellersID,
            'p_slug' => $p_slug,
            'p_winners' => $product->product_winners,
            'p_highbid' => $high_bid,
            'u_id' => Yii::app()->session['user_data']['buyers_id'],
            //    'u_name' => $sellers->sellers_fname . ' ' . $sellers->sellers_lname,          
            'u_name' => $sellers->sellers_username,
            'u_slug' => $u_slug,
            'u_email' => $sellers->sellers_email,
            'u_totalproducts' => $total_product,
            'u_contact' => $sellers->sellers_contactno,
            //'u_summary' => $sellers->sellers_summary,
            'u_member_since' => $sellers_member_since,
            'u_joined' => $sellers_joined,
            //'u_last_login' => $user_last_login,
            'u_image' => $sellers_image,
            'u_products' => $u_products
        );

        return $result;
    }

    public function getAllProductsbyterm($order_column, $order, $limit, $offset, $src) {

        $c = new CDbCriteria();
        // $c->condition = ' product_name LIKE :src AND product_expiry_date >= :date AND product_publish_date <= :date AND product_status=:sts';
        $c->condition = ' product_name LIKE :src  AND product_publish_date <= :date AND product_status=:sts';
        $c->params = array(':src' => "%$src%", 'date' => date('Y-m-d H:i:s'), 'sts' => 1);
        $c->order = $order_column . ' ' . $order;
        $c->limit = $limit;
        $c->offset = $offset;
        $products = Product::model()->findAll($c);
        $result = array();


        foreach ($products as $product) {

            if (!empty($product->product_featuredimage)) {
                $image_url = Utils::ProductImagePath() . $product->product_featuredimage;
            } else {
                if (!empty($product->product_attachments)) {
                    $images = explode(',', $product->product_attachments);
                    //$index = array_rand($images, 1);
                    $image_url = Utils::ProductImagePath() . $images[0];
                } else {
                    $image_url = Utils::GetBaseUrl() . '/bootstrap/site/images/default.jpeg';
                }
            }

            $now = strtotime(date('Y-m-d H:i:s'));
            $exp = strtotime($product->product_expiry_date);
            $diff = $exp - $now;

            $slug = Product::createSlug($product->product_name);

            $result[] = array(
                'p_id' => $product->product_id,
                'p_name' => $product->product_name,
                'p_image' => $image_url,
                'p_price' => $product->product_temp_current_price,
                'p_expiry' => $diff,
                'p_new_expiry' => $exp,
                'p_expiry_date' => $exp,
                'p_now' => $now,
                'p_slug' => $slug
            );
        }
        // print_r($result);die;
        return $result;
    }

    public static function countProductBySellerID($seller_id) {
        $result = Product::model()->count('product_sellersID=' . $seller_id);

        if (!empty($result)) {
            return $result;
        } else {
            return 0;
        }
    }

    public static function getAmountToPay($product_id, $winner_amount, $invoice_type) {
        $product = Product::model()->findByPk($product_id);
        $tax = $product->product_tax;
        if ($invoice_type == 1) {
            $shipping = !empty($product->product_shipping_price) ? $product->product_shipping_price : 0;
        } else {
            $shipping = 0;
        }

        $product_tax_price_1 = $product_tax_price_2 = $product_tax_price_3 = 0;

        if ($tax == 25) {
            $tax = 20;
            $product_tax_price_1 = $winner_amount * ($tax / 100);
            $product_price = $winner_amount - $product_tax_price_1;
        } else if ($tax == 12) {
            $tax = 10.71;
            $product_tax_price_2 = $winner_amount * ($tax / 100);
            $product_price = $winner_amount - $product_tax_price_2;
        } else if ($tax == 6) {
            $tax = 5.66;
            $product_tax_price_3 = $winner_amount * ($tax / 100);
            $product_price = $winner_amount - $product_tax_price_3;
        } else {
            $tax = 0;
            $product_tax_price_1 = $winner_amount * ($tax / 100);
            $product_price = $winner_amount - $product_tax_price_1;
        }

        $shipping_tax_price = $shipping * (20 / 100);
        $shipping_price = $shipping - $shipping_tax_price;

        return json_encode(
                array(
                    'tax_price_1' => $product_tax_price_1,
                    'tax_price_2' => $product_tax_price_2,
                    'tax_price_3' => $product_tax_price_3,
                    'product_amount' => $product_price,
                    'shipping_price' => $shipping_price,
                    'shipping_tax_price' => $shipping_tax_price,
                )
        );
    }

    public static function getProductNameById($id) {
        $model = Product::model()->findByPk($id);
        $name = '-';
        if (!empty($model)) {
            $name = $model->product_name;
        }
        echo $name;
    }

    public static function getProductShippingPriceById($id, $amt = 0) {
        $model = Product::model()->findByPk($id);
        $price = '-';
        if (!empty($model)) {
            $price = $model->product_shipping_price;
            if ($amt != 0) {
                $price = $amt - $model->product_shipping_price;
            }
        }
        echo $price;
    }

}
