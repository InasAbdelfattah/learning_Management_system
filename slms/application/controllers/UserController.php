<?php

use Zend\Crypt\Password\Bcrypt;

class UserController extends Zend_Controller_Action {

    private $model = null;

    public function init() {
        /* Initialize action controller here */
        $this->model = new Application_Model_Users;
        # send loged in user data
        $this->user_model = new Application_Model_Users();
        $this->auth = Zend_Auth::getInstance()->getIdentity();
        $layout = $this->_helper->layout();
        $this->user_model->id =  $this->auth->id;
        $currunt_user = $this->user_model->getUser();
        if($currunt_user[0]['is_active'] == 1)
            $layout->user = $currunt_user;
        else 
            $this->view->massage= "Sorry You are Blocked of login and interact , please wait untill admin active you";
    }

    public function indexAction() {
//         $this->model = new Application_Model_Courses;
        $categories = $this->model->listUsers();
        var_dump($categories);
        // action body
    }

    public function registerAction() {

        $form = new Application_Form_User();
        $form->removeElement('id');
        $form->removeElement('is_active');
        $form->removeElement('is_admin');
        $form->removeElement('is_loged');
        $form->removeElement('joined_at');
        $form->removeElement('updated_at');
        $form->removeElement('image');

//        $form->removeElement('id','image', 'is_active', 'is_admin', 'is_loged', 'joined_at', 'updated_at');
//                username,image,signature,is_active,is_admin,is_loged,joined_at,updated_at
//$values = $this->getRequest()->getParams();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->view->$data['username'];
                $this->model->username = $data['username'];
                $this->model->email = $data['email'];
                $this->model->password = md5($data['password']);
                $this->model->signature = $data['signature'];


//                  $this->model->email = $data['email'];
//                $bcrypt = new Bcrypt();
//                $securePass = $bcrypt->create($data['password']);
//                $this->model->password = $securePass;


                if ($this->model->register())
                    $this->redirect('user/index');
            }
        }
//$form->removeElement('submit');
        $this->view->form = $form;
//$this->view->pass = "5";
//        $this->redirect('users/add');
    }

    public function loginAction() {


        $authorization = Zend_Auth::getInstance();
        if ($authorization->hasIdentity()) {
//            $this->redirect('users/index');
        }
        $form = new Application_Form_User();
        $form->removeElement('id');
        $form->removeElement('is_active');
        $form->removeElement('is_admin');
        $form->removeElement('is_loged');
        $form->removeElement('joined_at');
        $form->removeElement('updated_at');
        $form->removeElement('image');
        $form->removeElement('username');
        $form->removeElement('signature');
        $form->getElement('email')->removeValidator('Zend_Validate_Db_NoRecordExists');

//$values = $this->getRequest()->getParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();

                if ($this->model->loginUser($data))
                    $this->redirect('user/index');
                else {
                    $this->redirect('user/login');
                }
            }
        }
//$form->removeElement('submit');
        $form->getElement('submit')->setName('ok');
        $this->view->form = $form;
    }

    public function showProfileAction() {
        // action body
        $form = new Application_Form_User();
        $form->removeElement('id');
        $form->removeElement('is_active');
        $form->removeElement('is_admin');
        $form->removeElement('is_loged');
        $form->removeElement('password');
        $form->removeElement('joined_at');
        $form->removeElement('updated_at');
        $this->model->id = $this->getRequest()->getParam('id');
        $user = $this->model->getUser();
        $form->populate($user[0]);
        $this->view->form = $form;
        $form->getElement('email')->removeValidator('Zend_Validate_Db_NoRecordExists');
        $this->view->user = $user[0];
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->model->saveData($data);
                if ($this->model->saveData($data)) {
                    return back();
                }
            }
        }
    }
    
    public function logoutAction(){

        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->redirect('index/');

	}

}
