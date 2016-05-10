<?php

class AdminController extends Zend_Controller_Action
{
    private $model;
    public function init()
    {
        /* Initialize action controller here */
         $this->model = new Application_Model_Materials();
    }

    public function indexAction()
    {
        // action body
    }
    public function materialsAction()
    {
        
        $materials = $this->model->listMaterials();
//        $categoryModel = new Application_Model_Courses();
        
        $this->view->materials = $materials;
        
    }


}

