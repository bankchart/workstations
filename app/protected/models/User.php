<?php

class User extends CActiveRecord {

    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'user_tb';
    }

    public function attributeLabels(){
        return array(
            'user_id' => 'User id',
            'username' => 'Username',
            'password' => 'Password',
            'fullname' => 'Fullname',
            'auth_id' => 'Auth id'
        );
    }
}

?>
