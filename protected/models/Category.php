<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $category_id
 * @property string $category_name
 * @property string $category_created
 * @property string $category_updated
 * @property integer $category_status
 */
class Category extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_name', 'required', 'message' => Yii::t('lang', 'please_enter') . ' {attribute}.'),
            //array('category_name', 'required'),
            array('category_name', 'unique', 'message' => 'This {attribute} is already in use.<br/> ' . Yii::t('lang', 'please_enter') . ' new {attribute}.'),
            array('category_name', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('category_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('category_id, category_name, category_created, category_updated, category_status', 'safe', 'on' => 'search'),
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
            'category_id' => 'ID',
            'category_name' => Yii::t('lang', 'category') . ' ' . Yii::t('lang', 'name'),
            'category_created' => Yii::t('lang', 'created') . ' ' . Yii::t('lang', 'date'),
            'category_updated' => Yii::t('lang', 'updated') . ' ' . Yii::t('lang', 'date'),
            'category_status' => Yii::t('lang', 'status'),
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

        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('category_name', $this->category_name, true);
        $criteria->compare('category_created', $this->category_created, true);
        $criteria->compare('category_updated', $this->category_updated, true);
        $criteria->compare('category_status', $this->category_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'category_name ASC'
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
     * @return Category the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getCategoryNameByID($id) {
        $result = Category::model()->findByPk($id)->category_name;
        return $result;
    }

}
