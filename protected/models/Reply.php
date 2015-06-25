<?php

/**
 * This is the model class for table "{{reply}}".
 *
 * The followings are the available columns in table '{{reply}}':
 * @property integer $reply_id
 * @property string $reply_message
 * @property string $reply_created
 * @property integer $reply_contactID
 *
 * The followings are the available model relations:
 * @property Contact $replyContact
 */
class Reply extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{reply}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('reply_message', 'required'),
            array('reply_contactID', 'numerical', 'integerOnly' => true),
            array('reply_message', 'length', 'max' => 1000),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('reply_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('reply_id, reply_message, reply_created, reply_contactID', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'replyContact' => array(self::BELONGS_TO, 'Contact', 'reply_contactID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'reply_id' => 'ID',
            'reply_message' => 'Message',
            'reply_created' => 'Created Date',
            'reply_contactID' => 'Message Subject',
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

        $criteria->compare('reply_id', $this->reply_id);
        $criteria->compare('reply_message', $this->reply_message, true);
        $criteria->compare('reply_created', $this->reply_created, true);
        $criteria->compare('reply_contactID', $this->reply_contactID);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Reply the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
