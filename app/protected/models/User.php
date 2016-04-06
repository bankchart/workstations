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
            'nickname' => 'Nick name',
            'signup' => 'SignUp Date',
            'accept' => 'Accept Date',
            'auth_id' => 'Auth id'
        );
    }

    public function relations(){
        return array(
            'auth' => array(self::BELONGS_TO, 'UserType', 'auth_id')
        );
    }
}

?>
