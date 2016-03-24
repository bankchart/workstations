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
				'testLimit' => '0'
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			// 'page'=>array(
			// 	'class'=>'CViewAction',
			// ),
			'auth' => 'application.controllers.auth.AuthenticateAction'
		);
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
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
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
