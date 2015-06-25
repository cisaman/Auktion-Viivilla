<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ChangePassword extends CFormModel {

    public $old_password;
    public $new_password;
    public $repeat_new_password;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('old_password, new_password, repeat_new_password', 'required', 'message' => Yii::t('lang', 'please_enter') . ' {attribute}.'),
            array('old_password, new_password', 'length', 'min' => 6, 'max' => 16),
            array('new_password', 'strongPassword'),
            array('repeat_new_password', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Lösenordet måste vara identiskt.'),            
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'old_password' => Yii::t('lang', 'old_password'),
            'new_password' => Yii::t('lang', 'new_password'),
            'repeat_new_password' => Yii::t('lang', 'repeat_new_password'),
        );
    }

    public function strongPassword($attribute) {
        $d = '/[0-9]/';  //numbers
        $c = '/[A-Z]/'; //capital letter
        $s = '/[#$%&*@!]/'; // contain one symbol
        if (preg_match_all($d, $this->new_password, $o) < 1) {
            $this->addError($attribute, 'Lösenordet måste innehålla minst en siffra.');
        } else if (preg_match_all($c, $this->new_password, $o) < 1) {
            $this->addError($attribute, 'Lösenord måste innehålla minst en stor bokstav.');
        } else if (preg_match_all($s, $this->new_password, $o) < 1) {
            $this->addError($attribute, 'Lösenordet måste innehålla något av följande tecken (. _ # $% & * @! ~?).');
        } else if (strlen(trim($this->new_password)) < 6) {
            $this->addError($attribute, 'Lösenord måste bestå minst sex bokstäver.');
        }
    }
}
