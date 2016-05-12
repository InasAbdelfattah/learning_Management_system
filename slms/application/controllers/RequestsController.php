<?php

class RequestsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function sendRequstAction()
    {
        // action body
//        $form=new Application_Form_Requset();
//        $this->view->form=$form;
        $coursesModel=new Application_Model_Courses();
        $catgryNames=$coursesModel->listCategories();
        $this->view->catgries=$catgryNames;
    }
 


}



