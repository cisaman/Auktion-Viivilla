<?php

/**
 * This is the model class for table "{{sellers}}".
 *
 * The followings are the available columns in table '{{sellers}}':
 * @property integer $sellers_id
 * @property string $sellers_fname
 * @property string $sellers_lname
 * @property string $sellers_username
 * @property string $sellers_vatno
 * @property string $sellers_email
 * @property string $sellers_password
 * @property string $sellers_image
 * @property string $sellers_address
 * @property string $sellers_city
 * @property string $sellers_country
 * @property string $sellers_zipcode
 * @property string $sellers_contactno
 * @property integer $sellers_roleID
 * @property string $sellers_created
 * @property string $sellers_updated
 * @property integer $sellers_status
 * @property integer $sellers_website
 */
class Sellers extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{sellers}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sellers_fname,sellers_vatno, sellers_lname, sellers_username, sellers_email, sellers_password, sellers_address, sellers_city, sellers_country, sellers_zipcode, sellers_contactno', 'required'),
            array('sellers_roleID, sellers_status', 'numerical', 'integerOnly' => true),
            array('sellers_username', 'unique'),
            array('sellers_email', 'email'),
            array('sellers_fname, sellers_lname, sellers_email, sellers_contactno', 'length', 'max' => 255),
            array('sellers_username, sellers_city, sellers_country', 'length', 'max' => 100),
            array('sellers_address', 'length', 'max' => 500),
            array('sellers_zipcode', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('sellers_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('sellers_id, sellers_fname, sellers_lname, sellers_username, sellers_email, sellers_password, sellers_image, sellers_address, sellers_city, sellers_country, sellers_zipcode, sellers_contactno, sellers_roleID, sellers_created, sellers_updated, sellers_status', 'safe', 'on' => 'search'),
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
            'sellers_id' => 'ID',
            'sellers_fname' => 'First Name',
            'sellers_lname' => 'Last Name',
            'sellers_username' => 'Company',
            'sellers_vatno' => 'VAT Number',
            'sellers_email' => 'Email ID',
            'sellers_password' => 'Password',
            'sellers_image' => 'Profile Photo',
            'sellers_address' => 'Address',
            'sellers_city' => 'City',
            'sellers_country' => 'Country',
            'sellers_zipcode' => 'Zip Code',
            'sellers_contactno' => 'Contact Number',
            'sellers_roleID' => 'Role',
            'sellers_created' => 'Created Date',
            'sellers_updated' => 'Updated Date',
            'sellers_status' => 'Status',
            'sellers_website' => 'Website URL',
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

        $criteria->compare('sellers_id', $this->sellers_id);
        $criteria->compare('sellers_fname', $this->sellers_fname, true);
        $criteria->compare('sellers_lname', $this->sellers_lname, true);
        $criteria->compare('sellers_username', $this->sellers_username, true);
        $criteria->compare('sellers_email', $this->sellers_email, true);
        $criteria->compare('sellers_password', $this->sellers_password, true);
        $criteria->compare('sellers_image', $this->sellers_image, true);
        $criteria->compare('sellers_address', $this->sellers_address, true);
        $criteria->compare('sellers_city', $this->sellers_city, true);
        $criteria->compare('sellers_country', $this->sellers_country, true);
        $criteria->compare('sellers_zipcode', $this->sellers_zipcode, true);
        $criteria->compare('sellers_contactno', $this->sellers_contactno, true);
        $criteria->compare('sellers_roleID!', 1);
        $criteria->compare('sellers_roleID', $this->sellers_roleID);
        $criteria->compare('sellers_created', $this->sellers_created, true);
        $criteria->compare('sellers_updated', $this->sellers_updated, true);
        $criteria->compare('sellers_vatno', $this->sellers_vatno, TRUE);
        $criteria->compare('sellers_status', $this->sellers_status);

        $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'sellers_created DESC'
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
     * @return Sellers the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSellersProfile($id) {
        $result = $this->model()->findByPk(array('sellers_id' => $id), array('select' => 'sellers_fname, sellers_lname, sellers_image'));
        return $result;
    }

    public function getSellersFullName($id) {
        $result = $this->model()->findByPk(array('sellers_id' => $id), array('select' => 'sellers_fname, sellers_lname'));
        $name = $result->sellers_fname . ' ' . $result->sellers_lname;
        return ucwords($name);
    }

    public function getSellersUsername($id = NULL) {
        if (isset($id) && !empty($id)) {
            $result = $this->model()->findByPk(array('sellers_id' => $id), array('select' => 'sellers_username'));
            $name = $result->sellers_username;
            return $name;
        } else {
            //$model = $this->model()->findAll('sellers_id!=25', array('order' => 'sellers_username'));
            $model = $this->model()->findAll(array('order' => 'sellers_username', 'condition' => 'sellers_id!=:x', 'params' => array(':x' => '25')));
            foreach ($model as $m) {
                $result[$m->sellers_id] = $m->sellers_username;
            }
            return $result;
        }
    }

}
