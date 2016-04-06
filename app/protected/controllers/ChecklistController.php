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
        if($_POST){
            $user_id = Yii::app()->user->id;
            $searchTopic = addslashes(trim($_POST['search-topic-name']));
            $limit = $_POST['records-per-page'];
            $offset = $_POST['page']*$limit - $limit;
            $checklistCriteria = new CDbCriteria;
            $checklistCriteria->condition = "user_id <> :user_id";
            $checklistCriteria->params = array(':user_id' => $user_id);
            $checklistModel = Checklist::model()->findAll($checklistCriteria);
            echo CJSON::encode($checklistModel);
        }
    }
}

?>
