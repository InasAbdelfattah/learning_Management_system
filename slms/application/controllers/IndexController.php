<?php

class IndexController extends Zend_Controller_Action
{

    private $model;
    public function init()
    {
        /* Initialize action controller here */
         $this->model = new Application_Model_Courses();
         $this->user_model = new Application_Model_Users();
         $this->auth = Zend_Auth::getInstance()->getIdentity();
  
    }

    public function indexAction()
    {
//       $userModel= new Application_Model_Users();
       $categories= $this->model->listCategories();
       
       $users= $this->user_model->listUsers();
//       $stuffUsers = $userModel->listCategories();
       $this->view->categories= $categories;
       $this->view->users=$users;
       echo $this->auth->email;
       $this->view->user_name = $this->auth->user_name ;
    }


}

