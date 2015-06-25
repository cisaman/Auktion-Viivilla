<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class SellersIdentity extends CUserIdentity {

    private $_id;
    private $_role_id;
    private $_role_name;

    public function getAllRoles() {
        $result = Role::model()->findAll(array('select' => 'role_id, role_name', 'order' => 'role_id'));

        $roles = '';
        foreach ($result as $r) {
            $roles[$r->role_id] = $r->role_name;
        }

        return $roles;
    }

    public function getId() {
        return $this->_id;
    }

    public function getRoleId() {
        return $this->_role_id;
    }

    public function getRoleName() {
        return $this->_role_name;
    }

    public function authenticate() {

        $utils = new Utils;
        $sellers = Sellers::model()->findByAttributes(array('sellers_email' => strtolower($this->username)));

        if (empty($sellers)) {
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        } elseif ($utils->passwordDecrypt($sellers->sellers_password) != ($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {            
            if ($sellers->sellers_roleID != 3) {
                $this->_id = $sellers->sellers_id;
                $this->_role_id = $sellers->sellers_roleID;
                $role_id = $this->_role_id;

                $roles = $this->getAllRoles();

                if (array_key_exists($role_id, $roles)) {
                    Yii::app()->user->name = $roles[$role_id];
                    $this->_role_name = Yii::app()->user->name;
                }
                $this->errorCode = self::ERROR_NONE;
            }
        }

        return !$this->errorCode;
    }

}
