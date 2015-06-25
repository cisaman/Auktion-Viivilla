<?php

/**
 * This is the model class for table "{{languages}}".
 *
 * The followings are the available columns in table '{{languages}}':
 * @property integer $lang_id
 * @property string $lang_name
 * @property string $lang_code
 */
class Languages extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{languages}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lang_name, lang_code', 'required'),
            array('lang_name, lang_code', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('lang_id, lang_name, lang_code', 'safe', 'on' => 'search'),
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
            'lang_id' => 'Lang',
            'lang_name' => 'Lang Name',
            'lang_code' => 'Lang Code',
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

        $criteria->compare('lang_id', $this->lang_id);
        $criteria->compare('lang_name', $this->lang_name, true);
        $criteria->compare('lang_code', $this->lang_code, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Languages the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getLanguageNameByCode($code) {
        $result = Languages::model()->findByAttributes(array('lang_code' => $code));
        return $result->lang_name;
    }

}
