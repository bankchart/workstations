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
            $detect = new DetectDeadline;
            $detect->updateStatus();
            $user_id = Yii::app()->user->id;
            $searchTopic = addcslashes(trim($_POST['search-topic-name']), '%_');

            $limit = $_POST['records-per-page'];
            $offset = $_POST['page']*$limit - $limit;
            $checklistCriteria = new CDbCriteria;
            $checklistCriteria->condition = "user_id = :user_id";
            $checklistCriteria->limit = $limit;
            $checklistCriteria->offset = $offset;
            if($searchTopic != ''){
                $checklistCriteria->condition .= " AND checklist_topic LIKE '%$searchTopic%'";
                $checklistCriteria->params = array(
                        ':user_id' => $user_id
                );
            }else{
                $checklistCriteria->params = array(':user_id' => $user_id);
            }
            $checklistModel = Checklist::model()->findAll($checklistCriteria);
            $pages = count(Checklist::model()->findAll(array(
                    'condition' => "checklist_topic LIKE '%$searchTopic%' AND user_id = $user_id"
                    )));
            $pages = $searchTopic == '' ? count(Checklist::model()->findAll(
                                            array('condition' => 'user_id = ' . $user_id))) :
                                            $pages;
            $temp = $pages/$limit;
            $pages = strpos($temp, '.') ? floor($temp) + 1 : $temp;
            $pageHtml = '';
            for($i=1;$i<=$pages;$i++){
                $selected = $_POST['page'] == $i ? 'selected' : '';
                $pageHtml .= "<option $selected value='$i'>$i</option>";
            }
            echo CJSON::encode(array(
                'checklist_body_table' => $this->renderPartial(
                                '_checklist-management-ajax',
                                array('model' => $checklistModel, 'offset' => $offset),
                                true
                ),
                'is_empty' => count($checklistModel) == 0 ? 'empty' : 'exist',
                'page_html' => $pageHtml
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
            $checklistModel->deadline_datetime = $deadline . ':00';
            /* start: detect create-datetime & deadline-datetime create < deadline */
            $result = 0;
            $temp_create = $checklistModel->create_datetime;
            $temp_deadline = $checklistModel->deadline_datetime;
            $tempModel = Yii::app()->db->createCommand("SELECT TIMESTAMPDIFF(SECOND,
    								'$temp_deadline', '$temp_create') AS diff")
    					->query();
            foreach($tempModel as $n)
                $result = $n['diff'];
            if($result < 1){
                echo 'failed';
                exit;
            }
            /* end: detect create-datetime & deadline-datetime create < deadline */
            //$checklistModel->done_datetime = $topic;
            //$checklistModel->cancel_datetime = $topic;
            $checklistModel->user_id = Yii::app()->user->id;
            echo $checklistModel->save() ? 'completed' : 'failed';
        }else{
            $this->redirect(array('index'));
        }
    }
}

?>
