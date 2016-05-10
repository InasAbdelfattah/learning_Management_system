<?php

class UserController extends Zend_Controller_Action {

    private $model = null;

    public function init() {
        /* Initialize action controller here */
        $this->model = new Application_Model_Users;
    }

    public function indexAction() {
//         $this->model = new Application_Model_Courses;
        $categories = $this->model->listUsers();
        var_dump($categories);
        // action body
    }

    public function addAction() {
        $form = new Application_Form_User();
        $form->removeElement('signature', 'is_active', 'is_admin', 'is_loged', 'joined_at', 'updated_at');
//                username,image,signature,is_active,is_admin,is_loged,joined_at,updated_at
//$values = $this->getRequest()->getParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->model->username = $data['username'];
                $this->model->email = $data['email'];
                $this->model->password = $data['password'];
                if ($this->model->addUser())
                    $this->redirect('users/index');
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
        $form->getElement('email')->removeValidator('Zend_Validate_Db_NoRecordExists');

        $form->removeElement('username', 'image', 'signature', 'is_active', 'is_admin', 'is_loged', 'joined_at', 'updated_at');
//$values = $this->getRequest()->getParams();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();

                if ($this->model->loginUser($data))
                    $this->redirect('users/index');
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
        $this->model->id=2;
        $user = $this->model->getUser();
        $form->populate($user[0]);
        $this->view->form = $form;
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

}