<?php

class SignUpValidate {
    private $_role_len_username = 6;
    private $_role_len_password = 8;

    public function isPassRoleUserName($username){
        return strlen($username) <= 20 && strlen($username) >= $this->_role_len_username ? true : false;
    }

    public function isPassRolePassWord($password){
        return strlen($password) <= 60 && strlen($password) >= $this->_role_len_password ? true : false;
    }

    public function isDuplicateUserName($username){
        $user = User::model()->findByAttributes(array('username' => $username));
        return $user === null ? false : true;
    }

    public function getRoleLenUserName(){
        return $this->_role_len_username;
    }

    public function getRoleLenPassWord(){
        return $this->_role_len_password;
    }

    protected function setRoleLenUserName($len = 6){
        $this->_role_len_username = $len;
    }

    protected function setRoleLenPassWord($len = 8){
        $this->_role_len_password = $len;
    }
}

?>
