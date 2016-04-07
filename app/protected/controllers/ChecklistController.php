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
            $searchTopic = addcslashes(trim($_POST['search-topic-name']), '%_');

            $limit = $_POST['records-per-page'];
            $offset = $_POST['page']*$limit - $limit;
            $checklistCriteria = new CDbCriteria;
            $checklistCriteria->condition = "user_id = :user_id";
            if($searchTopic != ''){
                $checklistCriteria->condition .= " AND checklist_topic LIKE '%$searchTopic%'";
                $checklistCriteria->params = array(
                        ':user_id' => $user_id
                );
            }else{
                $checklistCriteria->params = array(':user_id' => $user_id);
            }
            $checklistModel = Checklist::model()->findAll($checklistCriteria);
            echo CJSON::encode(array(
                'checklist_body_table' => $this->renderPartial(
                                '_checklist-management-ajax',
                                array('model' => $checklistModel, 'offset' => $offset),
                                true
                ),
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
            $isDuplicate = count(Checklist::model()->find(array(
                'condition' => 'checklist_topic = :topic',
                'params' => array(':topic' => $topic)
            ))) > 0 ? true : false;
            if($topic == '' || $detail == '' || $deadline == '' || $isDuplicate){
                echo 'failed';
                exit;
            }
            $checklistModel = new Checklist;
            if(count(Checklist::model()->find()) == 0)
                $checklistModel->checklist_id = 1;
            $checklistModel->checklist_topic = $topic;/* no duplicate topic-name !!!! */
            $checklistModel->checklist_detail = $detail;
            $checklistModel->create_datetime = new CDbExpression('NOW()');
            //$checklistModel->done_datetime = $topic;
            //$checklistModel->cancel_datetime = $topic;
            $checklistModel->deadline_datetime = $deadline . ':00';
            $checklistModel->user_id = Yii::app()->user->id;
            echo $checklistModel->save() ? 'completed' : 'failed';
        }else{
            $this->redirect(array('index'));
        }
    }
}

?>
