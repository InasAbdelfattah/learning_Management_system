<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CategoryController extends Zend_Controller_Action {

    private $model;

    public function init()
    {
     $this->model = new Application_Model_Courses; 
     # send loged in user data
        $this->user_model = new Application_Model_Users();
        $this->auth = Zend_Auth::getInstance()->getIdentity();
        $layout = $this->_helper->layout();
        $this->user_model->id =  $this->auth->id;
        $currunt_user = $this->user_model->getUser();
        if($currunt_user[0]['is_active'] == 1)
            $layout->user = $currunt_user;
        else 
            $this->redirect('user/login');
    }

    public function indexAction() {
//      $auth = Zend_Auth::getInstance();
//      if ($auth->hasIdentity())
//        {
//          
            $this->view->category = $this->model->listActiveCategories();
//        } 
//      else 
//      {
//          $this->redirect('error/error');
//      }
    }

    public function courseAction() {
//      $auth = Zend_Auth::getInstance();
//      if ($auth->hasIdentity())
//        {
//       
        $this->view->category = $this->model->listActiveCourses(); 
//         } 
//      else 
//      {
//          $this->redirect('error/error');
//      }
    }

    public function detailsAction() {
//        $auth = Zend_Auth::getInstance();
//      if ($auth->hasIdentity())
//        {
        $category_id = $this->getRequest()->getParam('id');
        $this->model->category_id = $category_id;
        $this->view->category = $this->model->getcategory();
//         } 
//      else 
//      {
//          $this->redirect('error/error');
//      }
    }

    public function ajaxrequestAction() {
        $category_id = $this->getRequest()->getParam('id');
        $courses = $this->model->categoryCourses($category_id);
//       $this->view->courses=$courses;
        //   return $courses;
       $this->_helper->json($courses);
//         $this->json_encode($courses);
    }

}
