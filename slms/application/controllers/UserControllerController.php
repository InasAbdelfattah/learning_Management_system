<?php

class UserControllerController extends Zend_Controller_Action {

    private $model;

    public function init() {
        /* Initialize action controller here */

        $this->model = new Application_Model_Users;
    }

    public function indexAction() {
        // action body
    }

    public function loginAction() {

        $authorization = Zend_Auth::getInstance();
        if ($authorization->hasIdentity()) {
//            $this->redirect('users/index');
        }



        $form = new Application_Form_User();
        $form->getElement('email')->removeValidator('Zend_Validate_Db_NoRecordExists');
//                username,image,signature,is_active,is_admin,is_loged,joined_at,updated_at

        $form->removeElement( 'username', 'image', 'signature', 'is_active', 'is_admin', 'is_loged', 'joined_at', 'updated_at');
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

}
