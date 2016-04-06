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

    public function actionUpdateUserAuthorityAjax(){
        if($_POST){
            $user_id = $_POST['user_id'];
            $authStr = null;
            if(isset(Yii::app()->params['userFilterType'][$_POST['auth_str']])){
                $authStr = Yii::app()->params['userFilterType'][$_POST['auth_str']];
            }else{
            //    echo 'user filter type : failed.';
                if($_POST['auth_str'] == 'remove'){
                    $deleteSql = 'DELETE FROM user_tb WHERE user_id = :user_id';
                    $deleteConnection = Yii::app()->db;
                    $deletecommand = $deleteConnection->createCommand($deleteSql);
                    $deletecommand->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $deletecommand->execute();
                    echo 'deleted';
                }
                exit;
            }
            $criteriaUserType = new CDbCriteria;
            $criteriaUserType->condition = 'auth_name = :auth_name';
            echo 'authStr : ' . $authStr . '<br/>';
            $criteriaUserType->params = array(':auth_name' => $authStr);
            $userTypeModel = UserType::model()->find($criteriaUserType);
            if(count($userTypeModel) > 0){
                $auth_id = $userTypeModel->auth_id;
                //echo 'auth_id : ' . $auth_id . '<br/>';
                $sql = 'UPDATE user_tb SET auth_id = :auth_id WHERE user_id = :user_id';
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $command->bindParam(':auth_id', $auth_id, PDO::PARAM_INT);
                $command->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $command->execute();
            }else{
                //echo 'usertypemodel : failed.';
            }
        }else{
            //echo 'failed';
        }
    }

    public function actionDeleteNewbiePerformAjax(){
        if($_POST){
            $user_id = $_POST['user_id'];
            $sql = 'DELETE FROM user_tb WHERE user_id = :user_id';
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            if($command->execute() > 0)
                echo 'deleted';
        }
    }

    public function actionAcceptNewBiePerformAjax(){
        if($_POST){
            $user_id = trim($_POST['user_id']);
            $model = User::model()->findByPk($user_id);
            $model->accept = new CDbExpression('NOW()');
            $model->auth_id = 2; // auth_id : 2 (allow)
            if($model->save())
                echo 'accepted';
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
