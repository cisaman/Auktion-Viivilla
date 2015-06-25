<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class BuyersLoginForm extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('username, password', 'required', 'message' => Yii::t('lang', 'please_enter') . ' {attribute}.'),
            array('username', 'email', 'message' => Yii::t('lang', 'please_enter') . ' ' . Yii::t('lang', 'a_valid') . ' {attribute}.'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => 'Remember me next time',
            'username' => Yii::t('lang', 'email_id'),
            'password' => Yii::t('lang', 'password'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new BuyersIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate()) {
                //$this->addError('message', 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {

        if ($this->_identity === null) {
            $this->_identity = new BuyersIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === BuyersIdentity::ERROR_NONE) {
            $this->setSession($this->_identity->id);
            return 3;
        } else if ($this->_identity->errorCode === BuyersIdentity::ERROR_UNKNOWN_IDENTITY) {
            return 4;
        } else if ($this->_identity->errorCode === BuyersIdentity::ERROR_PASSWORD_INVALID) {
            return 2;
        } else if ($this->_identity->errorCode === BuyersIdentity::ERROR_USERNAME_INVALID) {
            return 1;
        } else if ($this->_identity->errorCode === BuyersIdentity::ERROR_ACCOUNT_NOT_ACTIVE) {
            return 5;
        }
    }

    public function setSession($user_id) {
        $user_role_id = 3;
        $user_role_name = 'User';

        $session_data = array();
        $session_data['buyers_id'] = $user_id;
        $session_data['user_role_id'] = $user_role_id;
        $session_data['user_role_name'] = $user_role_name;
        Yii::app()->user->name = $user_role_name;
        Yii::app()->session['user_data'] = $session_data;

//        $model = Buyers::model()->findByPk($user_id);
//        $model->buyers_lastlogin = date('Y-m-d H:i:s');
//        $model->update();
    }

}
