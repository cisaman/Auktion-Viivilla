<?php

/**
 * This is the model class for table "{{log}}".
 *
 * The followings are the available columns in table '{{log}}':
 * @property integer $log_id
 * @property string $log_name
 * @property string $log_userid
 * @property string $log_productid
 * @property string $log_desc
 * @property string $log_created
 */
class Log extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('log_name, log_desc', 'required'),
            array('log_name', 'length', 'max' => 500),
            array('log_userid, log_productid', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('log_id, log_name, log_userid, log_productid, log_desc, log_created', 'safe', 'on' => 'search'),
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
            'log_id' => 'ID',
            'log_name' => 'Name',
            'log_userid' => 'Buyer ID',
            'log_productid' => 'Product ID',
            'log_desc' => 'Description',
            'log_created' => 'Created Date',
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

        $criteria->compare('log_id', $this->log_id);
        $criteria->compare('log_name', $this->log_name, true);
        $criteria->compare('log_userid', $this->log_userid, true);
        $criteria->compare('log_productid', $this->log_productid, true);
        $criteria->compare('log_desc', $this->log_desc, true);
        $criteria->compare('log_created', $this->log_created, true);

        $limit = isset($_GET['limit']) ? $_GET['limit'] : 20;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'log_id DESC'
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
     * @return Log the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function createLog($logdata) {
        try {
            $log = new Log;
            $log->log_name = $logdata['title'];
            $log->log_userid = $logdata['userid'];
            $log->log_usertype = empty($logdata['usertype']) ? 3 : $logdata['usertype'];
            $log->log_productid = $logdata['productid'];
            $log->log_desc = $logdata['message'];
            $log->log_created = date('Y-m-d H:i:s');
            $log->save();
        } catch (Exception $e) {
            
        }
    }

}
