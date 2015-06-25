<?php

/**
 * This is the model class for table "{{city}}".
 *
 * The followings are the available columns in table '{{city}}':
 * @property integer $city_id
 * @property string $city_name
 * @property integer $city_stateID
 * @property string $city_created
 * @property string $city_updated
 * @property integer $city_status
 *
 * The followings are the available model relations:
 * @property State $cityState
 */
class City extends CActiveRecord {

    public $state_countryID;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{city}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('city_stateID', 'required', 'message' => 'Please select {attribute}.'),
            array('city_name', 'required', 'message' => 'Please enter {attribute}.'),
            array('city_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('city_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('city_id, city_name, city_stateID, state_countryID, city_created, city_updated, city_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cityState' => array(self::BELONGS_TO, 'State', 'city_stateID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'city_id' => 'ID',
            'city_name' => 'City',
            'city_stateID' => 'State',
            'city_created' => 'Created Date',
            'city_updated' => 'Updated Date',
            'city_status' => 'Status',
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

        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('city_name', $this->city_name, true);
        $criteria->compare('city_stateID', $this->city_stateID);
        $criteria->compare('city_created', $this->city_created, true);
        $criteria->compare('city_updated', $this->city_updated, true);
        $criteria->compare('city_status', $this->city_status);

        
//        $criteria->alias = 'c';
//        $criteria->join = 'JOIN tbl_state s ON (c.city_stateID = s.state_id) JOIN tbl_country cc ON (cc.country_id = s.state_countryID)';
//        $criteria->addSearchCondition('state_countryID',$this->state_countryID) ;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'city_stateID ASC, city_name ASC'
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
     * @return City the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
