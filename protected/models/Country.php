<?php

/**
 * This is the model class for table "{{country}}".
 *
 * The followings are the available columns in table '{{country}}':
 * @property integer $country_id
 * @property string $country_name
 * @property string $country_created
 * @property string $country_updated
 * @property integer $country_status
 *
 * The followings are the available model relations:
 * @property State[] $states
 */
class Country extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{country}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('country_name', 'required', 'message' => 'Please enter {attribute}.'),
            array('country_name', 'unique', 'message' => 'This {attribute} is already in use.<br/> Please enter new {attribute}.'),
            array('country_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('country_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('country_id, country_name, country_created, country_updated, country_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'states' => array(self::HAS_MANY, 'State', 'state_countryID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'country_id' => 'ID',
            'country_name' => 'Country Name',
            'country_created' => 'Created Date',
            'country_updated' => 'Updated Date',
            'country_status' => 'Status',
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

        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('country_name', $this->country_name, true);
        $criteria->compare('country_created', $this->country_created, true);
        $criteria->compare('country_updated', $this->country_updated, true);
        $criteria->compare('country_status', $this->country_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'country_name ASC'
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
     * @return Country the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getCountryName($country_id) {
        $result = Country::model()->findByPk($country_id);
        return $result->country_name;
    }    

}
