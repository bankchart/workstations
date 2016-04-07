<?php
class Checklist extends CActiveRecord {
    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return 'checklist_tb';
    }
    public function attributeLabels(){
        return array(
            'checklist_id' => 'Checklist Id',
            'checklist_topic' => 'Topic', /* no duplicate topic-name !!!! */
            'checklist_detail' => 'Detail',
            'create_datetime' => 'Create Datetime',
            'done_datetime' => 'Done Datetime',
            'cancel_datetime' => 'Cancel Datetime',
            'deadline_datetime' => 'Deadline Datetime',
            'checklist_status_id' => 'Checklist Status Id',
            'user_id' => 'User Id',
        );
    }
    public function relations(){
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'checklist_status' => array(self::BELONGS_TO, 'ChecklistStatus', 'checklist_status_id')
        );
    }
}
?>
