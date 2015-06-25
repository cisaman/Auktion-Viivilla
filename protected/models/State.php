<?php

/**
 * This is the model class for table "{{state}}".
 *
 * The followings are the available columns in table '{{state}}':
 * @property integer $state_id
 * @property string $state_name
 * @property integer $state_countryID
 * @property string $state_created
 * @property string $state_updated
 * @property integer $state_status
 *
 * The followings are the available model relations:
 * @property City[] $cities
 * @property Country $stateCountry
 */
class State extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{state}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('state_countryID', 'required', 'message' => 'Please select {attribute}.'),
            array('state_name', 'required', 'message' => 'Please enter {attribute}.'),
            array('state_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('state_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('state_id, state_name, state_countryID, state_created, state_updated, state_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cities' => array(self::HAS_MANY, 'City', 'city_stateID'),
            'stateCountry' => array(self::BELONGS_TO, 'Country', 'state_countryID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'state_id' => 'ID',
            'state_name' => 'State',
            'state_countryID' => 'Country',
            'state_created' => 'Created Date',
            'state_updated' => 'Updated Date',
            'state_status' => 'Status',
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

        $criteria->compare('state_id', $this->state_id);
        $criteria->compare('state_name', $this->state_name, true);
        $criteria->compare('state_countryID', $this->state_countryID);
        $criteria->compare('state_created', $this->state_created, true);
        $criteria->compare('state_updated', $this->state_updated, true);
        $criteria->compare('state_status', $this->state_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'state_countryID ASC, state_name ASC'
            ),
            'Pagination' => array(
                'PageSize' => 50
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return State the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getStateName($state_id) {
        $result = State::model()->findByPk($state_id);
        return $result->state_name;
    }

    public static function getCountryNameByStateID($state_id) {
        $state = State::model()->findByPk($state_id);
        $country = Country::model()->findByPk($state->state_countryID);
        return $country->country_name;
    }

}
