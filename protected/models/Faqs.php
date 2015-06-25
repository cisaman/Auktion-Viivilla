<?php

/**
 * This is the model class for table "{{faqs}}".
 *
 * The followings are the available columns in table '{{faqs}}':
 * @property integer $faqs_id
 * @property string $faqs_ques
 * @property string $faqs_ans
 * @property integer $faqs_status
 */
class Faqs extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{faqs}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('faqs_ques', 'required', 'message' => Yii::t('lang', 'please_enter') . ' {attribute}.'),
            array('faqs_status', 'numerical', 'integerOnly' => true),
            array('faqs_ques', 'length', 'max' => 500),            
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('faqs_id, faqs_ques, faqs_ans, faqs_status', 'safe', 'on' => 'search'),
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
            'faqs_id' => Yii::t('lang', 'id'),
            'faqs_ques' => Yii::t('lang', 'question'),
            'faqs_ans' => Yii::t('lang', 'answer'),
            'faqs_status' => Yii::t('lang', 'status'),
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

        $criteria->compare('faqs_id', $this->faqs_id);
        $criteria->compare('faqs_ques', $this->faqs_ques, true);
        $criteria->compare('faqs_ans', $this->faqs_ans, true);
        $criteria->compare('faqs_status', $this->faqs_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'faqs_ques ASC'
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
     * @return Faqs the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
