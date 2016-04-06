<?php

class ChecklistController extends Controller {
    public $layout = '_workstation_layout';

    public function filters(){
        if(Yii::app()->user->isGuest){
            $this->redirect(array('//site'));
        }
    }

    public function actionIndex(){ // is admin -> redirect to manage-member
        if(Yii::app()->user->isAdmin()){
            $userModel = User::model()->findAll();
            $countUser = count($userModel);
            $defaultRecordsPerPage = Yii::app()->params['defaultPerPageTable'][0];
            $pages = ($countUser%$defaultRecordsPerPage == 0) ?
                        $countUser/$defaultRecordsPerPage :
                        floor($countUser/$defaultRecordsPerPage) + 1;
            $this->render('index', array(
                'pages' => $pages,

            ));
        }else
            $this->redirect(array('//checklist/checklistmanagement'));
    }

    public function actionManageMemberAjax(){
        if(Yii::app()->user->isAdmin()){
            if(empty($_POST))
                exit;
            $searchName = $_POST['search-mem-name'];
            $limit = $_POST['records'];
            $offset = $_POST['page'] > 1 ? $limit*$_POST['page'] - $limit : 0;
            $model = User::model()->findAll(array(
                'limit' => $limit,
                'offset' => $offset,
                'condition' => 'auth_id != 1 '
            ));
            $countModel = User::model()->findAll(array(
                'condition' => 'auth_id != 1'
            ));
            $count = count($countModel);
            $defaultRecordsPerPage = $limit;
            $pages = 1;
            $temp = $count/$defaultRecordsPerPage;
            if($count > $defaultRecordsPerPage)
                $pages = strrpos($temp, '.') ? floor($temp) + 1 : $temp;
            $pageHtml = '';
            for($i=1;$i<=$pages;$i++){
                $selected = $_POST['page'] == $i ? 'selected' : '';
                $pageHtml .= "<option $selected value='$i'>$i</option>";
            }
            echo CJSON::encode(array(
                    'tbody_member' => $this->renderPartial('_manage-member-ajax', array(
                                    'model' => $model,
                                    'offset' => $offset + 1
                                ), true
                    ),
                    'page_dropdown_list_html' => $pageHtml,
                    'pages' => $pages,
                    'temp' => $temp
                )
            );
        }
    }

    public function actionManageMemberPerformAjax(){
        if(Yii::app()->user->isAdmin()){
            echo CJSON::encode(array(
                'objectPerform' => 'test-objectPerform',
                'message' => 'test-message'
            ));
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
            $model->nickname = htmlspecialchars($_POST['nickname'], ENT_QUOTES);
            $model->fullname = htmlspecialchars($_POST['fullname'], ENT_QUOTES);
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
