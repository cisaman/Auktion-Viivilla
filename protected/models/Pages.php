<?php

/**
 * This is the model class for table "{{pages}}".
 *
 * The followings are the available columns in table '{{pages}}':
 * @property integer $page_id
 * @property string $page_name
 * @property string $page_content
 * @property string $page_created
 * @property string $page_updated
 * @property integer $page_status
 */
class Pages extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{pages}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('page_name', 'required', 'message' => Yii::t('lang', 'please_enter') . ' {attribute}.'),
            array('page_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('page_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('page_id, page_name, page_content, page_created, page_updated, page_status', 'safe', 'on' => 'search'),
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
            'page_id' => 'ID',
            'page_name' => Yii::t('lang', 'page'),
            'page_content' => Yii::t('lang', 'description'),
            'page_created' => Yii::t('lang', 'created') . ' ' . Yii::t('lang', 'date'),
            'page_updated' => Yii::t('lang', 'updated') . ' ' . Yii::t('lang', 'date'),
            'page_status' => Yii::t('lang', 'status'),
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

        $criteria->compare('page_id', $this->page_id);
        $criteria->compare('page_name', $this->page_name, true);
        $criteria->compare('page_content', $this->page_content, true);
        $criteria->compare('page_created', $this->page_created, true);
        $criteria->compare('page_updated', $this->page_updated, true);
        $criteria->compare('page_status', $this->page_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'page_created desc'
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
     * @return Pages the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
