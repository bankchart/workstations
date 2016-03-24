<?php

class ChecklistController extends Controller {
    public $layout = '_workstation_layout';
    public function actionIndex(){
        $this->render('index');
    }
    public function actionChecklistManagement(){
        $this->render('_checklist_management', array(
            'menu_active' => 'checklist-management'
        ));
    }
}

?>
