<?php

class AdminController extends Zend_Controller_Action {

    private $model;

    public function init() {
        /* Initialize action controller here */
        $this->model = new Application_Model_Materials();
        $this->cat_model = new Application_Model_Courses;
        $this->type_model = new Application_Model_MaterialTypes;
        $this->_helper->layout->setLayout('admin');
        #add ajax to my controller
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('changestateAction', 'json')
                ->initContext();
    }

    public function indexAction() {
        // action body
    }

#Category

    public function categoryAction() {
        $this->view->category = $this->cat_model->listCategories();
    }

    public function addcategoryAction() {
        $form = new Application_Form_Category();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->cat_model->course_name = $data['course_name'];
                $this->cat_model->image = $data['image'];
                $this->cat_model->category_id = 0;
                $this->cat_model->is_active = $data['is_active'];
                if ($this->cat_model->addCategory($data))
                    $this->redirect('admin/category');
            }
        }
        $this->view->form = $form;
    }
    public function editcategoryAction()
    {
        $this->cat_model->id = $this->getRequest()->getParam('id');
        $id = $this->cat_model->id;
        
        $old = $this->cat_model->getCategoryByID();
        var_dump($old);
        $form = new  Application_Form_Category();
        $form->populate($old[0]);
            if($this->getRequest()->isPost())
            {
                if($form->isValid($this->getRequest()->getParams()))
                {
                    $data = $form->getValues();
                    $this->cat_model->update($data , "id=$id");
                    $this->redirect("admin/category");
                }
            }
            $this->view->form = $form;
            $this->render('addcategory');
//        
    }

    //delete category or course...   
    public function deletecategoryAction() {
        $this->cat_model->id = $this->getRequest()->getParam('id');
        $this->cat_model->deleteCategory();
        $this->redirect('admin/category');
    }

    #Course ...  

    public function courseAction() {
        $this->view->category = $this->cat_model->listCourses();
    }

    public function addcourseAction() {
        $form = new Application_Form_Course();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->cat_model->course_name = $data['course_name'];
                $this->cat_model->image = $data['image'];
                $this->cat_model->category_id = $data['course_id'];
                echo $data['is_active'];
                die();
                $this->cat_model->is_active = $data['is_active'];
                if ($this->cat_model->addCategory($data))
                    $this->redirect('admin/course');
            }
        }
        $this->view->form = $form;
    }

  
    public function editcourseAction()
    {
        $this->cat_model->id = $this->getRequest()->getParam('id');
        $old = $this->cat_model->getCategoryByID();
        $form = new  Application_Form_Course();
        $form->populate($old[0]);
            if($this->getRequest()->isPost())
            {
                if($form->isValid($this->getRequest()->getParams()))
                {
                    $data = $form->getValues();
                    $this->cat_model->course_name = $data['course_name'];
                    $this->cat_model->image = $data['image'];
                    $this->cat_model->category_id = $data['course_id'];
                    $this->cat_model->is_active = $data['is_active'];
                    $this->cat_model-> editCourse();
                    $this->redirect("admin/course");
                }
            }
            $this->view->form = $form;
            $this->render('addcourse');
    }

#materials....    

    public function materialsAction() {
        //list All matrials with it's full data
        $materials = $this->model->listMaterials();
        $this->view->materials = $materials;
        // list marial types
        $matrialTypesDB = new Application_Model_MaterialTypes();
        $materialsTypes = $matrialTypesDB->listMaterialTypes();
        $this->view->materialsTypes = $materialsTypes;
    }

#delete material

    public function deletematerialAction() {
        $this->model->id = $this->getRequest()->getParam('id');
        $this->model->deleteMaterial();
        $this->redirect('admin/materials');
    }

#changestate

    public function changestateAction() {
        $this->model->id = $this->getRequest()->getParam('id');
        $state = $this->getRequest()->getParam('state');


        $this->model->activeMaterial($state);
//        $this->redirect('admin/materials');
        foreach ($this->model->getMaterial() as $mat) {
            $state = $mat['is_active'];
        }
        exit(0);
        $this->view->data = $state;

//        die();
    }

#add new material

    public function addmaterialAction() {
        $form = new Application_Form_Material();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->model->material_name = $data['material_name'];
                if ($data['image'])
                    $this->model->image = $data['image'];
                else
                    $this->model->image = 'defaultmaterial.png';

                $this->model->descib = $data['descib'];
                $this->model->path = $data['path'];
                $this->model->material_type_id = $data['material_type_id'];
                $this->model->course_id = $data['course_id'];
                $this->model->is_active = $data['is_active'];
                if ($this->model->addMaterial($data))
                    
                    $this->redirect('admin/materials');
            }
        }
        $this->view->form = $form;
    }

#edit new material

    public function editmaterialAction() {
        $form = new Application_Form_Material();
        $this->model->id = $this->getRequest()->getParam('id');
        $material = $this->model->getMaterial();
        $form->populate($material[0]);
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
                if ($this->model->updateMaterial())
                    $this->redirect('admin/materials');
            }
        }
        $this->view->form = $form;
    }

    #add new material

    public function addmaterialtypeAction() {
        $form = new Application_Form_Materialtype();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->type_model->material_name = $data['material_name'];
                if ($this->type_model->addMaterialType())
                    $this->redirect('admin/materials');
            }
        }
        $this->view->form = $form;
    }

#edit new material type

    public function editmaterialtypeAction() {
        $form = new Application_Form_Materialtype();
        $this->type_model->id = $this->getRequest()->getParam('id');
        $materialtype = $this->type_model->getMaterialType();
        $form->populate($materialtype[0]);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->type_model->material_name = $data['material_name'];
                if ($this->type_model->updateMaterialType())
                    $this->redirect('admin/materials');
            }
        }
        $this->view->form = $form;
    }

#delete material type

    public function deletematerialtypeAction() {
        $this->type_model->id = $this->getRequest()->getParam('id');
        $this->type_model->deleteMaterialType();
        $this->redirect('admin/materials');
    }

}
