<?php

/**
 * This is the model class for table "{{bid}}".
 *
 * The followings are the available columns in table '{{bid}}':
 * @property integer $bid_id
 * @property integer $bid_productID
 * @property integer $bid_buyersID
 * @property double $bid_value
 * @property string $bid_created
 * @property string $bid_updated
 * @property integer $bid_status
 *
 * The followings are the available model relations:
 * @property User $bidUser
 * @property Product $bidProduct
 */
class Bid extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{bid}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('bid_productID, bid_buyersID, bid_value', 'required'),
            array('bid_productID, bid_buyersID', 'numerical', 'integerOnly' => true),
            array('bid_value', 'numerical'),
            array('bid_created', 'default', 'value' => date("Y-m-d H:i:s")),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('bid_id, bid_productID, bid_buyersID, bid_value, bid_created, bid_updated, bid_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'bidUser' => array(self::BELONGS_TO, 'User', 'bid_buyersID'),
            'bidProduct' => array(self::BELONGS_TO, 'Product', 'bid_productID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'bid_id' => 'Bid',
            'bid_productID' => 'Bid Product',
            'bid_buyersID' => 'Bid User',
            'bid_value' => 'Bid Value',
            'bid_created' => 'Bid Created',
            'bid_updated' => 'Bid Updated',
            'bid_status' => 'Bid Status',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('bid_id', $this->bid_id);
        $criteria->compare('bid_productID', $this->bid_productID);
        $criteria->compare('bid_buyersID', $this->bid_buyersID);
        $criteria->compare('bid_value', $this->bid_value);
        $criteria->compare('bid_created', $this->bid_created, true);
        $criteria->compare('bid_updated', $this->bid_updated, true);
        $criteria->compare('bid_status', $this->bid_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Bid the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getBids($user_id = null, $product_id) {

        $result = array();

        if (isset($user_id) && !empty($user_id)) {

            $bids = Bid::model()->findAllByAttributes(array(
                'bid_status' => 1,
                'bid_buyersID' => $user_id,
                'bid_productID' => $product_id,
                    ), array(
                'order' => 'bid_created DESC'
                    )
            );

            foreach ($bids as $bid) {
                //October 31, 2014 2:30pm
                //$english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                //$swedish_months = array('januari', 'februari', 'mars', 'april', 'maj', 'juni', 'juli', 'augusti', 'september', 'oktober', 'november', 'december');
                $english_months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                $swedish_months = array('jan', 'feb', 'mar', 'apr', 'maj', 'jun', 'jul', 'aug', 'sep', 'okt', 'nov', 'dec');
                $b_created = date("Y-m-d H:i:s", strtotime($bid->bid_created));
                //$b_created = 'May 31, 2015 13:03:10';
                $b_created = str_replace($english_months, $swedish_months, $b_created);

                $result[] = array(
                    'b_id' => $bid->bid_id,
                    'b_value' => $bid->bid_value,
                    'b_created' => $b_created
                );
            }
        } else {

            $bids = Bid::model()->findAllByAttributes(array(
                'bid_status' => 1,
                'bid_productID' => $product_id,
            ));

            foreach ($bids as $bid) {
                //October 31, 2014 2:30pm
                $english_months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
                $swedish_months = array('jan', 'feb', 'mar', 'apr', 'maj', 'jun', 'jul', 'aug', 'sep', 'okt', 'nov', 'dec');
                $b_created = date("Y-m-d H:i:s", strtotime($bid->bid_created));
                $b_created = str_replace($english_months, $swedish_months, $b_created);

                $result[] = array(
                    'b_id' => $bid->bid_id,
                    'b_buyersid' => $bid->bid_buyersID,
                    'b_value' => $bid->bid_value,
                    'b_created' => $b_created
                );
            }
        }
        return $result;
    }

    public static function getBiddedProducts($user_id = null, $fun_id) {

        if (!empty($user_id) && isset($user_id)) {

            $bids = Bid::model()->findAllByAttributes(
                    array(
                'bid_status' => 1, 'bid_buyersID' => $user_id
                    ), array(
                'select' => 'bid_productID', 'group' => 'bid_productID'
            ));
        } else {

            $bids = Bid::model()->findAllByAttributes(
                    array(
                'bid_status' => 1,
                    ), array(
                'select' => 'bid_productID', 'group' => 'bid_productID'
            ));
        }

        $result = array();

        foreach ($bids as $bid) {
            $data = Product::model()->getSingleProduct($bid->bid_productID);

            switch ($fun_id) {
                case 1:

                    //Ongoing Auction
                    if ($data['p_expiry'] > 0) {
                        $result[] = array(
                            'p_id' => $data['p_id'],
                            'u_id' => $data['u_id'],
                            'p_name' => $data['p_name'],
                            'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                            'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                            'p_slug' => $data['p_slug'],
                            'p_price' => $data['p_price'],
                            'p_biddiff' => $data['p_biddiff'],
                            'p_buynow_price' => $data['p_buynow_price'],
                            'p_reserve_price' => $data['p_reserve_price'],
                            'p_expiry' => $data['p_expiry'],
                            'p_expiry_date' => $data['p_expiry_date'],
                            'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                            'result' => Bid::model()->getResult($data['p_id'], $user_id, $data['p_expiry'])
                        );
                    }

                    break;
                case 2:

                    //Closed Auction
                    if ($data['p_expiry'] < 0) {

                        $payment = Payment::model()->findByAttributes(array(
                            'payment_productID' => $data['p_id'],
                            'payment_buyersID' => $data['u_id'],
                        ));

                        if (count($payment) > 0) {
                            if ($payment->payment_status == 'Pending') {
                                $result[] = array(
                                    'p_id' => $data['p_id'],
                                    'u_id' => $data['u_id'],
                                    'p_name' => $data['p_name'],
                                    'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                    'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                    'p_slug' => $data['p_slug'],
                                    'p_price' => $data['p_price'],
                                    'p_biddiff' => $data['p_biddiff'],
                                    'p_buynow_price' => $data['p_buynow_price'],
                                    'p_shipping_price' => $data['p_shipping_price'],
                                    'p_expiry' => $data['p_expiry'],
                                    'p_biddiff' => $data['p_biddiff'],
                                    'p_buynow_price' => $data['p_buynow_price'],
                                    'p_reserve_price' => $data['p_reserve_price'],
                                    'p_expiry_date' => $data['p_expiry_date'],
                                    'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                    'result' => Bid::model()->getResult($data['p_id'], $user_id, $data['p_expiry'])
                                );
                            }
                        } else {
                            $result[] = array(
                                'p_id' => $data['p_id'],
                                'u_id' => $data['u_id'],
                                'p_name' => $data['p_name'],
                                'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                'p_slug' => $data['p_slug'],
                                'p_price' => $data['p_price'],
                                'p_biddiff' => $data['p_biddiff'],
                                'p_buynow_price' => $data['p_buynow_price'],
                                'p_shipping_price' => $data['p_shipping_price'],
                                'p_reserve_price' => $data['p_reserve_price'],
                                'p_expiry' => $data['p_expiry'],
                                'p_biddiff' => $data['p_biddiff'],
                                'p_expiry_date' => $data['p_expiry_date'],
                                'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                'result' => Bid::model()->getResult($data['p_id'], $user_id, $data['p_expiry'])
                            );
                        }
                    }

                    break;
                case 3:

                    //Paid Auction
                    if ($data['p_expiry'] < 0) {

                        $unpaid = Bid::model()->getResult($data['p_id'], $user_id, $data['p_expiry']);

                        if ($unpaid['winner']) {

                            $payment = Payment::model()->findByAttributes(array(
                                'payment_productID' => $data['p_id'],
                                'payment_buyersID' => $data['u_id'],
                            ));

                            if (count($payment) > 0) {
                                if ($payment->payment_status == 'Completed') {
                                    $result[] = array(
                                        'p_id' => $data['p_id'],
                                        'u_id' => $data['u_id'],
                                        'p_name' => $data['p_name'],
                                        'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                        'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                        'p_slug' => $data['p_slug'],
                                        'p_price' => $data['p_price'],
                                        'p_paid' => $payment->payment_amount,
                                        'p_buynow_price' => $data['p_buynow_price'],
                                        'p_expiry' => $data['p_expiry'],
                                        'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                        'result' => $unpaid
                                    );
                                }
                            }
                        }
                    }

                    break;
                case 4:

                    //Unpaid Auction
                    if ($data['p_expiry'] < 0) {

                        if (!empty($user_id) && isset($user_id)) {
                            $unpaid = Bid::model()->getResult($data['p_id'], $user_id, $data['p_expiry']);
                        } else {
                            $unpaid = Bid::model()->getAllResult($data['p_id'], $data['p_expiry']);
                        }

                        if ($unpaid['winner']) {

                            $payment = Payment::model()->findByAttributes(array(
                                'payment_productID' => $data['p_id'],
                                'payment_buyersID' => $data['u_id'],
                            ));

                            $flag = 0;
                            if (count($payment) > 0) {
                                if ($payment->payment_status == 'Pending') {
                                    $flag = 1;
                                }
                            } else {
                                $flag = 1;
                            }

                            if ($flag == 1) {
                                $result[] = array(
                                    'p_id' => $data['p_id'],
                                    'p_userid' => $data['p_userid'],
                                    'u_id' => $data['u_id'],
                                    'p_name' => $data['p_name'],
                                    'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                    'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                    'p_slug' => $data['p_slug'],
                                    'p_price' => $data['p_price'],
                                    'p_buynow_price' => $data['p_buynow_price'],
                                    'p_shipping_price' => $data['p_shipping_price'],
                                    'p_expiry' => $data['p_expiry'],
                                    'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                    'result' => $unpaid
                                );
                            }
                        }
                    }

                    break;
                case 5:

                    $payment = Payment::model()->findByAttributes(array(
                        'payment_productID' => $data['p_id'],
                        'payment_buyersID' => $data['u_id'],
                    ));

                    if (count($payment) > 0) {
                        if ($payment->payment_status == 'Completed') {

                            $result[] = array(
                                'p_id' => $data['p_id'],
                                'u_id' => $data['u_id'],
                                'p_name' => $data['p_name'],
                                'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                'p_slug' => $data['p_slug'],
                                'p_price' => $data['p_price'],
                                'p_paid' => $payment->payment_amount,
                                'p_biddiff' => $data['p_biddiff'],
                                'p_buynow_price' => $data['p_buynow_price'],
                                'p_reserve_price' => $data['p_reserve_price'],
                                'p_expiry' => $data['p_expiry'],
                                'p_expiry_date' => $data['p_expiry_date'],
                                'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                'result' => Bid::model()->getResult($data['p_id'], $user_id, $data['p_expiry'])
                            );
                        }
                    } else {

                        $result[] = array(
                            'p_id' => $data['p_id'],
                            'u_id' => $data['u_id'],
                            'p_name' => $data['p_name'],
                            'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                            'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                            'p_slug' => $data['p_slug'],
                            'p_price' => $data['p_price'],
                            'p_biddiff' => $data['p_biddiff'],
                            'p_shipping_price' => $data['p_shipping_price'],
                            'p_biddiff' => $data['p_biddiff'],
                            'p_buynow_price' => $data['p_buynow_price'],
                            'p_reserve_price' => $data['p_reserve_price'],
                            'p_expiry' => $data['p_expiry'],
                            'p_expiry_date' => $data['p_expiry_date'],
                            'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                            'result' => Bid::model()->getResult($data['p_id'], $user_id, $data['p_expiry'])
                        );
                    }

                    break;
                default :

                    $result[] = array(
                        'p_id' => $data['p_id'],
                        'u_id' => $data['u_id'],
                        'p_name' => $data['p_name'],
                        'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                        'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                        'p_slug' => $data['p_slug'],
                        'p_price' => $data['p_price'],
                        'p_biddiff' => $data['p_biddiff'],
                        'p_buynow_price' => $data['p_buynow_price'],
                        'p_expiry' => $data['p_expiry'],
                        'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                        'result' => Bid::model()->getResult($data['p_id'], $user_id, $data['p_expiry'])
                    );

                    break;
            }
        }

        return $result;
    }

    public static function getResult($p_id, $u_id = null, $exp = null) {

        $result = array();

        $connection = Yii::app()->db;
        $command = $connection->createCommand('select product_winners as winners, product_reserve_price from tbl_product WHERE product_status=1 AND product_id=' . $p_id);
        $winners = $command->queryRow();

        $reserve_price = $winners['product_reserve_price'];

        if ($reserve_price > 0) {
            $command = $connection->createCommand('SELECT distinct bid_buyersID, max(bid_value) as bid FROM `tbl_bid` WHERE bid_value>=' . $reserve_price . ' AND `bid_productID` = ' . $p_id . ' group by bid_buyersID order by bid desc limit ' . $winners['winners']);
        } else {
            $command = $connection->createCommand('SELECT distinct bid_buyersID, max(bid_value) as bid FROM `tbl_bid` WHERE `bid_productID` = ' . $p_id . ' group by bid_buyersID order by bid desc limit ' . $winners['winners']);
        }

        $row = $command->queryAll();

        if (count($row) > 0) {
            $i = 1;
            $flag = 1;
            $temp = 0;

            foreach ($row as $r) {
                if ($temp == 0) {
                    if ($r['bid_buyersID'] == $u_id) {

                        if ($i == 1) {
                            //if ($reserve_price > 0) {
                            //$getPrice = $reserve_price;
                            //} else {
                            $getPrice = Product::model()->findByPk($p_id)->product_temp_current_price;
                            //}
                        } else {
                            $getPrice = $r['bid'];
                        }

                        $result = array(
                            'winner' => TRUE,
                            'winner_msg' => 'Du är vinnare #' . $i,
                            'winner_price' => $getPrice
                        );
                        $flag = 0;
                        $temp = 1;
                    }
                    $i++;
                }
            }

            if ($flag == 1) {
                $result = array(
                    'winner' => FALSE,
                    'winner_msg' => 'Tyvärr vann du inte, vi önskar dig bättre lycka nästa gång.'
                );
            }
        } else {
            $result = array(
                'winner' => FALSE,
                'winner_msg' => 'Tyvärr vann du inte, vi önskar dig bättre lycka nästa gång.'
            );
        }

        return $result;
    }

    public static function getFunctionType($fun_id) {
        $fun_type = '';

        switch ($fun_id) {
            case 1:
                $fun_type = Yii::t('lang', 'ongoing_auctions');
                break;
            case 2:
                $fun_type = Yii::t('lang', 'closed_auctions');
                break;
            case 3:
                $fun_type = Yii::t('lang', 'paid_auctions');
                break;
            case 4:
                $fun_type = Yii::t('lang', 'unpaid_auctions');
                break;
            case 5:
                $fun_type = Yii::t('lang', 'all_auctions');
                break;
            default :
                $fun_type = Yii::t('lang', 'all_auctions');
                break;
        }

        return $fun_type;
    }

    public static function getAllBids($product_id) {
        $bids = Bid::model()->findAllByAttributes(array(
            'bid_status' => 1,
            'bid_productID' => $product_id,
                ), array(
            'select' => 'bid_buyersID, bid_created, bid_value',
            'order' => 'bid_created DESC',
            'group' => 'bid_buyersID'
        ));

        $result = array();

        foreach ($bids as $bid) {
            //October 31, 2014 2:30pm
            $english_months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
            $swedish_months = array('jan', 'feb', 'mar', 'apr', 'maj', 'jun', 'jul', 'aug', 'sep', 'okt', 'nov', 'dec');
            $b_created = date("Y-m-d H:i:s", strtotime($bid->bid_created));
            $b_created = str_replace($english_months, $swedish_months, $b_created);

            $name = Buyers::model()->findByPk($bid->bid_buyersID);

            $result[] = array(
                //'b_id' => $bid->bid_id,
                //'b_name' => $name->user_firstname . ' ' . $name->user_lastname,
                'b_name' => $name->buyers_nickname,
                'b_value' => $bid->bid_value,
                'b_created' => $b_created
            );
        }

        return $result;
    }

    public static function GetProductsBidByBuyerID($user_id, $fun_id = NULL) {

        $bids = Bid::model()->findAllByAttributes(
                array('bid_status' => 1, 'bid_buyersID' => $user_id), array(
            'select' => 'bid_productID', 'group' => 'bid_productID'
        ));

        $result = array();

        foreach ($bids as $bid) {
            $data = Product::model()->getSingleProduct($bid->bid_productID);

            switch ($fun_id) {
                case 1:

                    //Ongoing Auction
                    if ($data['p_expiry'] > 0) {
                        $result[] = array(
                            'p_id' => $data['p_id'],
                            'p_userid' => $data['p_userid'],
                            'u_id' => $data['u_id'],
                            'p_name' => $data['p_name'],
                            'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                            'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                            'p_slug' => $data['p_slug'],
                            'p_price' => $data['p_price'],
                            'p_biddiff' => $data['p_biddiff'],
                            'p_biddifference' => $data['p_biddifference'],
                            'p_buynow_price' => $data['p_buynow_price'],
                            'p_shipping_price' => $data['p_shipping_price'],
                            'p_reserve_price' => $data['p_reserve_price'],
                            'p_expiry' => $data['p_expiry'],
                            'p_expiry_date' => $data['p_expiry_date'],
                            'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                            'result' => Bid::showWinnersWithPrice($bid->bid_productID)
                        );
                    }

                    break;
                case 2:

                    //Closed Auction
                    if ($data['p_expiry'] < 0) {

                        $payment = Payment::model()->findByAttributes(array(
                            'payment_productID' => $data['p_id'],
                            'payment_buyersID' => $data['u_id'],
                        ));

                        if (count($payment) > 0) {
                            if ($payment->payment_status == 'Pending') {
                                $result[] = array(
                                    'p_id' => $data['p_id'],
                                    'p_userid' => $data['p_userid'],
                                    'u_id' => $data['u_id'],
                                    'p_name' => $data['p_name'],
                                    'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                    'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                    'p_slug' => $data['p_slug'],
                                    'p_price' => $data['p_price'],
                                    'p_biddiff' => $data['p_biddiff'],
                                    'p_biddifference' => $data['p_biddifference'],
                                    'p_buynow_price' => $data['p_buynow_price'],
                                    'p_shipping_price' => $data['p_shipping_price'],
                                    'p_expiry' => $data['p_expiry'],
                                    'p_biddiff' => $data['p_biddiff'],
                                    'p_buynow_price' => $data['p_buynow_price'],
                                    'p_reserve_price' => $data['p_reserve_price'],
                                    'p_expiry_date' => $data['p_expiry_date'],
                                    'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                    'result' => Bid::showWinnersWithPrice($bid->bid_productID)
                                );
                            }
                        } else {
                            $result[] = array(
                                'p_id' => $data['p_id'],
                                'p_userid' => $data['p_userid'],
                                'u_id' => $data['u_id'],
                                'p_name' => $data['p_name'],
                                'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                'p_slug' => $data['p_slug'],
                                'p_price' => $data['p_price'],
                                'p_biddiff' => $data['p_biddiff'],
                                'p_biddifference' => $data['p_biddifference'],
                                'p_buynow_price' => $data['p_buynow_price'],
                                'p_shipping_price' => $data['p_shipping_price'],
                                'p_reserve_price' => $data['p_reserve_price'],
                                'p_expiry' => $data['p_expiry'],
                                'p_biddiff' => $data['p_biddiff'],
                                'p_expiry_date' => $data['p_expiry_date'],
                                'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                'result' => Bid::showWinnersWithPrice($bid->bid_productID)
                            );
                        }
                    }

                    break;
                case 4:

                    //Unpaid Auction
                    if ($data['p_expiry'] < 0) {

                        $unpaid = Bid::model()->getResult($data['p_id'], $user_id, $data['p_expiry']);

                        if ($unpaid['winner']) {

                            $payment = Payment::model()->findByAttributes(array(
                                'payment_productID' => $data['p_id'],
                                'payment_buyersID' => $data['u_id'],
                            ));

                            if (count($payment) > 0) {
                                if ($payment->payment_status == 'Completed') {
                                    $result[] = array(
                                        'p_id' => $data['p_id'],
                                        'p_userid' => $data['p_userid'],
                                        'u_id' => $data['u_id'],
                                        'p_name' => $data['p_name'],
                                        'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                        'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                        'p_slug' => $data['p_slug'],
                                        'p_price' => $data['p_price'],
                                        'p_biddifference' => $data['p_biddifference'],
                                        'p_paid' => $payment->payment_amount,
                                        'p_buynow_price' => $data['p_buynow_price'],
                                        'p_shipping_price' => $data['p_shipping_price'],
                                        'p_expiry' => $data['p_expiry'],
                                        'p_expiry_date' => $data['p_expiry_date'],
                                        'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                        'result' => $unpaid
                                    );
                                }
                            }
                        }
                    }

                    break;
                case 3:

                    //Paid Auction
                    if ($data['p_expiry'] < 0) {

                        if (!empty($user_id) && isset($user_id)) {
                            $unpaid = Bid::model()->getResult($data['p_id'], $user_id, $data['p_expiry']);
                        } else {
                            $unpaid = Bid::model()->getAllResult($data['p_id'], $data['p_expiry']);
                        }

                        if ($unpaid['winner']) {

                            $payment = Payment::model()->findByAttributes(array(
                                'payment_productID' => $data['p_id'],
                                'payment_buyersID' => $data['u_id'],
                            ));

                            $flag = 0;
                            if (count($payment) > 0) {
                                if ($payment->payment_status == 'Pending') {
                                    $flag = 1;
                                }
                            } else {
                                $flag = 1;
                            }

                            if ($flag == 1) {
                                $result[] = array(
                                    'p_id' => $data['p_id'],
                                    'p_userid' => $data['p_userid'],
                                    'p_userid' => $data['p_userid'],
                                    'u_id' => $data['u_id'],
                                    'p_name' => $data['p_name'],
                                    'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                    'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                    'p_slug' => $data['p_slug'],
                                    'p_price' => $data['p_price'],
                                    'p_biddifference' => $data['p_biddifference'],
                                    'p_buynow_price' => $data['p_buynow_price'],
                                    'p_shipping_price' => $data['p_shipping_price'],
                                    'p_expiry' => $data['p_expiry'],
                                    'p_expiry_date' => $data['p_expiry_date'],
                                    'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                    'result' => $unpaid
                                );
                            }
                        }
                    }

                    break;
                case 5:

                    $payment = Payment::model()->findByAttributes(array(
                        'payment_productID' => $data['p_id'],
                        'payment_buyersID' => $data['u_id'],
                    ));

                    if (count($payment) > 0) {
                        if ($payment->payment_status == 'Completed') {

                            $result[] = array(
                                'p_id' => $data['p_id'],
                                'p_userid' => $data['p_userid'],
                                'u_id' => $data['u_id'],
                                'p_name' => $data['p_name'],
                                'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                'p_slug' => $data['p_slug'],
                                'p_price' => $data['p_price'],
                                'p_paid' => $payment->payment_amount,
                                'p_biddiff' => $data['p_biddiff'],
                                'p_biddifference' => $data['p_biddifference'],
                                'p_buynow_price' => $data['p_buynow_price'],
                                'p_reserve_price' => $data['p_reserve_price'],
                                'p_expiry' => $data['p_expiry'],
                                'p_expiry_date' => $data['p_expiry_date'],
                                'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                'result' => Bid::showWinnersWithPrice($bid->bid_productID)
                            );
                        }
                    } else {

                        $result[] = array(
                            'p_id' => $data['p_id'],
                            'p_userid' => $data['p_userid'],
                            'u_id' => $data['u_id'],
                            'p_name' => $data['p_name'],
                            'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                            'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                            'p_slug' => $data['p_slug'],
                            'p_price' => $data['p_price'],
                            'p_biddiff' => $data['p_biddiff'],
                            'p_biddifference' => $data['p_biddifference'],
                            'p_shipping_price' => $data['p_shipping_price'],
                            'p_biddiff' => $data['p_biddiff'],
                            'p_buynow_price' => $data['p_buynow_price'],
                            'p_reserve_price' => $data['p_reserve_price'],
                            'p_expiry' => $data['p_expiry'],
                            'p_expiry_date' => $data['p_expiry_date'],
                            'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                            'result' => Bid::showWinnersWithPrice($bid->bid_productID)
                        );
                    }

                    break;
                default :

                    $payment = Payment::model()->findByAttributes(array(
                        'payment_productID' => $data['p_id'],
                        'payment_buyersID' => $data['u_id'],
                    ));

                    if (count($payment) > 0) {
                        if ($payment->payment_status == 'Completed') {

                            $result[] = array(
                                'p_id' => $data['p_id'],
                                'p_userid' => $data['p_userid'],
                                'u_id' => $data['u_id'],
                                'p_name' => $data['p_name'],
                                'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                'p_slug' => $data['p_slug'],
                                'p_price' => $data['p_price'],
                                'p_paid' => $payment->payment_amount,
                                'p_biddiff' => $data['p_biddiff'],
                                'p_biddifference' => $data['p_biddifference'],
                                'p_buynow_price' => $data['p_buynow_price'],
                                'p_reserve_price' => $data['p_reserve_price'],
                                'p_expiry' => $data['p_expiry'],
                                'p_expiry_date' => $data['p_expiry_date'],
                                'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                //'result' => Bid::model()->getResult($data['p_id'], $user_id, $data['p_expiry'])
                                'result' => Bid::showWinnersWithPrice($bid->bid_productID)
                            );
                        }
                    } else {

                        $result[] = array(
                            'p_id' => $data['p_id'],
                            'p_userid' => $data['p_userid'],
                            'u_id' => $data['u_id'],
                            'p_name' => $data['p_name'],
                            'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                            'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                            'p_slug' => $data['p_slug'],
                            'p_price' => $data['p_price'],
                            'p_biddiff' => $data['p_biddiff'],
                            'p_biddifference' => $data['p_biddifference'],
                            'p_shipping_price' => $data['p_shipping_price'],
                            'p_biddiff' => $data['p_biddiff'],
                            'p_buynow_price' => $data['p_buynow_price'],
                            'p_reserve_price' => $data['p_reserve_price'],
                            'p_expiry' => $data['p_expiry'],
                            'p_expiry_date' => $data['p_expiry_date'],
                            'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                            //'result' => Bid::model()->getResult($data['p_id'], $user_id, $data['p_expiry'])
                            'result' => Bid::showWinnersWithPrice($bid->bid_productID)
                        );
                    }

                    break;
            }
        }

        return $result;
    }

    public function OngoingAuctionByBuyersID($offset, $limit, $user_id) {

        $sql = 'select distinct product_id from tbl_bid b INNER JOIN tbl_product p ON b.bid_productID=p.product_id WHERE b.bid_buyersID=' . $user_id . ' AND p.product_expiry_date > "' . date('Y-m-d H:i:s') . '" ORDER BY p.product_expiry_date DESC LIMIT ' . $offset . ', ' . $limit;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $bids = $command->queryAll();

        $result = array();

        foreach ($bids as $bid) {
            $data = Product::model()->getSingleProduct($bid['product_id']);

            $result[] = array(
                'p_id' => $data['p_id'],
                'p_userid' => $data['p_userid'],
                'u_id' => $data['u_id'],
                'p_name' => $data['p_name'],
                'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                'p_slug' => $data['p_slug'],
                'p_price' => $data['p_price'],
                'p_winners' => $data['p_winners'],
                'p_biddiff' => $data['p_biddiff'],
                'p_biddifference' => $data['p_biddifference'],
                'p_current_price' => $data['p_price'],
                'p_buynow_price' => $data['p_buynow_price'],
                'p_shipping_price' => $data['p_shipping_price'],
                'p_reserve_price' => $data['p_reserve_price'],
                'p_expiry' => $data['p_expiry'],
                'p_expiry_date' => $data['p_expiry_date'],
                'bids' => Bid::model()->getBids($user_id, $data['p_id'])
            );
        }

        return $result;
    }

    public function OngoingAuctionCountByBuyersID($user_id) {
        $sql = 'select count(distinct product_id) from tbl_bid b INNER JOIN tbl_product p ON b.bid_productID=p.product_id WHERE b.bid_buyersID=' . $user_id . ' AND p.product_expiry_date > "' . date('Y-m-d H:i:s') . '"';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $count = $command->queryScalar();

        return $count;
    }

    public function ClosedAuctionByBuyersID($offset, $limit, $user_id) {

        $sql = 'select distinct product_id from tbl_bid b INNER JOIN tbl_product p ON b.bid_productID=p.product_id WHERE b.bid_buyersID=' . $user_id . ' AND p.product_expiry_date < "' . date('Y-m-d H:i:s') . '" ORDER BY p.product_expiry_date DESC LIMIT ' . $offset . ', ' . $limit;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $bids = $command->queryAll();
        $totals = 0;
        $i_total = $j_total = 0;

        $result = array();

        foreach ($bids as $bid) {
            $data = Product::model()->getSingleProduct($bid['product_id']);

            $payment = Payment::model()->findByAttributes(array(
                'payment_productID' => $bid['product_id'],
                'payment_buyersID' => $user_id,
            ));

            if (!empty($payment)) {

                if ($payment->payment_status != 'Completed') {
                    $result[] = array(
                        'p_id' => $data['p_id'],
                        'p_userid' => $data['p_userid'],
                        'u_id' => $data['u_id'],
                        'p_name' => $data['p_name'],
                        'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                        'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                        'p_slug' => $data['p_slug'],
                        'p_price' => $data['p_price'],
                        'p_winners' => $data['p_winners'],
                        'p_biddiff' => $data['p_biddiff'],
                        'p_biddifference' => $data['p_biddifference'],
                        'p_current_price' => $data['p_price'],
                        'p_buynow_price' => $data['p_buynow_price'],
                        'p_shipping_price' => $data['p_shipping_price'],
                        'p_reserve_price' => $data['p_reserve_price'],
                        'p_expiry' => $data['p_expiry'],
                        'p_expiry_date' => $data['p_expiry_date'],
                        'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                        'result' => Bid::showWinnersWithPrice($data['p_id'])
                    );
                }
            } else {
                $result[] = array(
                    'p_id' => $data['p_id'],
                    'p_userid' => $data['p_userid'],
                    'u_id' => $data['u_id'],
                    'p_name' => $data['p_name'],
                    'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                    'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                    'p_slug' => $data['p_slug'],
                    'p_price' => $data['p_price'],
                    'p_winners' => $data['p_winners'],
                    'p_biddiff' => $data['p_biddiff'],
                    'p_biddifference' => $data['p_biddifference'],
                    'p_current_price' => $data['p_price'],
                    'p_buynow_price' => $data['p_buynow_price'],
                    'p_shipping_price' => $data['p_shipping_price'],
                    'p_reserve_price' => $data['p_reserve_price'],
                    'p_expiry' => $data['p_expiry'],
                    'p_expiry_date' => $data['p_expiry_date'],
                    'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                    'result' => Bid::showWinnersWithPrice($data['p_id'])
                );
            }
        }

        return $result;
    }

    public function ClosedAuctionCountByBuyersID($user_id) {
        $sql = 'select count(distinct product_id) from tbl_bid b INNER JOIN tbl_product p ON b.bid_productID=p.product_id WHERE b.bid_buyersID=' . $user_id . ' AND p.product_expiry_date < "' . date('Y-m-d H:i:s') . '"';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $count = $command->queryScalar();

        return $count;
    }

    public function getPaidUnpaidStatusOfAuctionByBuyersID($offset, $limit, $user_id) {

        $sql = 'SELECT product_id, product_winners FROM `tbl_product` p WHERE p.product_expiry_date <= "' . date('Y-m-d H:i:s') . '" ORDER BY p.`product_expiry_date` ASC';
        //$sql = 'SELECT product_id, product_winners FROM `tbl_product` p WHERE p.product_expiry_date <= "'. date('Y-m-d H:i:s') .'" ORDER BY p.`product_id` ASC';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $total = $command->queryAll();
        $total_unpaid = 0;
        $total_paid = 0;

        $product_array_paid = array();
        $product_array_unpaid = array();

        $i_paid = $i_unpaid = $j_paid = $j_unpaid = 0;

        foreach ($total as $single) {
            $winners = Bid::model()->showWinnersWithPrice($single['product_id']);
            $winners = json_decode($winners);

            if ($winners->status == 1) {
                //The Auction on which User is Winner
                $winner = "";
                $winner_array = array();
                foreach ($winners->result as $user) {
                    if ($user_id == $user->winner_userid) {
                        $winner = $user->winner_userid;
                        $winner_array[] = $user->winner_userid;
                    }
                }

                $sql = 'SELECT p.payment_buyersID FROM `tbl_payment` p WHERE p.payment_productID=' . $single['product_id'] . ' AND p.payment_buyersID="' . $winner . '" AND p.payment_status="Completed" LIMIT 1';
                $command = $connection->createCommand($sql);
                $records = $command->queryAll();

                $payment = array();
                foreach ($records as $record) {
                    $payment[] = $record['payment_buyersID'];
                }
                $unpaid = array_diff($winner_array, $payment);

                $data = Product::model()->getSingleProduct($single['product_id']);

                if (!empty($unpaid)) {
                    //echo "Unpaid - " . $single['product_id'] . "<br/>";
                    //echo "Unpaid - ".$i_paid.', '.$j_paid.', '.$offset.', '.$data['p_id'].'<br/>';
                    $total_unpaid++;
                    if ($i_unpaid >= $offset) {
                        if ($j_unpaid < $limit) {
                            $product_array_unpaid[] = array(
                                'paid' => $payment,
                                'unpaid' => $unpaid,
                                'winners' => $winners,
                                'data' => array(
                                    'p_id' => $data['p_id'],
                                    'p_slug' => $data['p_slug'],
                                    'u_id' => $data['u_id'],
                                    'p_name' => $data['p_name'],
                                    'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                    'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                    'p_winners' => $data['p_winners'],
                                    'p_biddiff' => $data['p_biddiff'],
                                    'p_current_price' => $data['p_price'],
                                    'p_price' => $data['p_price'],
                                    'p_buynow_price' => $data['p_buynow_price'],
                                    'p_shipping_price' => $data['p_shipping_price'],
                                    'p_reserve_price' => $data['p_reserve_price'],
                                    'p_expiry' => $data['p_expiry'],
                                    'p_expiry_date' => $data['p_expiry_date'],
                                    'p_biddifference' => $data['p_biddifference'],
                                    'p_buynow_price' => $data['p_buynow_price'],
                                    'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                )
                            );
                            $j_unpaid++;
                        }
                    }
                    $i_unpaid++;
                }

                if (!empty($payment)) {
                    //echo "Paid - " . $single['product_id'] . "<br/>";
                    $total_paid++;
                    //echo "Paid - ".$i_paid.', '.$j_paid.', '.$offset.', '.$data['p_id'].'<br/>';                   
                    if ($i_paid >= $offset) {
                        if ($j_paid < $limit) {
                            $product_array_paid[] = array(
                                'paid' => $payment,
                                'unpaid' => $unpaid,
                                'winners' => $winners,
                                'data' => array(
                                    'p_id' => $data['p_id'],
                                    'p_slug' => $data['p_slug'],
                                    'u_id' => $data['u_id'],
                                    'p_name' => $data['p_name'],
                                    'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                    'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                    'p_winners' => $data['p_winners'],
                                    'p_biddiff' => $data['p_biddiff'],
                                    'p_current_price' => $data['p_price'],
                                    'p_price' => $data['p_price'],
                                    'p_buynow_price' => $data['p_buynow_price'],
                                    'p_shipping_price' => $data['p_shipping_price'],
                                    'p_reserve_price' => $data['p_reserve_price'],
                                    'p_expiry' => $data['p_expiry'],
                                    'p_expiry_date' => $data['p_expiry_date'],
                                    'p_biddifference' => $data['p_biddifference'],
                                    'p_buynow_price' => $data['p_buynow_price'],
                                    'bids' => Bid::model()->getBids($user_id, $data['p_id']),
                                )
                            );
                            $j_paid++;
                        }
                    }
                    $i_paid++;
                }
            } else {
                //The Auction on which no User is Winner
            }
        }

        $result = array('total_unpaid' => $total_unpaid, 'total_paid' => $total_paid, 'product_array_paid' => $product_array_paid, 'product_array_unpaid' => $product_array_unpaid);
        return $result;
    }

    public function getPaidUnpaidStatusOfAuctionByBuyersIDFORALL($offset, $limit, $user_id) {

        $sql = 'SELECT product_id, product_winners FROM `tbl_product` p ORDER BY p.`product_expiry_date` ASC';
        //$sql = 'SELECT product_id, product_winners FROM `tbl_product` p ORDER BY p.`product_id` ASC';
        //$sql = 'SELECT product_id, product_winners FROM `tbl_product` p WHERE p.product_expiry_date <= "'. date('Y-m-d H:i:s') .'" ORDER BY p.`product_id` ASC';
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $total = $command->queryAll();
        $totals = 0;

        $i_total = $j_total = 0;

        foreach ($total as $single) {
            $winners = Bid::model()->showWinnersWithPrice($single['product_id']);
            $winners = json_decode($winners);

            // echo "Product - " . $single['product_id'] . "<br/>";
            // echo "Winner Status - " . $winners->status . "<br/>";
            $data = Product::model()->getSingleProduct($single['product_id']);

            if ($winners->status == 1) {
                //The Auction on which User is Winner
                $winner = "";
                $winner_array = array();
                foreach ($winners->result as $user) {
                    if ($user_id == $user->winner_userid) {
                        $winner = $user->winner_userid;
                        $winner_array[] = $user->winner_userid;
                    }
                }
                $winner = rtrim($winner, ',');

                $sql = 'SELECT p.payment_buyersID FROM `tbl_payment` p WHERE p.payment_productID=' . $single['product_id'] . ' AND p.payment_buyersID ="' . $winner . '" AND p.payment_status="Completed" LIMIT 1';
                $command = $connection->createCommand($sql);
                $records = $command->queryAll();

                $payment = array();
                foreach ($records as $record) {
                    $payment[] = $record['payment_buyersID'];
                }
                $unpaid = array_diff($winner_array, $payment);
            }

            //echo "Product - ".$i_total.', '.$j_total.', '.$offset.', '.$data['p_id'].'<br/>';

            $bids = Bid::model()->getBids($user_id, $data['p_id']);

            if (!empty($bids)) {

                if ($i_total >= $offset) {
                    if ($j_total < $limit) {
                        $product_array_total[] = array(
                            'paid' => $payment,
                            'unpaid' => $unpaid,
                            'winners' => $winners,
                            'data' => array(
                                'p_id' => $data['p_id'],
                                'p_slug' => $data['p_slug'],
                                'u_id' => $data['u_id'],
                                'p_name' => $data['p_name'],
                                'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                'p_winners' => $data['p_winners'],
                                'p_biddiff' => $data['p_biddiff'],
                                'p_current_price' => $data['p_price'],
                                'p_price' => $data['p_price'],
                                'p_buynow_price' => $data['p_buynow_price'],
                                'p_shipping_price' => $data['p_shipping_price'],
                                'p_reserve_price' => $data['p_reserve_price'],
                                'p_expiry' => $data['p_expiry'],
                                'p_expiry_date' => $data['p_expiry_date'],
                                'p_biddifference' => $data['p_biddifference'],
                                'p_buynow_price' => $data['p_buynow_price'],
                                'bids' => $bids,
                                'result' => Bid::showWinnersWithPrice($data['p_id'])
                            )
                        );
                        $j_total++;
                    }
                }
                $i_total++;
                $totals++;
            }
        }

        //print_r($product_array_total);

        $result = array('totals' => $totals, 'product_array_total' => $product_array_total);
        return $result;
    }

    /*
     * 
     * Bidding History Section for Admin
     * 
     */

    public static function AdminGetBids($product_id) {

        $result = array();

        $bids = Bid::model()->findAllByAttributes(
                array('bid_status' => 1, 'bid_productID' => $product_id), array('order' => 'bid_created DESC')
        );

        foreach ($bids as $bid) {
            //October 31, 2014 2:30pm            
            $english_months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
            $swedish_months = array('jan', 'feb', 'mar', 'apr', 'maj', 'jun', 'jul', 'aug', 'sep', 'okt', 'nov', 'dec');
            $b_created = date("Y-m-d H:i:s", strtotime($bid->bid_created));
            $b_created = str_replace($english_months, $swedish_months, $b_created);

            $result[] = array(
                'b_id' => $bid->bid_id,
                'b_buyersid' => $bid->bid_buyersID,
                'b_value' => $bid->bid_value,
                'b_created' => $b_created
            );
        }

        return $result;
    }

    public static function AdminGetAllResult($p_id) {

        $result = array();

        $connection = Yii::app()->db;
        $command = $connection->createCommand('select product_winners as winners, product_reserve_price from tbl_product WHERE product_status=1 AND product_id=' . $p_id);
        $winners = $command->queryRow();

        $reserve_price = $winners['product_reserve_price'];

        if ($reserve_price > 0) {
            $command = $connection->createCommand('SELECT distinct bid_buyersID, max(bid_value) as bid, bid_created FROM `tbl_bid` WHERE bid_value>=' . $reserve_price . ' AND `bid_productID` = ' . $p_id . ' group by bid_buyersID order by bid desc limit ' . $winners['winners']);
        } else {
            $command = $connection->createCommand('SELECT distinct bid_buyersID, max(bid_value) as bid, bid_created FROM `tbl_bid` WHERE `bid_productID` = ' . $p_id . ' group by bid_buyersID order by bid desc limit ' . $winners['winners']);
        }

        $row = $command->queryAll();

        $bids = Bid::model()->findAllByAttributes(array('bid_productID' => $p_id));

        if (count($row) > 0) {
            $i = 1;
            $flag = 1;

            if (count($bids) == 1) {

                if ($i == 1) {
                    $getPrice = Product::model()->findByPk($p_id)->product_temp_current_price;
                } else {
                    $getPrice = $r['bid'];
                }

                $result[] = array(
                    'winner' => TRUE,
                    'winner_number' => $i,
                    'winner_price' => $getPrice,
                    'winner_userid' => $bids[0]['bid_buyersID'],
                    'winner_created' => $bids[0]['bid_created']
                );
                $flag = 0;
            } else {
                foreach ($row as $r) {
                    if ($i == 1) {
                        $getPrice = Product::model()->findByPk($p_id)->product_temp_current_price;
                        if ($getPrice < $r['bid']) {
                            $getPrice = $r['bid'];
                        }
                    } else {
                        $getPrice = $r['bid'];
                    }
                    $result[] = array(
                        'winner' => TRUE,
                        'winner_number' => $i,
                        'winner_price' => $getPrice,
                        'winner_userid' => $r['bid_buyersID'],
                        'winner_created' => $r['bid_created']
                    );
                    $flag = 0;
                    $i++;
                }
            }
        }

        return $result;
    }

    public static function AdminGetFunctionType($fun_id) {
        $fun_type = '';

        switch ($fun_id) {
            case 1:
                $fun_type = Yii::t('lang', 'ongoing_auctions');
                break;
            case 2:
                $fun_type = Yii::t('lang', 'closed_auctions');
                break;
            case 3:
                $fun_type = Yii::t('lang', 'paid_auctions');
                break;
            case 4:
                $fun_type = Yii::t('lang', 'unpaid_auctions');
                break;
            case 5:
                $fun_type = Yii::t('lang', 'all_auctions');
                break;
            default :
                $fun_type = Yii::t('lang', 'all_auctions');
                break;
        }

        return $fun_type;
    }

    /*
     *
     * Final Modifications for Ongoing, Closed, Paid, Unpaid & All Auctions
     * Developed By Rahul Gupta, Bhaiyyalal Birle and Aman Raikwar
     * Developed on 18 May 2015
     *  
     */

    public static function showWinnersWithPrice($p_id) {
        $result = array();
        $status = 0;

        try {
            $connection = Yii::app()->db;
            $command = $connection->createCommand('select product_winners, product_reserve_price, product_temp_current_price from tbl_product WHERE product_status=1 AND product_id=' . $p_id);
            $model = $command->queryRow();

            $no_of_winners = $model['product_winners'];
            $reserve_price = $model['product_reserve_price'];
            $temp_price = $model['product_temp_current_price'];

            $sql = 'SELECT b.bid_productID, b.bid_buyersID, max( b.bid_value ) maxval, max(b.bid_created) maxdate, p.product_bid_diff_price ';
            $sql .= ' FROM `tbl_bid` b';
            $sql .= ' INNER JOIN tbl_product p ON b.bid_productID = p.product_id';
            $sql .= ' WHERE `bid_productID` = ' . $p_id;
            $sql .= ' AND b.bid_value >= p.product_reserve_price';
            $sql .= ' GROUP BY b.bid_buyersID';
            $sql .= ' ORDER BY maxval DESC, maxdate ASC';
            $sql .= ' LIMIT ' . $no_of_winners;

            //echo $sql;

            $command = $connection->createCommand($sql);
            $rows = $command->queryAll();

            $num_rows = count($rows);
            if ($num_rows > 0) {
                $i = 1;
                $status = 1;
                $highestBidValue = $rows[0]['maxval'];

                if ($num_rows == 1) {

                    $price = $temp_price;
                    if ($reserve_price >= $temp_price) {
                        $price = $reserve_price;
                    }

                    $result[] = array(
                        'winner_number' => $i,
                        'winner_price' => $price,
                        'winner_userid' => $rows[0]['bid_buyersID'],
                        'winner_created' => $rows[0]['maxdate']
                    );
                } else {
                    foreach ($rows as $r) {

                        if ($r['maxval'] <= $temp_price) {
                            $price = $r['maxval'];
                        } else if ($r['maxval'] > $temp_price) {
                            if ($r['maxval'] < $highestBidValue) {
                                $price = $r['maxval'];
                            } else if ($r['maxval'] == $highestBidValue) {
                                $price = $temp_price;
                            }
                        }

                        $result[] = array(
                            'winner_number' => $i,
                            'winner_price' => $price,
                            'winner_userid' => $r['bid_buyersID'],
                            'winner_created' => $r['maxdate']
                        );
                        $i++;
                    }
                }
            }
        } catch (Exception $e) {
            
        }

        return json_encode(array('status' => $status, 'result' => $result));
    }

    public static function showWinnersWithPriceOfBuyers($p_id, $b_id) {
        $result = array();
        $status = 0;

        $winner_number = 1;

        try {
            $connection = Yii::app()->db;
            $command = $connection->createCommand('select product_winners, product_reserve_price, product_temp_current_price from tbl_product WHERE product_status=1 AND product_id=' . $p_id);
            $model = $command->queryRow();

            $no_of_winners = $model['product_winners'];
            $reserve_price = $model['product_reserve_price'];
            $temp_price = $model['product_temp_current_price'];

            $sql = 'SELECT b.bid_productID, b.bid_buyersID, max( b.bid_value ) maxval, max(b.bid_created) maxdate, p.product_bid_diff_price ';
            $sql .= ' FROM `tbl_bid` b';
            $sql .= ' INNER JOIN tbl_product p ON b.bid_productID = p.product_id';
            $sql .= ' WHERE `bid_productID` = ' . $p_id;
            $sql .= ' AND b.bid_value >= p.product_reserve_price';
            $sql .= ' GROUP BY b.bid_buyersID';
            $sql .= ' ORDER BY maxval DESC, maxdate ASC';
            $sql .= ' LIMIT ' . $no_of_winners;

            //echo $sql;

            $command = $connection->createCommand($sql);
            $rows = $command->queryAll();

            $num_rows = count($rows);
            if ($num_rows > 0) {
                $i = 1;
                $status = 1;
                $highestBidValue = $rows[0]['maxval'];

                if ($num_rows == 1) {

                    $price = $temp_price;
                    if ($reserve_price >= $temp_price) {
                        $price = $reserve_price;
                    }
                    if ($rows[0]['bid_buyersID'] == $b_id) {
                        $winner_number = $i;
                    }
                } else {
                    foreach ($rows as $r) {

                        if ($r['maxval'] <= $temp_price) {
                            $price = $r['maxval'];
                        } else if ($r['maxval'] > $temp_price) {
                            if ($r['maxval'] < $highestBidValue) {
                                $price = $r['maxval'];
                            } else if ($r['maxval'] == $highestBidValue) {
                                $price = $temp_price;
                            }
                        }
                        if ($r['bid_buyersID'] == $b_id) {
                            $winner_number = $i;
                        }

                        $i++;
                    }
                }
            }
        } catch (Exception $e) {
            
        }

        return $winner_number;
    }

    public function OngoingAuction($offset, $limit, $search) {

        $sql = 'select distinct product_id from tbl_bid b INNER JOIN tbl_product p ON b.bid_productID=p.product_id WHERE p.product_expiry_date > "' . date('Y-m-d H:i:s') . '"';

        if (!empty($search['p_id'])) {
            $p_id = $search['p_id'];
            $sql .= ' AND product_id=' . $p_id;
        } else if (!empty($search['p_name'])) {
            $p_name = $search['p_name'];
            $sql .= ' AND product_name LIKE "%' . $p_name . '%"';
        } else if (!empty($search['p_expiry'])) {
            $p_expiry = $search['p_expiry'];
            $sql .= ' AND product_expiry_date LIKE "%' . $p_expiry . '%"';
        } else if (!empty($search['sellers_id'])) {
            $p_sellers_id = $search['sellers_id'];
            $sql .= ' AND product_sellersID=' . $p_sellers_id;
        }

        $sql .= ' ORDER BY p.product_expiry_date DESC LIMIT ' . $offset . ', ' . $limit;
        
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $bids = $command->queryAll();

        $result = array();

        foreach ($bids as $bid) {
            $data = Product::model()->getSingleProduct($bid['product_id']);

            $result[] = array(
                'p_id' => $data['p_id'],
                'u_id' => $data['u_id'],
                'p_name' => $data['p_name'],
                'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                'p_winners' => $data['p_winners'],
                'p_biddiff' => $data['p_biddiff'],
                'p_current_price' => $data['p_price'],
                'p_buynow_price' => $data['p_buynow_price'],
                'p_reserve_price' => $data['p_reserve_price'],
                'p_shipping_price' => $data['p_shipping_price'],
                'p_expiry' => $data['p_expiry'],
                'p_expiry_date' => $data['p_expiry_date'],
                'bids' => Bid::model()->AdminGetBids($data['p_id'])
            );
        }

        return $result;
    }

    public function OngoingAuctionCount($search = NULL) {
        //$sql = 'select count(distinct product_id) from tbl_bid b INNER JOIN tbl_product p ON b.bid_productID=p.product_id WHERE p.product_expiry_date > "' . date('Y-m-d H:i:s') . '"';
        $sql = 'select count(distinct product_id) from tbl_bid b INNER JOIN tbl_product p ON b.bid_productID=p.product_id WHERE p.product_expiry_date > "' . date('Y-m-d H:i:s') . '"';

        if (!empty($search['p_id'])) {
            $p_id = $search['p_id'];
            $sql .= ' AND product_id=' . $p_id;
        } else if (!empty($search['p_name'])) {
            $p_name = $search['p_name'];
            $sql .= ' AND product_name LIKE "%' . $p_name . '%"';
        } else if (!empty($search['p_expiry'])) {
            $p_expiry = $search['p_expiry'];
            $sql .= ' AND product_expiry_date LIKE "%' . $p_expiry . '%"';
        } else if (!empty($search['sellers_id'])) {
            $p_sellers_id = $search['sellers_id'];
            $sql .= ' AND product_sellersID=' . $p_sellers_id;
        }

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $count = $command->queryScalar();

        return $count;
    }

    public function ClosedAuction($offset, $limit, $search) {

        //$sql = 'SELECT product_id FROM `tbl_product` WHERE product_expiry_date < "' . date('Y-m-d H:i:s') . '" ORDER BY `tbl_product`.`product_expiry_date` DESC LIMIT ' . $offset . ', ' . $limit;

        $sql = 'select product_id from tbl_product WHERE product_expiry_date < "' . date('Y-m-d H:i:s') . '"';

        if (!empty($search['p_id'])) {
            $p_id = $search['p_id'];
            $sql .= ' AND product_id=' . $p_id;
        } else if (!empty($search['p_name'])) {
            $p_name = $search['p_name'];
            $sql .= ' AND product_name LIKE "%' . $p_name . '%"';
        } else if (!empty($search['p_expiry'])) {
            $p_expiry = $search['p_expiry'];
            $sql .= ' AND product_expiry_date LIKE "%' . $p_expiry . '%"';
        } else if (!empty($search['sellers_id'])) {
            $p_sellers_id = $search['sellers_id'];
            $sql .= ' AND product_sellersID=' . $p_sellers_id;
        }

        $sql .= ' ORDER BY `tbl_product`.`product_expiry_date` DESC LIMIT ' . $offset . ', ' . $limit;

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $total = $command->queryAll();

        $result = array();

        foreach ($total as $bid) {
            $data = Product::model()->getSingleProduct($bid['product_id']);

            $result[] = array(
                'p_id' => $data['p_id'],
                'u_id' => $data['u_id'],
                'p_name' => $data['p_name'],
                'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                'p_winners' => $data['p_winners'],
                'p_biddiff' => $data['p_biddiff'],
                'p_current_price' => $data['p_price'],
                'p_buynow_price' => $data['p_buynow_price'],
                'p_reserve_price' => $data['p_reserve_price'],
                'p_shipping_price' => $data['p_shipping_price'],
                'p_expiry' => $data['p_expiry'],
                'p_expiry_date' => $data['p_expiry_date'],
                'bids' => Bid::model()->AdminGetBids($data['p_id'])
            );
        }

        return $result;
    }

    public function ClosedAuctionCount($search = NULL) {
        //$sql = 'SELECT count(product_id) FROM `tbl_product` WHERE product_expiry_date < "' . date('Y-m-d H:i:s') . '"';

        $sql = 'select count(product_id) from tbl_product WHERE product_expiry_date < "' . date('Y-m-d H:i:s') . '"';

        if (!empty($search['p_id'])) {
            $p_id = $search['p_id'];
            $sql .= ' AND product_id=' . $p_id;
        } else if (!empty($search['p_name'])) {
            $p_name = $search['p_name'];
            $sql .= ' AND product_name LIKE "%' . $p_name . '%"';
        } else if (!empty($search['p_expiry'])) {
            $p_expiry = $search['p_expiry'];
            $sql .= ' AND product_expiry_date LIKE "%' . $p_expiry . '%"';
        } else if (!empty($search['sellers_id'])) {
            $p_sellers_id = $search['sellers_id'];
            $sql .= ' AND product_sellersID=' . $p_sellers_id;
        }

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $count = $command->queryScalar();

        return $count;
    }

    public function getPaidUnpaidStatusOfAuction($offset, $limit, $search) {

        //$sql = 'SELECT product_id, product_winners FROM `tbl_product` p WHERE p.product_expiry_date <= "' . date('Y-m-d H:i:s') . '" ORDER BY p.`product_expiry_date` ASC';
        //$sql = 'SELECT product_id, product_winners FROM `tbl_product` p WHERE p.product_expiry_date <= "'. date('Y-m-d H:i:s') .'" ORDER BY p.`product_id` ASC';

        $sql = 'select product_id, product_winners from tbl_product WHERE product_expiry_date <= "' . date('Y-m-d H:i:s') . '"';

        if (!empty($search['p_id'])) {
            $p_id = $search['p_id'];
            $sql .= ' AND product_id=' . $p_id;
        } else if (!empty($search['p_name'])) {
            $p_name = $search['p_name'];
            $sql .= ' AND product_name LIKE "%' . $p_name . '%"';
        } else if (!empty($search['p_expiry'])) {
            $p_expiry = $search['p_expiry'];
            $sql .= ' AND product_expiry_date LIKE "%' . $p_expiry . '%"';
        } else if (!empty($search['sellers_id'])) {
            $p_sellers_id = $search['sellers_id'];
            $sql .= ' AND product_sellersID=' . $p_sellers_id;
        }

        $sql .= ' ORDER BY `tbl_product`.`product_expiry_date` DESC';

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $total = $command->queryAll();
        $total_unpaid = 0;
        $total_paid = 0;

        $product_array_paid = array();
        $product_array_unpaid = array();

        $i_paid = $i_unpaid = $j_paid = $j_unpaid = 0;

        foreach ($total as $single) {
            $winners = Bid::model()->showWinnersWithPrice($single['product_id']);
            $winners = json_decode($winners);

            if ($winners->status == 1) {
                //The Auction on which User is Winner
                $winner = "";
                $winner_array = array();
                foreach ($winners->result as $user) {
                    $winner .= $user->winner_userid . ",";
                    $winner_array[] = $user->winner_userid;
                }
                $winner = rtrim($winner, ',');

                $sql = 'SELECT p.payment_buyersID FROM `tbl_payment` p WHERE p.payment_productID=' . $single['product_id'] . ' AND p.payment_buyersID IN (' . $winner . ') AND p.payment_status="Completed"';
                $command = $connection->createCommand($sql);
                $records = $command->queryAll();

                $payment = array();
                foreach ($records as $record) {
                    $payment[] = $record['payment_buyersID'];
                }
                $unpaid = array_diff($winner_array, $payment);

                $data = Product::model()->getSingleProduct($single['product_id']);

                if (!empty($unpaid)) {
                    //echo "Unpaid - " . $single['product_id'] . "<br/>";                    
                    //echo "Unpaid - ".$i_paid.', '.$j_paid.', '.$offset.', '.$data['p_id'].'<br/>';
                    $total_unpaid++;
                    if ($i_unpaid >= $offset) {
                        if ($j_unpaid < $limit) {
                            $product_array_unpaid[] = array(
                                'paid' => $payment,
                                'unpaid' => $unpaid,
                                'winners' => $winners,
                                'data' => array(
                                    'p_id' => $data['p_id'],
                                    'p_slug' => $data['p_slug'],
                                    'u_id' => $data['u_id'],
                                    'p_name' => $data['p_name'],
                                    'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                    'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                    'p_winners' => $data['p_winners'],
                                    'p_biddiff' => $data['p_biddiff'],
                                    'p_current_price' => $data['p_price'],
                                    'p_buynow_price' => $data['p_buynow_price'],
                                    'p_shipping_price' => $data['p_shipping_price'],
                                    'p_reserve_price' => $data['p_reserve_price'],
                                    'p_expiry' => $data['p_expiry'],
                                    'p_expiry_date' => $data['p_expiry_date']
                                )
                            );
                            $j_unpaid++;
                        }
                    }
                    $i_unpaid++;
                }

                if (!empty($payment)) {
                    //echo "Paid - " . $single['product_id'] . "<br/>";
                    $total_paid++;
                    //echo "Paid - ".$i_paid.', '.$j_paid.', '.$offset.', '.$data['p_id'].'<br/>';                   
                    if ($i_paid >= $offset) {
                        if ($j_paid < $limit) {
                            $product_array_paid[] = array(
                                'paid' => $payment,
                                'unpaid' => $unpaid,
                                'winners' => $winners,
                                'data' => array(
                                    'p_id' => $data['p_id'],
                                    'p_slug' => $data['p_slug'],
                                    'u_id' => $data['u_id'],
                                    'p_name' => $data['p_name'],
                                    'p_desc' => substr(preg_replace('/(<br>)+$/', '', $data['p_desc']), 0, 220),
                                    'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                                    'p_winners' => $data['p_winners'],
                                    'p_biddiff' => $data['p_biddiff'],
                                    'p_current_price' => $data['p_price'],
                                    'p_buynow_price' => $data['p_buynow_price'],
                                    'p_shipping_price' => $data['p_shipping_price'],
                                    'p_reserve_price' => $data['p_reserve_price'],
                                    'p_expiry' => $data['p_expiry'],
                                    'p_expiry_date' => $data['p_expiry_date']
                                )
                            );
                            $j_paid++;
                        }
                    }
                    $i_paid++;
                }
            } else {
                //The Auction on which no User is Winner
            }
        }

        $result = array('total_unpaid' => $total_unpaid, 'total_paid' => $total_paid, 'product_array_paid' => $product_array_paid, 'product_array_unpaid' => $product_array_unpaid);
        return $result;
    }

    public function getPaidUnpaidStatusOfAuctionFORALL($offset, $limit, $search) {

        //$sql = 'SELECT product_id, product_winners FROM `tbl_product` p ORDER BY p.`product_expiry_date` ASC';
        //$sql = 'SELECT product_id, product_winners FROM `tbl_product` p ORDER BY p.`product_id` ASC';
        //$sql = 'SELECT product_id, product_winners FROM `tbl_product` p WHERE p.product_expiry_date <= "'. date('Y-m-d H:i:s') .'" ORDER BY p.`product_id` ASC';

        $sql = '';
//        print_r($search);
//        die;
        if (empty($search['p_id']) && empty($search['p_name']) && empty($search['p_expiry']) && empty($search['sellers_id'])) {
            $sql = 'select product_id, product_winners from tbl_product ';
        } else {
            $sql = 'select product_id, product_winners from tbl_product WHERE ';
        }

        if (!empty($search['p_id'])) {
            $p_id = $search['p_id'];
            $sql .= ' product_id=' . $p_id;
        } else if (!empty($search['p_name'])) {
            $p_name = $search['p_name'];
            if (!empty($search['p_id'])) {
                $sql .= ' AND product_name LIKE "%' . $p_name . '%"';
            } else {
                $sql .= 'product_name LIKE "%' . $p_name . '%"';
            }
        } else if (!empty($search['p_expiry'])) {
            $p_expiry = $search['p_expiry'];
            if (!empty($search['p_id'])) {
                $sql .= ' AND product_expiry_date LIKE "%' . $p_expiry . '%"';
            } else {
                if (!empty($search['p_name'])) {
                    $sql .= ' AND product_expiry_date LIKE "%' . $p_expiry . '%"';
                } else {
                    $sql .= ' product_expiry_date LIKE "%' . $p_expiry . '%"';
                }
            }
        } else if (!empty($search['sellers_id'])) {
            $p_sellers_id = $search['sellers_id'];
            if (!empty($search['p_id'])) {
                $sql .= ' AND product_sellersID=' . $p_sellers_id;
            } else {
                if (!empty($search['p_name'])) {
                    if (!empty($search['p_expiry'])) {
                        $sql .= ' AND product_sellersID=' . $p_sellers_id;
                    } else {
                        $sql .= ' product_sellersID=' . $p_sellers_id;
                    }
                } else {
                    $sql .= ' product_sellersID=' . $p_sellers_id;
                }
            }
        }

        $sql .= ' ORDER BY `tbl_product`.`product_id` DESC';

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $total = $command->queryAll();
        $totals = 0;

        $product_array_paid = array();
        $product_array_unpaid = array();

        $i_total = $j_total = 0;

        foreach ($total as $single) {
            $winners = Bid::model()->showWinnersWithPrice($single['product_id']);
            $winners = json_decode($winners);

            // echo "Product - " . $single['product_id'] . "<br/>";
            // echo "Winner Status - " . $winners->status . "<br/>";
            $data = Product::model()->getSingleProduct($single['product_id']);

            if ($winners->status == 1) {
                //The Auction on which User is Winner
                $winner = "";
                $winner_array = array();
                foreach ($winners->result as $user) {
                    $winner .= $user->winner_userid . ",";
                    $winner_array[] = $user->winner_userid;
                }
                $winner = rtrim($winner, ',');

                $sql = 'SELECT p.payment_buyersID FROM `tbl_payment` p WHERE p.payment_productID=' . $single['product_id'] . ' AND p.payment_buyersID IN (' . $winner . ') AND p.payment_status="Completed"';
                $command = $connection->createCommand($sql);
                $records = $command->queryAll();

                $payment = array();
                foreach ($records as $record) {
                    $payment[] = $record['payment_buyersID'];
                }
                $unpaid = array_diff($winner_array, $payment);
            }

            //echo "Product - ".$i_total.', '.$j_total.', '.$offset.', '.$data['p_id'].'<br/>';

            if ($i_total >= $offset) {
                if ($j_total < $limit) {
                    $product_array_total[] = array(
                        'paid' => $payment,
                        'unpaid' => $unpaid,
                        'winners' => $winners,
                        'data' => array(
                            'p_id' => $data['p_id'],
                            'p_slug' => $data['p_slug'],
                            'u_id' => $data['u_id'],
                            'p_name' => $data['p_name'],
                            'p_thumbs' => !empty($data['p_thumbs'][0]) ? $data['p_thumbs'][0] : '',
                            'p_winners' => $data['p_winners'],
                            'p_biddiff' => $data['p_biddiff'],
                            'p_current_price' => $data['p_price'],
                            'p_buynow_price' => $data['p_buynow_price'],
                            'p_shipping_price' => $data['p_shipping_price'],
                            'p_reserve_price' => $data['p_reserve_price'],
                            'p_expiry' => $data['p_expiry'],
                            'p_expiry_date' => $data['p_expiry_date']
                        )
                    );
                    $j_total++;
                }
            }
            $i_total++;

            $totals++;
        }

        //print_r($product_array_total);

        $result = array('totals' => $totals, 'product_array_total' => $product_array_total);
        return $result;
    }

    /*
     *
     * Get Leading Bidder Name for the Auction By Product ID
     * Developed By Aman Raikwar
     * Developed on 18 May 2015
     *  
     */

    public function getHighestBidderNickName($product_id) {

        $connection = Yii::app()->db;
        $command = $connection->createCommand('select product_winners, product_reserve_price, product_temp_current_price from tbl_product WHERE product_status=1 AND product_id=' . $product_id);
        $model = $command->queryRow();

        $no_of_winners = $model['product_winners'];
        $reserve_price = $model['product_reserve_price'];
        $temp_price = $model['product_temp_current_price'];

        $sql = 'SELECT b.bid_productID, b.bid_buyersID, max( b.bid_value ) maxval, max(b.bid_created) maxdate, p.product_bid_diff_price ';
        $sql .= ' FROM `tbl_bid` b';
        $sql .= ' INNER JOIN tbl_product p ON b.bid_productID = p.product_id';
        $sql .= ' WHERE `bid_productID` = ' . $product_id;
        //$sql .= ' AND b.bid_value >= p.product_reserve_price';
        $sql .= ' GROUP BY b.bid_buyersID';
        $sql .= ' ORDER BY maxval DESC, maxdate ASC';
        $sql .= ' LIMIT ' . $no_of_winners;

        //echo $sql;

        $command = $connection->createCommand($sql);
        $rows = $command->queryAll();
        $result = array();

        $num_rows = count($rows);
        if ($num_rows > 0) {
            $i = 1;
            $status = 1;
            $highestBidValue = $rows[0]['maxval'];

            if ($num_rows == 1) {

                $price = $temp_price;
                if ($reserve_price >= $temp_price) {
                    $price = $reserve_price;
                }

                $result[] = array(
                    'winner_number' => $i,
                    'winner_price' => $price,
                    'winner_userid' => $rows[0]['bid_buyersID'],
                    'winner_created' => $rows[0]['bid_created']
                );
            } else {
                foreach ($rows as $r) {

                    if ($r['maxval'] <= $temp_price) {
                        $price = $r['maxval'];
                    } else if ($r['maxval'] > $temp_price) {
                        if ($r['maxval'] < $highestBidValue) {
                            $price = $r['maxval'];
                        } else if ($r['maxval'] == $highestBidValue) {
                            $price = $temp_price;
                        }
                    }

                    $result[] = array(
                        'winner_number' => $i,
                        'winner_price' => $price,
                        'winner_userid' => $r['bid_buyersID'],
                        'winner_created' => $r['bid_created']
                    );
                    $i++;
                }
            }
        } else {
            $status = 0;
        }

        $nickname = '';
        $user_id = $result[0]['winner_userid'];
        $nickname = Buyers::model()->getUsername($user_id);
        return $nickname;
    }

}
