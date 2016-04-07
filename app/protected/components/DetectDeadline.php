<?php
class DetectDeadline {
    public function updateStatus(){
        $model = Checklist::model()->findAll();
        foreach($model as $record){
            $deadline = $record->dealine_datetime;
            $result_now = Yii::app()->db->createCommand('SELECT NOW() AS now')->query();
            $temp_now = '';
            foreach($result_now as $n)
                $temp_now = $n['now'];
            $result_diff = Yii::app()->db->createCommand(
                "SELECT TIMESTAMPDIFF(SECOND, '$deadline', '$temp_now') AS diff"
                )->query();
            $temp_diff = '';
            foreach($result_diff as $n)
                $temp_diff = $n['diff'];
        }
    }
}
?>
