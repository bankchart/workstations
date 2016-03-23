<?php

class WebUser extends CWebUser {

    private $_model;

    function isAdmin(){
        $user = $this->loadUser(Yii::app()->user->id);
        return intval($user->auth_id) === 1;
    }

    function isMember(){
        $user = $this->loadUser(Yii::app()->user->id);
        return intval($user->auth_id) === 2;
    }

    protected function loadUser($id = null){
        if($this->_model === null){
            $_model = User::model()->findByPk($id);
        }
        return $this->_model;
    }

}

?>
