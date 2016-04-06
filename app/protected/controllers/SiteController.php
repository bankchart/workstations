<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $layout = '_workstation_layout';

	public function actionGetPassword(){
		echo CPasswordHelper::hashPassword(123456);
	}

	public function actionTest(){
		// $model = User::model()->findByPk(1);
		// echo 'auth_id : ' . $model->auth_id;
		echo 'user id : ' . Yii::app()->user->id;
	}

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor' => 0xF5F5F5,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
			'auth' => 'application.controllers.auth.AuthenticateAction'
		);
	}

	public function actionLogin(){
		if(isset($_POST['username-login']) && isset($_POST['password-login'])){
			$user = new UserIdentity($_POST['username-login'], $_POST['password-login']);
			if($user->authenticate()){
				Yii::app()->user->login($user);
				header('refresh:2;index.php');
				echo 'Login success......state : ' . Yii::app()->user->getState('authName');
			}else{
				$this->redirect(array('index'));
			}
		}else{
			$this->redirect(array('index'));
		}
	}
	// coding ...validate password & confirm-password : i'm forgot.
	public function actionSignUp(){
		$result = null;
		$captcha=Yii::app()->getController()->createAction("captcha");
		$code = $captcha->verifyCode;
		if((isset($_POST['username']) || isset($_POST['password'])) && $code == $_POST['captcha-code']){
			if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm-password'])){
				$username = trim($_POST['username']);
				$password = trim($_POST['password']);
				$confirmPassword = trim($_POST['confirm-password']);
				$signUpRole = new SignUpValidate; // in components/SignUpValidate.php
				$lenUsernameRole = $signUpRole->getRoleLenUserName();
				$lenPasswordRole = $signUpRole->getRoleLenPassWord();
				if($signUpRole->isPassRoleUserName($username) && $signUpRole->isPassRolePassWord($password)){
					if($signUpRole->isDuplicateUserName($username) || $confirmPassword != $password){
						$result = array('signUpStatus' => 'failed');
					}else{
						Yii::app()->session->destroy(); // for insert duplicate user
						/* begin: insert new user */
						$model = new User;
						$model->username = $username;
						$model->password = CPasswordHelper::hashPassword($password);
						$model->auth_id = -1;
						$model->nickname = 'empty';
						$model->signup = new CDbExpression('NOW()');
						$model->save();
						/* end: insert new user */
						$this->redirect(array('index'));
					}
				}else{
					$result = array('signUpStatus' => 'failed');
				}
			}else{
				$result = array('signUpStatus' => 'failed');
			}
		}else{
			$result = array('signUpStatus' => 'failed');
		}
		if($result['signUpStatus'] == 'failed')
			Yii::app()->session->destroy();
		$this->render('index', $result);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//Yii::app()->session->destroy(); // remove session of captcha for change characters
		if(!Yii::app()->user->isGuest)
			$this->redirect(array('//userAuth/index'));
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
	 	$captcha=Yii::app()->getController()->createAction("captcha");
		$captcha->testLimit = 1;
		$captcha->validate('', false);
		$this->render('contact',array('menu_active'=>'contact'));
	}

	public function actionSendMessageContact(){
		$result = 'wait';
		if(isset($_POST['email-contact']) && isset($_POST['fullname-contact']) &&
			isset($_POST['message-contact']) && isset($_POST['captcha-code-contact'])){
			$captcha = Yii::app()->getController()->createAction('captcha');
			$email = trim($_POST['email-contact']);
			$fullname = trim($_POST['fullname-contact']);
			$message = trim($_POST['message-contact']);
			$captchaCodeContact = trim($_POST['captcha-code-contact']);
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$result = 'incorrect_email';
			}elseif(strlen($fullname) == 0 || strlen($message) == 0){
				$result = 'empty_fullname_or_message';
			}elseif(!$captcha->validate($captchaCodeContact, false)){
				$result = 'incorrect_captcha_code';
			}else{
				$result = 'success';
			}
        }
		$this->redirect(array('contact', 'result' => $result));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
