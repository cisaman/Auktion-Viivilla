<?php

/**
 * This is the model class for table "{{invoice}}".
 *
 * The followings are the available columns in table '{{invoice}}':
 * @property integer $invoice_id
 * @property string $invoice_alias
 * @property string $invoice_title 
 * @property string $invoice_content
 * @property string $invoice_parameters
 * @property string $invoice_created
 * @property string $invoice_updated
 * @property integer $invoice_status
 */
class Invoice extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{invoice}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('invoice_alias, invoice_title, invoice_content, invoice_parameters', 'required'),
            array('invoice_status', 'numerical', 'integerOnly' => true),
            array('invoice_alias, invoice_title', 'length', 'max' => 255),
            array('invoice_parameters', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('invoice_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('invoice_id, invoice_alias, invoice_title, invoice_content, invoice_parameters, invoice_created, invoice_updated, invoice_status', 'safe', 'on' => 'search'),
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
            'invoice_id' => 'ID',
            'invoice_alias' => 'Alias',
            'invoice_title' => 'Title',
            'invoice_content' => 'Content',
            'invoice_parameters' => 'Parameters',
            'invoice_created' => 'Created Date',
            'invoice_updated' => 'Updated Date',
            'invoice_status' => 'Status',
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

        $criteria->compare('invoice_id', $this->invoice_id);
        $criteria->compare('invoice_alias', $this->invoice_alias, true);
        $criteria->compare('invoice_title', $this->invoice_title, true);
        $criteria->compare('invoice_content', $this->invoice_content, true);
        $criteria->compare('invoice_parameters', $this->invoice_parameters, true);
        $criteria->compare('invoice_created', $this->invoice_created, true);
        $criteria->compare('invoice_updated', $this->invoice_updated, true);
        $criteria->compare('invoice_status', $this->invoice_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Invoice the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
