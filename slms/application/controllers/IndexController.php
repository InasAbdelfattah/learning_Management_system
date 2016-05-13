<?php

class IndexController extends Zend_Controller_Action {

    private $model;

    public function init() {
        /* Initialize action controller here */
        $this->model = new Application_Model_Courses();
        # send loged in user data
        $this->user_model = new Application_Model_Users();
        $this->auth = Zend_Auth::getInstance()->getIdentity();
        $layout = $this->_helper->layout();
        if ($this->auth) {
            $this->user_model->id = $this->auth->id;
            $currunt_user = $this->user_model->getUser();
            if ($currunt_user[0]['is_active'] == 1)
                $layout->user = $currunt_user;
            else
                $this->redirect('user/login');
        }
        else
                $this->redirect('user/login');
    }

    public function indexAction() {
//       $userModel= new Application_Model_Users();
        $categories = $this->model->listCategories();

        $users = $this->user_model->listUsers();
//       $stuffUsers = $userModel->listCategories();
        $this->view->categories = $categories;
        $this->view->users = $users;
//       echo $this->auth->email;
//       $this->view->user_name = $this->auth->user_name ;
    }

}
