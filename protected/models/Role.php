<?php

/**
 * This is the model class for table "{{role}}".
 *
 * The followings are the available columns in table '{{role}}':
 * @property integer $role_id
 * @property string $role_name
 * @property string $role_created
 * @property string $role_modified
 * @property integer $role_status
 */
class Role extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{role}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('role_name, role_created, role_modified', 'required'),
            array('role_status', 'numerical', 'integerOnly' => true),
            array('role_name', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('role_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('role_id, role_name, role_created, role_modified, role_status', 'safe', 'on' => 'search'),
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
            'role_id' => 'Role',
            'role_name' => 'Role Name',
            'role_created' => 'Role Created',
            'role_modified' => 'Role Modified',
            'role_status' => 'Role Status',
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

        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('role_name', $this->role_name, true);
        $criteria->compare('role_created', $this->role_created, true);
        $criteria->compare('role_modified', $this->role_modified, true);
        $criteria->compare('role_status', $this->role_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Role the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getRolesExceptUser() {
        $result = $this->model()->findAll('role_id!=3');
        return $result;
    }

    public function getRoleNamebyID($role_id) {
        $result = $this->model()->find('role_id=' . $role_id);
        $role_name = $result->role_name;
        return $role_name;
    }

}
