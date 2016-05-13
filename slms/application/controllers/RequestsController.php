<?php

class RequestsController extends Zend_Controller_Action {

    private $model = null;
    public function init() {
        /* Initialize action controller here */

        $this->model = new Application_Model_Requests;
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
        else
                $this->redirect('user/login');

    }

    public function indexAction() {
        // action body
    }

    public function sendRequstAction() {

        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity())
            $loggedIn = true;
        if ($loggedIn) {
            $auth =Zend_Auth::getInstance()->getStorage()->read();
            $coursesModel = new Application_Model_Courses();
            $catgryNames = $coursesModel->listCategories();
            $this->view->catgries = $catgryNames;
            if (isset($_POST['submit'])) {
//            var_dump($_POST);
                $link = $_POST['category'];
                $link_array = explode('/', $link);
                $categoryID = end($link_array);
                $this->model->category_id = $categoryID;
                $this->model->user_id = $auth->id;
                if (isset($_POST['course'])) {
                    $this->model->course_id = $_POST['course'];
                } else {
                    $this->model->course_id = 0;
                }
                $this->model->description = $_POST['description'];
                $this->model->addRequest();
            }
        } else {
            $this->redirect('user/login');
        }

        // action body
//        $form=new Application_Form_Requset();
//        $this->view->form=$form;
        $coursesModel = new Application_Model_Courses();
        $catgryNames = $coursesModel->listCategories();
        $this->view->catgries = $catgryNames;

    }

}


//array(4) { 
//    ["category"]=> string(82) 
//    "/zend/zendProject/learning_Management_system/slms/public/category/ajaxrequest/id/1" 
//    ["course"]=> string(1) "7"
//    ["courseStatus"]=> string(6) "abefer" 
//    ["submit"]=> string(12) "Send Request" }

