<?php

/**
 * This is the model class for table "{{payment}}".
 *
 * The followings are the available columns in table '{{payment}}':
 * @property integer $payment_id
 * @property integer $payment_productID
 * @property integer $payment_buyersID
 * @property string $payment_amount
 * @property string $payment_payer_id
 * @property string $payment_payer_email
 * @property string $payment_date
 * @property string $payment_status
 * @property string $payment_transaction_id
 * @property string $payment_invoiceno
 * @property string $payment_created
 *
 * The followings are the available model relations:
 * @property User $paymentUser
 * @property Product $paymentProduct
 */
class Payment extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{payment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('payment_productID, payment_buyersID, payment_amount, payment_payer_id, payment_payer_email, payment_date, payment_status, payment_transaction_id', 'required'),
//            array('payment_productID, payment_buyersID', 'numerical', 'integerOnly' => true),
//            array('payment_amount', 'length', 'max' => 100),
//            array('payment_payer_id, payment_payer_email, payment_date, payment_status, payment_transaction_id', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('payment_id, payment_productID, payment_buyersID, payment_invoiceno, payment_amount, payment_payer_id, payment_payer_email, payment_date, payment_status, payment_transaction_id, payment_gateway, payment_type,  payment_created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'paymentUser' => array(self::BELONGS_TO, 'Buyers', 'payment_buyersID'),
            'paymentProduct' => array(self::BELONGS_TO, 'Product', 'payment_productID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'payment_id' => 'ID',
            'payment_productID' => 'Product',
            'payment_buyersID' => 'Nick Name',
            'payment_amount' => 'Credit Amount',
            'payment_payer_id' => 'Payer ID',
            'payment_payer_email' => 'Payer Email',
            'payment_date' => 'Payment Date',
            'payment_status' => 'Payment Status',
            'payment_transaction_id' => 'Transaction ID',
            'payment_invoiceno' => 'Invoice#',
            'payment_gateway' => 'Gateway',
            'payment_type' => 'Credit/Refund',
            'payment_refund_invoiceno' => 'Parent Invoice No',
            'payment_created' => 'Payment Date/Time',
            'payment_refund' => 'Refund Amount',
            'payment_remark' => 'Remark(if any)',
            'payment_refunddate' => 'Refund Date/TIme',
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

        $criteria->compare('payment_id', $this->payment_id);
        $criteria->compare('payment_productID', $this->payment_productID);
        $criteria->compare('payment_buyersID', $this->payment_buyersID);
        $criteria->compare('payment_amount', $this->payment_amount, true);
        $criteria->compare('payment_payer_id', $this->payment_payer_id, true);
        $criteria->compare('payment_payer_email', $this->payment_payer_email, true);
        $criteria->compare('payment_date', $this->payment_date, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_transaction_id', $this->payment_transaction_id, true);
        $criteria->compare('payment_invoiceno', $this->payment_invoiceno, true);
        $criteria->compare('payment_gateway', $this->payment_gateway, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('payment_created', $this->payment_created, true);

        $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'payment_id DESC'
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
     * @return Payment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function checkForRefundButton($pid, $uid) {
        $model = Payment::model()->findByAttributes(array('payment_productID' => $pid, 'payment_buyersID' => $uid, 'payment_type' => '0'));
        if (count($model) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
