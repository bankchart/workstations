<?php

class UserType extends CActiveRecord {
    public static function model($className = __CLASS__){ 
        return parent::model($className);
    }
    public function tableName(){
        return 'user_type_tb';
    }
    public function attributeLabels(){
        return array(
            'auth_id' => 'Auth id',
            'auth_name' => 'Auth name'
        );
    }
}

?>
