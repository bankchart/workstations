<?php

class ChecklistController extends Controller {
    public $layout = '_workstation_layout';

    public function filters(){
        if(Yii::app()->user->isGuest){
            $this->redirect(array('//site'));
        }
    }

    public function actionIndex(){
        $this->redirect(array('checklistmanagement'));
    }

    public function actionChecklistManagement(){ /* manage-checklist */
        $this->render('index', array(
            'menu_active' => 'checklist-management'
        ));
    }

    public function actionChecklistManagementAjax(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_POST &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            $user_id = Yii::app()->user->id;
            $searchTopic = addslashes(trim($_POST['search-topic-name']));
            $limit = $_POST['records-per-page'];
            $offset = $_POST['page']*$limit - $limit;
            $checklistCriteria = new CDbCriteria;
            $checklistCriteria->condition = "user_id <> :user_id";
            $checklistCriteria->params = array(':user_id' => $user_id);
            $checklistModel = Checklist::model()->findAll($checklistCriteria);
            echo CJSON::encode(array(
                'is_empty' => count($checklistModel) == 0 ? 'empty' : 'exist'
            ));
        }else{
            $this->redirect(array('index'));
        }
    }

    public function actionAddChecklistAjax(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_POST &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $topic = addslashes(trim($_POST['topic']));
            $detail = addslashes(trim($_POST['detail']));
            $deadline = addslashes(trim($_POST['deadline']));
            $checklistModel = new Checklist;
            if(count(Checklist::model()->find()) == 0)
                $checklistModel->checklist_id = 1;
            $checklistModel->checklist_topic = $topic;/* no duplicate topic-name !!!! */
            $checklistModel->checklist_detail = $detail;
            $checklistModel->create_datetime = new CDbExpression('NOW()');
            //$checklistModel->done_datetime = $topic;
            //$checklistModel->cancel_datetime = $topic;
            $checklistModel->deadline_datetime = $deadline;
            $checklistModel->user_id = Yii::app()->user->id;
            echo $checklistModel->save() ? 'completed' : 'failed';
        }else{
            $this->redirect(array('index'));
        }
    }
}

?>
