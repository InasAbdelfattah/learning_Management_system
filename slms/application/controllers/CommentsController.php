<?php

class CommentsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_Comments();
    }


    public function indexAction(){
        //show material of id=material_id
        $material_obj= new Application_Model_Materials();
        $material_id = $this->getRequest()->getParam('material_id');
        $material_obj->id=$material_id;
        $material=$material_obj->getMaterial();
        $this->view->material=$material;
        //show comments where material_id=$material_id
        $comments = $this->model->fetchAll($this->model->select('*')->where('material_id =?',$material_id ))->toArray();
        $this->view->comments = $comments;
        /* $session=Zend_auth::getInstance()->getStorage()->read();
        $user_id=$session->id;*/
        $form = new Application_Form_Comment();
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getParams())){
                $data = $form->getValues();
                 $this->model->comment = $data['comment'];
                $this->model->material_id = $data['material_id'];
                $this->model->user_id =1;
                $this->view->data = $data;
                #if ($this->model->addComment($data))
                if ($this->model->addComment())
                $this->redirect('comments/index/material_id/'.$material_id);
            }
        }
        // $objpost->view->form = $postform;
        $this->view->form = $form;
        //$this->view->comt = "comment";
        //$this->redirect('index/index');
    }


    public function editAction(){
        $id = $this->getRequest()->getParam('id');
        $comment = $this->model->id=$id;
        $comment=$this->model->getComment();
        $form = new Application_Form_Comment();
        $form->populate($comment[0]);//return selected data from db and put it in form
        if($this->getRequest()->isPost()){
            if ($form->isValid($this->getRequest()->getParams())) {
            $comment_data = $form->getValues();
            var_dump($comment_data);
            $material_id=$comment_data['material_id']; 
            $this->model->update($comment_data, "id=$id");
            $this->redirect("comments/index/material_id/$material_id");
        }
        }
        $this->view->form = $form;
        $this->render('index');
        
    }
}

