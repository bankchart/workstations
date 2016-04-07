<?php
class ChecklistStatus extends CActiveRecord {
    public static function model($className = __CLASS__){
        return parent::model($className);
    }
    public function tableName(){
        return 'checklist_status_tb';
    }
    public function attributeLabels(){
        return array(
            'checklist_status_id' => 'Checklist Status Id',
            'checklist_status_name' => 'Checklist Status'
        )
    }
}
?>
