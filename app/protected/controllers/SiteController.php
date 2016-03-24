<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $layout = '_workstation_layout';

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

	public function actionSignUp(){
		$result = null;
		$captcha=Yii::app()->getController()->createAction("captcha");
		$code = $captcha->verifyCode;
		if((isset($_POST['username']) || isset($_POST['password'])) && $code == $_POST['captcha-code']){
			if(isset($_POST['username']) && isset($_POST['password'])){
				$username = trim($_POST['username']);
				$password = trim($_POST['password']);
				$signUpRole = new SignUpValidate; // in components/SignUpValidate.php
				$lenUsernameRole = $signUpRole->getRoleLenUserName();
				$lenPasswordRole = $signUpRole->getRoleLenPassWord();
				if(strlen($username) > $lenUsernameRole && strlen($password) > $lenPasswordRole){
					if($signUpRole->isDuplicateUserName($username)){
						$result = array('signUpStatus' => 'failed');
					}else{
						Yii::app()->session->destroy(); // for insert duplicate user
						/* begin: insert new user */
						$model = new User;
						$model->username = $username;
						$model->password = CPasswordHelper::hashPassword($password);
						$model->auth_id = -1;
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
			$this->redirect(array('//checklist'));
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
		$this->render('contact',array('menu_active'=>'contact'));
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
