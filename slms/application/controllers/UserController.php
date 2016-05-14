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
        if ($this->auth) {
            $this->user_model->id = $this->auth->id;
            $currunt_user = $this->user_model->getUser();
            if ($currunt_user[0]['is_active'] == 1)
                $layout->user = $currunt_user;
            else
                $this->view->massage = "Sorry You are Blocked of login and interact , please wait untill admin active you";
        } else
            $this->view->massage = "Sorry You are Blocked of login and interact , please wait untill admin active you";
    }

    public function indexAction() {
//         $this->model = new Application_Model_Courses;
        $categories = $this->model->listUsers();
        var_dump($categories);
        // action body
    }

    public function registerAction() {

        $authorization = Zend_Auth::getInstance();
        if ($authorization->hasIdentity()) {
            $this->redirect('admin');
        }

        $form = new Application_Form_User();
        $form->removeElement('id');
        $form->removeElement('is_active');
        $form->removeElement('is_admin');
        $form->removeElement('is_loged');
        $form->removeElement('joined_at');
        $form->removeElement('updated_at');
        $form->removeElement('image');

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->view->$data['username'];
                $this->model->username = $data['username'];
                $this->model->email = $data['email'];
                $this->model->password = md5($data['password']);
                $this->model->signature = $data['signature'];
                $this->model->image = "default.jpg";

//                  $this->model->email = $data['email'];
//                $bcrypt = new Bcrypt();
//                $securePass = $bcrypt->create($data['password']);
//                $this->model->password = $securePass;


                if ($this->model->register())
                    $this->redirect('user/show-profile');
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
            $currunt_user = $this->user_model->getUser();
            if ($currunt_user[0]['is_active'] == 0)
                $this->view->massage = "Sorry You are Blocked of login and interact , please wait untill admin active you";
            else
                $this->redirect('index');
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

                $result = $this->model->loginUser($data);
                if ($result) {


                    $this->model->last_login = Zend_Date::now()->toString('Y-m-d H:i:s');
                    $this->model->is_loged = 1;
                    $this->model->LastLogin();
                    if ($result[0]['is_admin'])
                        $this->redirect('admin');
                    elseif ($result[0]['is_active'] == 1) {
                        $this->redirect('user/show-profile');
                    }
                } elseif ($result[0]['is_active'] == 0) {
//                    $this->redirect('user/login');
                    $this->view->massage = "Sorry You are Blocked of login and interact , please wait untill admin active you";
                } else {
                    $this->redirect('user/register');
                }
            }
        }
//$form->removeElement('submit');
        $form->getElement('submit')->setName('ok');
        $this->view->form = $form;
    }

    public function updateProfileAction() {
        // action body
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity())
            $loggedIn = true;
        if ($loggedIn) {
            $authr = Zend_Auth::getInstance()->getStorage()->read();
            $form = new Application_Form_User();
            $form->removeElement('id');
            $form->removeElement('is_active');
            $form->removeElement('is_admin');
            $form->removeElement('is_loged');
            $form->removeElement('password');
            $form->removeElement('joined_at');
            $form->removeElement('updated_at');
            $this->model->id = $authr->id;
            $user = $this->model->getUser();
            $form->populate($user[0]);
            $this->view->form = $form;
            $form->getElement('email')->removeValidator('Zend_Validate_Db_NoRecordExists');
            $this->view->user = $user[0];
            if ($this->getRequest()->isPost()) {
                if ($form->isValid($this->getRequest()->getParams())) {
                    $data = $form->getValues();
//                    $this->model->saveData($data);
                    $this->view->$data['username'];
                    $this->model->username = $data['username'];
                    $this->model->email = $data['email'];
                    $this->model->image = $data['image'];
                    $this->model->signature = $data['signature'];
                    $this->model->updateUser();
                    if ($this->model->updateUser()) {
                        return redirect('user/show-profile');
                    }
                }
            }
        } else {
            $this->redirect('user/login');
        }
    }

    public function deleteAction() {
        $this->model->id = $this->getRequest()->getParam('id');
        return $this->model->deleteUser();
    }

    public function activeAction() {
        $this->model->id = $this->getRequest()->getParam('id');
        $this->model->is_active = $this->getRequest()->getParam('active');
        return $this->_helper->json($this->model->IsActive());
    }

    public function adminAction() {
        $this->model->id = $this->getRequest()->getParam('id');
        $this->model->is_admin = $this->getRequest()->getParam('admin');
        return $this->_helper->json($this->model->IsAdmin());
    }

    public function logedAction() {
        $this->model->id = $this->getRequest()->getParam('id');
        $this->model->is_loged = $this->getRequest()->getParam('loged');
        return $this->_helper->json($this->model->IsLoged());
    }

    public function showProfileAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity())
            $loggedIn = true;
        if ($loggedIn) {
            $authr = Zend_Auth::getInstance()->getStorage()->read();
            $this->model->id = $authr->id;
            $user = $this->model->getUser();
            $this->view->user = $user[0];
        } else {
            $this->redirect('user/login');
        }
    }

    public function logoutAction() {
        $this->authh = Zend_Auth::getInstance()->getIdentity();
        $this->model->id=$this->authh->id;
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->model->is_loged = 0;

        $this->model->out();

        $this->redirect('index/');
    }

    public function updateuserAction() {
        $form = new Application_Form_User();
        $form->removeElement('id');
        $this->model->id = $this->getRequest()->getParams('id');
        $user = $this->model->getUser();
        $form->populate($user[0]);
        $this->view->form = $form;
//            $form->getElement('email')->removeValidator('Zend_Validate_Db_NoRecordExists');
        $this->view->user = $user[0];
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
//                    $this->model->saveData($data);
                $this->view->$data['username'];
                $this->model->username = $data['username'];
                $this->model->email = $data['email'];
                $this->model->image = $data['image'];
                $this->model->signature = $data['signature'];
                $this->model->updateUser();
                if ($this->model->updateUser()) {
                    return redirect('user/show-profile');
                }
            }
        }
    }
    
    public function acceptAction() {
        $this->model->email = $this->getRequest()->getParam('email');
//        $this->model->is_loged = $this->getRequest()->getParam('loged');
//        return $this->_helper->json($this->model->IsLoged());
        $this->model->active();
    }


}
