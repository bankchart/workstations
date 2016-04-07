<?php
class DetectDeadline {
    public function updateStatus(){
        $model = Checklist::model()->findAll();
        foreach($model as $record){
            if($record->checklist_status->checklist_status_name == 'done')
                continue;
            $deadline = $record->deadline_datetime;
            $create = $record->create_datetime;
            $result_diff = Yii::app()->db->createCommand(
                "SELECT TIMESTAMPDIFF(SECOND, NOW(), '$deadline') AS diff"
                )->query();
            $temp_diff = '';
            foreach($result_diff as $n)
                $temp_diff = $n['diff'];
            if($temp_diff <= 0){
                $temp_model = Checklist::model()->findByPk($record->checklist_id);
                $temp_model->checklist_status_id = 2;/* 2:fail */
                $temp_model->save();
            }
        }
        return true;
    }
}
?>
