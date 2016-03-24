<?php

class ChecklistController extends Controller {
    public $layout = '_workstation_layout';

    public function filters(){
        if(Yii::app()->user->isGuest){
            $this->redirect(array('//site'));
        }
    }

    public function actionIndex(){
        if(Yii::app()->user->isAdmin())
            $this->render('index');
        else
            $this->redirect(array('//checklist/checklistmanagement'));
    }
    public function actionChecklistManagement(){
        $this->render('_checklist_management', array(
            'menu_active' => 'checklist-management'
        ));
    }

    public function actionAccount(){
        $id = Yii::app()->user->id;
        $model = User::model()->findByPk($id);
        $this->render('_account-setting', array(
            'menu_active' => 'account',
            'model' => $model
        ));
    }

    public function actionSaveAccount(){
        if(isset($_POST['nickname'])){
            $model = User::model()->findByPk(Yii::app()->user->id);
            $model->nickname = $_POST['nickname'];
            $model->save();
            $this->redirect(array('//checklist/account'));
        }
    }

    public function actionChangePasswordForm(){
        $this->render('_change-password-form', array(
            'menu_active' => 'account'
        ));
    }
}

?>
