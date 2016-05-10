<?php

class AdminController extends Zend_Controller_Action
{
    private $model;
    public function init()
    {
        /* Initialize action controller here */
         $this->model = new Application_Model_Materials();
         $this->model = new Application_Model_Courses;
         $this->_helper->layout->setLayout('admin');
    }

    public function indexAction()
    {
        // action body
    }
    public function materialsAction()
    {
        //list All matrials with it's full data
        $materials = $this->model->listMaterials();
        $this->view->materials = $materials;
        // list marial types
        $matrialTypesDB = new Application_Model_MaterialTypes();
        $materialsTypes = $matrialTypesDB->listMaterialTypes();
        $this->view->materialsTypes = $materialsTypes;
        
    }
    
    public function categoryAction()
    {
         $this->view->category = $this->model->listCategories();
    }
   public function courseAction()
    {
       $this->view->category = $this->model->listCourses(); 
    }
}

