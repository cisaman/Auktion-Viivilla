<?php

/**
 * This is the model class for table "{{contact}}".
 *
 * The followings are the available columns in table '{{contact}}':
 * @property integer $contact_id
 * @property string $contact_name
 * @property string $contact_email
 * @property string $contact_subject
 * @property string $contact_message
 * @property string $contact_created
 * @property string $contact_updated
 * @property integer $contact_status
 */
class Contact extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{contact}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public $verifyCode;

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('contact_name, contact_email', 'required', 'message' => Yii::t('lang', 'please_enter') . ' {attribute}.'),
            array('contact_email', 'email', 'message' => Yii::t('lang', 'invalid_emailid')),
            array('contact_name, contact_email', 'length', 'max' => 100),
            array('contact_subject', 'length', 'max' => 255),
            array('contact_message', 'length', 'max' => 500),
            //array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
            array('verifyCode', 'captcha'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('contact_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('contact_id, contact_name, contact_email, contact_subject, contact_message, contact_created, contact_updated, contact_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'contact_id' => 'ID',
            'contact_name' => Yii::t('lang', 'name'),
            'contact_email' => Yii::t('lang', 'email_id'),
            'contact_subject' => 'Subject',
            'contact_message' => 'Message',
            'contact_productID' => 'Product Name',
            'contact_created' => 'Created Date',
            'contact_updated' => 'Updated Date',
            'contact_status' => 'Status',
            'verifyCode' => "Verify Code",
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

        $criteria->compare('contact_id', $this->contact_id);
        $criteria->compare('contact_name', $this->contact_name, true);
        $criteria->compare('contact_email', $this->contact_email, true);
        $criteria->compare('contact_subject', $this->contact_subject, true);
        $criteria->compare('contact_message', $this->contact_message, true);
        $criteria->compare('contact_created', $this->contact_created, true);
        $criteria->compare('contact_updated', $this->contact_updated, true);
        $criteria->compare('contact_status', $this->contact_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'contact_created DESC'
            ),
            'Pagination' => array(
                'PageSize' => 20
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Contact the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
