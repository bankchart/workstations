<?php

class ChecklistController extends Controller {
    public $layout = '_workstation_layout';

    public function filters(){
        if(Yii::app()->user->isGuest){
            $this->redirect(array('//site'));
        }
    }

    public function actionIndex(){ // is admin -> redirect to manage-member
        if(Yii::app()->user->isAdmin())
            $this->render('index');
        else
            $this->redirect(array('//checklist/checklistmanagement'));
    }

    public function actionManageMemberAjax(){
        if(Yii::app()->user->isAdmin()){
            echo $this->renderPartial('_manage-member-ajax');
        }
    }


    public function actionChecklistManagement(){ // manage-checklist
        $this->render('_checklist_management', array(
            'menu_active' => 'checklist-management'
        ));
    }

    public function actionChecklistManagementAjax(){
        if(!Yii::app()->user->isGuest){
            echo 'loaded.';
        }
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
            $model->fullname = $_POST['fullname'];
            $model->save();
            $this->redirect(array('//checklist/account'));
        }else{
            $this->redirect(array('index'));
        }
    }

    public function actionChangePasswordForm(){
        $this->render('_change-password-form', array(
            'menu_active' => 'account'
        ));
    }

    public function actionSaveNewPassword(){
        if(isset($_POST['old-password']) && isset($_POST['new-password']) && isset($_POST['confirm-new-password'])){
            $oldPass = trim($_POST['old-password']);
            $newPass = trim($_POST['new-password']);
            $cNewPass = trim($_POST['confirm-new-password']);
            $model = User::model()->findByPk(Yii::app()->user->id);
            $signUpRole = new SignUpValidate;
            if(!CPasswordHelper::verifyPassword($oldPass, $model->password)){
                $this->redirect(array('changepasswordform', 'result' => 'failed'));
            }elseif($newPass != $cNewPass || strlen($newPass) < $signUpRole->getRoleLenPassWord()){
                $this->redirect(array('changepasswordform', 'result' => 'failed'));
            }else{
                $tempPass = CPasswordHelper::hashPassword($newPass);
                $model->password = $tempPass;
                $model->save();
                $this->redirect(array('changepasswordform', 'result' => 'success'));
            }
        }else{
            $this->redirect(array('changepasswordform'));
        }
    }
}

?>
