<?php

class IndexController extends Zend_Controller_Action
{

    private $model;
    public function init()
    {
        /* Initialize action controller here */
         $this->model = new Application_Model_Courses();
    }

    public function indexAction()
    {
//       $userModel= new Application_Model_Users();
       $categories= $this->model->listCategories();
//       $stuffUsers = $userModel->listCategories();
       $this->view->assign('categories' , $categories);
    }


}

