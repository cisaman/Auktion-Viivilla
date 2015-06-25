<?php

/**
 * This is the model class for table "{{lang}}".
 *
 * The followings are the available columns in table '{{lang}}':
 * @property integer $lang_id
 * @property string $lang_shortcode
 * @property string $lang_attribute
 * @property string $lang_attribute_t
 * @property string $lang_created
 * @property string $lang_updated
 */
class Lang extends CActiveRecord {

    public $language_code, $en_t, $sv_t;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{lang}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lang_attribute, en_t, sv_t', 'required'),
            array('lang_attribute', 'length', 'max' => 512),
            array('lang_attribute_t', 'length', 'max' => 1000),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('lang_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('lang_id, language_code, lang_shortcode, lang_attribute, lang_attribute_t, lang_created, lang_updated', 'safe', 'on' => 'search'),
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
            'lang_id' => 'ID',
            'lang_shortcode' => 'Language Shortcode',
            'lang_attribute' => 'Language Attribute',
            'lang_attribute_t' => 'Language Attribute Translation',
            'lang_created' => 'Created Date',
            'lang_updated' => 'Updated Date',
            'language_code' => 'Language',
            'en_t' => 'English Translation',
            'sv_t' => 'Swedish Translation',
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
        $criteria->compare('lang_shortcode', $this->lang_shortcode, true);
        $criteria->compare('lang_attribute', $this->lang_attribute, true);
        $criteria->compare('lang_attribute_t', $this->lang_attribute_t, true);
        $criteria->compare('lang_created', $this->lang_created, true);
        $criteria->compare('lang_updated', $this->lang_updated, true);
        $criteria->compare('lang_shortcode', $this->language_code, TRUE);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'lang_attribute ASC'
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
     * @return Lang the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
