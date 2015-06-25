<?php

/**
 * This is the model class for table "{{buyers}}".
 *
 * The followings are the available columns in table '{{buyers}}':
 * @property integer $buyers_id
 * @property string $buyers_fname
 * @property string $buyers_lname
 * @property string $buyers_nickname
 * @property string $buyers_email
 * @property string $buyers_password
 * @property string $buyers_gender
 * @property string $buyers_dob
 * @property string $buyers_image
 * @property string $buyers_address
 * @property string $buyers_city
 * @property string $buyers_country
 * @property string $buyers_zipcode
 * @property string $buyers_contactno
 * @property string $buyers_jobtitle
 * @property string $buyers_summary
 * @property string $buyers_website
 * @property string $buyers_facebook
 * @property string $buyers_twitter
 * @property string $buyers_linkedin
 * @property string $buyers_skype
 * @property string $buyers_registertype
 * @property string $buyers_token
 * @property integer $buyers_roleID
 * @property string $buyers_lastlogin
 * @property integer $buyers_newsletter
 * @property string $buyers_created
 * @property string $buyers_updated
 * @property integer $buyers_status
 *
 * The followings are the available model relations:
 * @property Role $buyersRole
 */
class Buyers extends CActiveRecord {

    public $rememberMe;
    public $buyers_confirmpassword;
    public $buyers_location;
    public $buyers_agree;
    public $password_real, $password_repeat, $password_new;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{buyers}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('buyers_fname, buyers_lname, buyers_nickname, buyers_address, buyers_city', 'required', 'on' => 'register', 'message' => Yii::t('lang', 'please_enter') . ' {attribute}.'),
            array('buyers_roleID, buyers_newsletter, buyers_status', 'numerical', 'integerOnly' => true),
            array('buyers_fname, buyers_lname, buyers_nickname, buyers_image, buyers_city, buyers_country, buyers_contactno, buyers_website, buyers_facebook, buyers_twitter, buyers_linkedin, buyers_skype, buyers_registertype', 'length', 'max' => 100),
            array('buyers_address, buyers_jobtitle', 'length', 'max' => 255),
            array('buyers_gender', 'length', 'max' => 1),
            array('buyers_dob, buyers_zipcode', 'length', 'max' => 50),
            array('buyers_summary, buyers_token', 'length', 'max' => 500),
            //For Email
            array('buyers_email', 'required', 'on' => 'register, login', 'message' => Yii::t('lang', 'please_enter') . ' {attribute}.'),
            array('buyers_email, buyers_nickname', 'unique'),
            array('buyers_email', 'email', 'on' => 'register'),
            //For Date of Birth
            array('buyers_dob', 'type', 'type' => 'date', 'message' => 'Please enter a valid date.<br/>Please use this format for {attribute} : YYYY-MM-DD', 'dateFormat' => 'yyyy-MM-dd', 'on' => 'register'),
            //I agree Terms and Conditions            
            array('buyers_agree', 'required', 'requiredValue' => 1, 'on' => 'register', 'message' => 'Vänligen godkänd auktionsvillkoren för att gå vidare'),
            //For Password and Confirm Password
            array('buyers_password', 'required', 'on' => 'login'),
            array('password_real, password_repeat,', 'required', 'on' => 'register'),
            array('password_repeat', 'compare', 'compareAttribute' => 'password_real', 'on' => 'register', 'message' => 'Lösenordet måste vara identiskt.'),
            array('password_real', 'strongPassword', 'on' => array('register')),
            //For Contact No
            //array('buyers_contactno', 'required', 'on' => 'register'),
//            array('buyers_contactno', 'numberValidationForContact', 'on' => 'register', 'allowEmpty' => TRUE),
//            array('buyers_contactno', 'numberValidationForContact', 'allowEmpty' => TRUE),
            //For Address
            array('buyers_address, buyers_location,buyers_zipcode,buyers_contactno ', 'required', 'on' => 'register'),
            //For Zip
            //array('buyers_zipcode', 'required', 'on' => 'register'),
//            array('buyers_zipcode', 'numberValidationForZip', 'on' => 'register'),
//            array('buyers_zipcode', 'default', 'setOnEmpty' => true, 'value' => ''),
//            array('buyers_zipcode', 'numberValidationForZip'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('buyers_created', 'default', 'value' => date("Y-m-d H:i:s")),
            array('buyers_id, buyers_fname, buyers_lname, buyers_nickname, buyers_email, buyers_password, buyers_gender, buyers_dob, buyers_image, buyers_address, buyers_city, buyers_country, buyers_zipcode, buyers_contactno, buyers_jobtitle, buyers_summary, buyers_website, buyers_facebook, buyers_twitter, buyers_linkedin, buyers_skype, buyers_registertype, buyers_token, buyers_roleID, buyers_lastlogin, buyers_newsletter, buyers_created, buyers_updated, buyers_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'buyersRole' => array(self::BELONGS_TO, 'Role', 'buyers_roleID'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'buyers_id' => Yii::t('lang', 'id'),
            'buyers_fname' => Yii::t('lang', 'first_name'),
            'buyers_lname' => Yii::t('lang', 'last_name'),
            'buyers_nickname' => Yii::t('lang', 'nick_name'),
            'buyers_email' => Yii::t('lang', 'email_id'),
            'buyers_password' => Yii::t('lang', 'password'),
            'buyers_gender' => Yii::t('lang', 'gender'),
            'buyers_dob' => Yii::t('lang', 'dob'),
            'buyers_image' => Yii::t('lang', 'profile_photo'),
            'buyers_address' => Yii::t('lang', 'address'),
            'buyers_city' => Yii::t('lang', 'city'),
            'buyers_country' => Yii::t('lang', 'country'),
            'buyers_zipcode' => Yii::t('lang', 'zip_code'),
            'buyers_contactno' => Yii::t('lang', 'phone'),
            'buyers_jobtitle' => Yii::t('lang', 'job_title'),
            'buyers_summary' => Yii::t('lang', 'summary'),
            'buyers_website' => Yii::t('lang', 'website'),
            'buyers_facebook' => Yii::t('lang', 'facebook'),
            'buyers_twitter' => Yii::t('lang', 'twitter'),
            'buyers_linkedin' => Yii::t('lang', 'linkedin'),
            'buyers_skype' => Yii::t('lang', 'skype'),
            'buyers_registertype' => 'Register Type',
            'buyers_token' => 'Token',
            'buyers_roleID' => 'Role',
            'buyers_lastlogin' => 'Last Login',
            'buyers_newsletter' => 'Subscribe for Newsletter',
            'buyers_created' => 'Created Date',
            'buyers_updated' => 'Updated Date',
            'buyers_status' => 'Status',
            'buyers_agree' => Yii::t('lang', 'accept_policy'),
            'buyers_location' => Yii::t('lang', 'location'),
            'password_real' => Yii::t('lang', 'password'),
            'password_repeat' => Yii::t('lang', 'repeat_password'),
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

        $criteria->compare('buyers_id', $this->buyers_id);
        $criteria->compare('buyers_fname', $this->buyers_fname, true);
        $criteria->compare('buyers_lname', $this->buyers_lname, true);
        $criteria->compare('buyers_nickname', $this->buyers_nickname, true);
        $criteria->compare('buyers_email', $this->buyers_email, true);
        $criteria->compare('buyers_password', $this->buyers_password, true);
        $criteria->compare('buyers_gender', $this->buyers_gender, true);
        $criteria->compare('buyers_dob', $this->buyers_dob, true);
        $criteria->compare('buyers_image', $this->buyers_image, true);
        $criteria->compare('buyers_address', $this->buyers_address, true);
        $criteria->compare('buyers_city', $this->buyers_city, true);
        $criteria->compare('buyers_country', $this->buyers_country, true);
        $criteria->compare('buyers_zipcode', $this->buyers_zipcode, true);
        $criteria->compare('buyers_contactno', $this->buyers_contactno, true);
        $criteria->compare('buyers_jobtitle', $this->buyers_jobtitle, true);
        $criteria->compare('buyers_summary', $this->buyers_summary, true);
        $criteria->compare('buyers_website', $this->buyers_website, true);
        $criteria->compare('buyers_facebook', $this->buyers_facebook, true);
        $criteria->compare('buyers_twitter', $this->buyers_twitter, true);
        $criteria->compare('buyers_linkedin', $this->buyers_linkedin, true);
        $criteria->compare('buyers_skype', $this->buyers_skype, true);
        $criteria->compare('buyers_registertype', $this->buyers_registertype, true);
        $criteria->compare('buyers_token', $this->buyers_token, true);
        $criteria->compare('buyers_roleID', $this->buyers_roleID);
        $criteria->compare('buyers_lastlogin', $this->buyers_lastlogin, true);
        $criteria->compare('buyers_newsletter', $this->buyers_newsletter);
        $criteria->compare('buyers_created', $this->buyers_created, true);
        $criteria->compare('buyers_updated', $this->buyers_updated, true);
        $criteria->compare('buyers_status', $this->buyers_status);

        $limit = isset($_GET['limit']) ? $_GET['limit'] : 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'buyers_created ASC'
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
     * @return Buyers the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function strongPassword($attribute) {
        $d = '/[0-9]/';  //numbers
        $c = '/[A-Z]/'; //capital letter
        $s = '/[._#$%&*@!~?]/'; // contain one symbol
        if (preg_match_all($d, $this->password_real, $o) < 1) {
            $this->addError($attribute, 'Lösenordet måste innehålla minst en siffra.');
        } else if (preg_match_all($c, $this->password_real, $o) < 1) {
            $this->addError($attribute, 'Lösenord måste innehålla minst en stor bokstav.');
        } else if (preg_match_all($s, $this->password_real, $o) < 1) {
            $this->addError($attribute, 'Lösenordet måste innehålla något av följande tecken (. _ # $% & * @! ~?).');
        } else if (strlen(trim($this->password_real)) < 6) {
            $this->addError($attribute, 'Lösenord måste bestå minst sex bokstäver.');
        }
    }

    public function numberValidationForContact($attribute) {
        $d = '/[0-9]/';  //numbers        

        if (preg_match_all($d, $this->buyers_contactno, $o) < 1) {
            $this->addError($attribute, 'Phone must be numeric.');
        }
    }

    public function numberValidationForZip($attribute) {
        $d = '/[0-9]/';  //numbers

        if (preg_match_all($d, $this->buyers_zipcode, $o) < 1) {
            $this->addError($attribute, 'Zip Code must be numeric.');
        }
    }

    public function getGenderOptions() {
        return array(
            'M' => Yii::t('lang', 'male'),
            'F' => Yii::t('lang', 'female'),
        );
    }

    public function getProfile($id) {
        $result = Buyers::model()->findByPk(array('buyers_id' => $id), array('select' => 'buyers_fname, buyers_lname, buyers_gender, buyers_image'));
        return $result;
    }

    public function getFullName($id) {
        $result = Buyers::model()->findByPk(array('buyers_id' => $id), array('select' => 'buyers_fname, buyers_lname'));
        $name = $result->buyers_fname . ' ' . $result->buyers_lname;
        return ucwords($name);
    }

    public function getUsername($id) {
        $result = Buyers::model()->findByPk(array('buyers_id' => $id), array('select' => 'buyers_nickname'));
        $name = $result->buyers_nickname;
        return $name;
    }

    public function getListWithoutSuperAdmin() {
        $result = $this->model()->findAll('buyers_id!=1', array('select' => 'buyers_id, user_firstname, user_lastname'));

        foreach ($result as $r) {
            $select[$r->buyers_id] = $r->user_firstname . ' ' . $r->user_lastname;
        }

        return $select;
    }

    public function getPasswordEncrypted($password) {
        $utils = new Utils;
        return $utils->passwordEncrypt($password);
    }

    public function getPasswordDecrypted($password) {
        $utils = new Utils;
        return $utils->passwordDecrypt($password);
    }

    public function setSession($buyers_id) {
        //echo $buyers_id;die;
        $user_role_id = 3;
        $user_role_name = 'User';

        $session_data = array();
        $session_data['buyers_id'] = $buyers_id;
        $session_data['user_role_id'] = $user_role_id;
        $session_data['user_role_name'] = $user_role_name;
        Yii::app()->user->name = $user_role_name;
        Yii::app()->session['user_data'] = $session_data;

//        $f = Buyers::model()->findByPk($buyers_id);
//        $f->buyers_lastlogin = date('Y-m-d H:i:s');
//        $f->update();
    }

    public function getSingleUser($id) {
        $user = Buyers::model()->findByPk($id);

        /* Count total Products by the Same User who's Product we are viewing */
        $total_product = Product::model()->count('product_buyersID=' . $user->buyers_id);

        /* User Image for Seller Details */
        if (!empty($user->buyers_image)) {
            $user_image = Utils::UserThumbnailImagePath() . $user->buyers_image;
        } else {
            if (!empty($user->buyers_gender)) {
                if ($user->buyers_gender == 'M') {
                    $user_image = Utils::UserImagePath_M();
                } else {
                    $user_image = Utils::UserImagePath_F();
                }
            } else {
                $user_image = Utils::UserImagePath_M();
            }
        }

        /* Create Slug for URL */
        $u_slug = strtolower(str_replace(' ', '-', $user->user_firstname . ' ' . $user->user_lastname));

        $result = array(
            'u_id' => $user->buyers_id,
            'u_name' => $user->buyers_fname . ' ' . $user->buyers_lname,
            'u_slug' => $u_slug,
            'u_totalproducts' => $total_product,
            'u_summary' => $user->buyers_summary,
            'u_image' => $user_image,
        );

        return $result;
    }

    public static function updateLastLogin($id) {
        $lastlogin = Buyers::model()->findByPk($id);
        $lastlogin->buyers_lastlogin = date('Y-m-d H:i:s');
        $lastlogin->update();
    }

    public static function getBuyerNickName($id) {
        $model = Buyers::model()->findByPk($id);
        $name = '-';
        if (!empty($model)) {
            $name = $model->buyers_nickname;
        }
        echo $name;
    }

    public static function getBuyerName($id) {
        $model = Buyers::model()->findByPk($id);
        $name = '-';
        if (!empty($model)) {
            $name = $model->buyers_fname . ' ' . $model->buyers_lname;
        }
        echo $name;
    }

}
