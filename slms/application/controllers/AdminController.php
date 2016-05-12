<?php

class AdminController extends Zend_Controller_Action
{
    private $model;
    public function init()
    {
        /* Initialize action controller here */
         $this->model = new Application_Model_Materials();
         $this->cat_model = new Application_Model_Courses;
         $this->type_model = new Application_Model_MaterialTypes;
         $this->_helper->layout->setLayout('admin');
        #add ajax to my controller
         $contextSwitch = $this->_helper->getHelper('contextSwitch');
         $contextSwitch->addActionContext('changestateAction','json')
                        ->initContext();
    }

    public function indexAction()
    {
        // action body
    }
   
#Category
    public function categoryAction()
    {
         $this->view->category = $this->cat_model->listCategories();
    }
    
    
    public function addcategoryAction()
    {
        $auth = Zend_Auth::getInstance();
    	if ($auth->hasIdentity())
	{
		$u_session =$auth->getIdentity();
		
		$user_id = $u_session->id;
			
		$form = new Application_Form_Category();
        //$values = $this->getRequest()->getParams();
		if($this->getRequest()->isPost()){
		if($form->isValid($this->getRequest()->getParams())){
		$data = $form->getValues();
		
		if ($this->model->addPost($data , $user_id))
		$this->redirect('posts/index');
		
		}
//        $this->view->category = $this->cat_model->addCategory(); 
    }
        }
    
    }
    public function editcategoryAction()
    {
         $this->view->category = $this->cat_model->editCategory(); 
    }
    
 //delete category or course...   
    public function deletecategoryAction()
    {
        $this->cat_model->id = $this->getRequest()->getParam('id');
        $this->cat_model->deleteCategory();
        $this->redirect('admin/category');
    
    
    }
    
 #Course ...  
   public function courseAction()
    {
        $this->view->category = $this->cat_model->listCourses();
    }
    
    public function addcourseAction()
    {
         $this->view->category = $this->cat_model->addCourse(); 
    }

  
    public function editcourseAction()
    {
         $this->view->category = $this->cat_model->editCourse(); 
    }
    
    
#materials....    
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
#delete material
     public function deletematerialAction()
    {
        $this->model->id = $this->getRequest()->getParam('id');
        $this->model->deleteMaterial();
        $this->redirect('admin/materials');
    
    
    }
#changestate
   public function changestateAction()
    {
        $this->model->id = $this->getRequest()->getParam('id');
        $state = $this->getRequest()->getParam('state');
        

         $this->model->activeMaterial($state);
//        $this->redirect('admin/materials');
        foreach ($this->model->getMaterial() as $mat)
        {
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
                $this->type_model ->material_name = $data['material_name'];
                if ($this->type_model ->addMaterialType())
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
                $this->type_model ->material_name = $data['material_name'];
                if ($this->type_model->updateMaterialType())
                    $this->redirect('admin/materials');
            }
        }
         $this->view->form = $form;
    }
#delete material type
     public function deletematerialtypeAction()
    {
        $this->type_model->id = $this->getRequest()->getParam('id');
        $this->type_model->deleteMaterialType();
        $this->redirect('admin/materials');
    
    
    }


}

