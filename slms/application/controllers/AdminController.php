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
<<<<<<< HEAD
    #category
    public function categoryAction()
    {
         $this->view->category = $this->model->listCategories();
    }
   public function courseAction()
    {
       $this->view->category = $this->model->listCourses(); 
    }
=======
    public function addmaterialAction() {
        $form = new Application_Form_Material();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->model->material_name = $data['material_name'];
                $this->model->image = $data['image'];
                $this->model->descib = $data['descib'];
                $this->model->path = $data['path'];
                $this->model->material_type_id = $data['material_type_id'];
                $this->model->course_id = $data['course_id'];
                $this->model->is_active = $data['is_active'];
                if ($this->model->addMaterial())
                    $this->redirect('admin/materials');
            }
        }
         $this->view->form = $form;
    }

>>>>>>> a673baadfc84329e4dc69f5e4d168ae4e2d95ff
}

