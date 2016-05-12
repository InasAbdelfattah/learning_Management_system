<?php

class RequestsController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        # send loged in user data
        $this->user_model = new Application_Model_Users();
        $this->auth = Zend_Auth::getInstance()->getIdentity();
        $layout = $this->_helper->layout();
        $this->user_model->id = $this->auth->id;
        $currunt_user = $this->user_model->getUser();
        if ($this->auth) {
            if ($currunt_user[0]['is_active'] == 1)
                $layout->user = $currunt_user;
            else
                $this->redirect('user/login');
        }
    }

    public function indexAction() {
        // action body
    }

    public function sendRequstAction() {
        // action body
//        $form=new Application_Form_Requset();
//        $this->view->form=$form;
        $coursesModel = new Application_Model_Courses();
        $catgryNames = $coursesModel->listCategories();
        $this->view->catgries = $catgryNames;
    }

}
