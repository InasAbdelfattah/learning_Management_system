<?php

class CommentsController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
        $this->model = new Application_Model_Comments();
        $authorization = Zend_Auth::getInstance();
        if (!$authorization->hasIdentity()) {
            $this->redirect('user/login');
        }
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
    }

    public function indexAction() {
        //show material of id=material_id
        $material_obj = new Application_Model_Materials();
        $material_id = $this->getRequest()->getParam('material_id');
        $material_obj->id = $material_id;
        $material = $material_obj->getMaterial();
        $this->view->material = $material;
        //show comments where material_id=$material_id
        $comments = $this->model->fetchAll($this->model->select('*')->where('material_id =?', $material_id))->toArray();
        $this->view->comments = $comments;
        $session=Zend_auth::getInstance()->getStorage()->read();
        $user_id=$session->id;
        $user_obj= new Application_Model_Users();
        $user_obj->id=$user_id;
        $user=$user_obj->getUser();
        $this->view->user = $user;
        $form = new Application_Form_Comment();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->model->comment = $data['comment'];
                $this->model->material_id = $data['material_id'];
                $this->model->user_id = $user_id;
                $this->view->data = $data;
                if ($this->model->addComment())
                    $this->redirect('comments/index/material_id/' . $material_id);
            }
        }
        $this->view->form = $form;
        $this->render('single');
    }

    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        $comment = $this->model->id = $id;
        $comment = $this->model->getComment();
        #material
        $material_obj = new Application_Model_Materials();
        $material_id = $this->getRequest()->getParam('material_id');
        $material_obj->id = $material_id;
        $material = $material_obj->getMaterial();
        $this->view->material = $material;
        #comments
        $comments = $this->model->fetchAll($this->model->select('*')->where('material_id =?', $material_id))->toArray();
        $this->view->comments = $comments;
        #$user_id=1;
        $session = Zend_auth::getInstance()->getStorage()->read();
        $user_id = $session->id;
        $this->view->user_id = $user_id;
        $form = new Application_Form_Comment();
        $form->populate($comment[0]);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->model->comment = $data['comment'];
                $this->model->material_id = $data['material_id'];
                $this->model->user_id = $user_id;
                $this->view->user_id = $user_id;
                if ($this->model->updateComment())
                    $form->reset();
                $this->redirect('comments/index/material_id/' . $material_id);
            }
        }
        $this->view->form = $form;
        $this->render('single');
    }

    function deleteAction() {
        $material_id = $this->getRequest()->getParam('material_id');
        $id = $this->getRequest()->getParam('id');
        $comment = $this->model->id = $id;
        $comment = $this->model->deleteComment();
        $this->redirect('comments/index/material_id/' . $material_id);
    }

}
