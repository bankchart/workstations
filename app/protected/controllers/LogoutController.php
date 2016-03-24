<?php

class LogoutController extends Controller {
    public function actionIndex(){
        Yii::app()->user->logout();
        $this->redirect(array('//site/index'));
    }
}

?>
