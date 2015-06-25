<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SellersLoginForm extends CFormModel {

    public $username;
    public $password;
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
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
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
            $this->_identity = new SellersIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate()) {
                //$this->addError('msg', 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {

        if ($this->_identity === null) {
            $this->_identity = new SellersIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === SellersIdentity::ERROR_NONE) {                        
            $session_data = array();
            $session_data['admin_id'] = $this->_identity->getId();
            $session_data['admin_role_id'] = $this->_identity->getRoleId();
            $session_data['admin_role_name'] = $this->_identity->getRoleName();

            Yii::app()->session['admin_data'] = $session_data;
           
            return true;
        } else {
            return false;
        }
    }

}
