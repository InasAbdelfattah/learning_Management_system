<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CategoryController extends Zend_Controller_Action
{

    private $model;
    public function init()
    {
     $this->model = new Application_Model_Courses;   
    }

  public function indexAction()
    {
        $this->view->category = $this->model->listCategories();
  	


    }
    public function courseAction()
    {
       $this->view->category = $this->model->listCourses(); 
    }
    
    public function detailsAction()
    {
        $id = $this->getRequest()->getParam('id');
        $this->view->category = $this->model->getcategory();
    }

}

