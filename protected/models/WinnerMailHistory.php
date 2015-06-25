<?php

/**
 * This is the model class for table "{{winner_mail_history}}".
 *
 * The followings are the available columns in table '{{winner_mail_history}}':
 * @property integer $history_id
 * @property integer $history_productID
 * @property integer $history_buyersID
 * @property string $history_description
 * @property string $history_message
 * @property string $history_created
 *
 * The followings are the available model relations:
 * @property Buyers $historyBuyers
 * @property Product $historyProduct
 */
class WinnerMailHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{winner_mail_history}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('history_productID, history_buyersID, history_description, history_message, history_created', 'required'),
			array('history_productID, history_buyersID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('history_id, history_productID, history_buyersID, history_description, history_message, history_created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'historyBuyers' => array(self::BELONGS_TO, 'Buyers', 'history_buyersID'),
			'historyProduct' => array(self::BELONGS_TO, 'Product', 'history_productID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'history_id' => 'History',
			'history_productID' => 'History Product',
			'history_buyersID' => 'History Buyers',
			'history_description' => 'History Description',
			'history_message' => 'History Message',
			'history_created' => 'History Created',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('history_id',$this->history_id);
		$criteria->compare('history_productID',$this->history_productID);
		$criteria->compare('history_buyersID',$this->history_buyersID);
		$criteria->compare('history_description',$this->history_description,true);
		$criteria->compare('history_message',$this->history_message,true);
		$criteria->compare('history_created',$this->history_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WinnerMailHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
