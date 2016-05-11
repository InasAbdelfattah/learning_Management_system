<?php

class AdminController extends Zend_Controller_Action
{
    private $model;
    public function init()
    {
        /* Initialize action controller here */
         $this->model = new Application_Model_Materials();
         $this->cat_model = new Application_Model_Courses;
         $this->_helper->layout->setLayout('admin');
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


}

