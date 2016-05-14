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
        # send loged in user data
        $this->user_model = new Application_Model_Users();
        $this->auth = Zend_Auth::getInstance()->getIdentity();
        if (isset($this->auth)) {
            $layout = $this->_helper->layout();
            $this->user_model->id = $this->auth->id;
            $currunt_user = $this->user_model->getUser();
            if ($currunt_user[0]['is_active'] == 1 && $currunt_user[0]['is_admin'] == 1)
                $layout->user = $currunt_user;
            elseif ($currunt_user[0]['is_admin'] != 1)
                $this->redirect('index');
            else
                $this->redirect('user/login');
        }
       else
       $this->redirect('user/login');
    }

#all index of control by salama

    public function indexAction() {
        //list All matrials with it's full data
        $time = new Zend_Date();
        $date = strtotime($time) - (48 * 60 * 60);
        $previousDay = date('Y-m-d H:i:s', $date);
        // lest recent materials of 48 hours
        $select = $this->model->select()
                ->order('created_at DESC')
                ->where("created_at >= '" . $previousDay . "'");
        $this->view->materials = count($this->model->fetchAll($select)->toArray());

        // lest recent materials of 48 hours
        $commentsDB = new Application_Model_Comments();
        $select = $commentsDB->select()
                ->order('created_at DESC')
                ->where("created_at >= '" . $previousDay . "'");
        $this->view->comments = count($commentsDB->fetchAll($select)->toArray());

        // lest recent orders of 48 hours
        $requestsDB = new Application_Model_Requests();
        $select = $requestsDB->select()
                      ->order('created_at DESC')
                      ->where("created_at >= '".$previousDay."'");
        $this->view->requests = count($requestsDB->fetchAll($select)->toArray());
        
        // lest recent online of 48 hours
        $select = $this->user_model->select()
                      ->where("`is_active` = '1' and `is_loged` = '1'");
        $this->view->users = count($this->user_model->fetchAll($select)->toArray());
        
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

    public function editcategoryAction() {
        $this->cat_model->id = $this->getRequest()->getParam('id');
        $id = $this->cat_model->id;

        $old = $this->cat_model->getCategoryByID();
        var_dump($old);
        $form = new Application_Form_Category();
        $form->populate($old[0]);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->cat_model->update($data, "id=$id");
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
                $this->cat_model->is_active = $data['is_active'];
                if ($this->cat_model->addCategory($data))
                    $this->redirect('admin/course');
            }
        }
        $this->view->form = $form;
    }

    public function editcourseAction() {
        $this->cat_model->id = $this->getRequest()->getParam('id');
        $old = $this->cat_model->getCategoryByID();
        $form = new Application_Form_Course();
        $form->populate($old[0]);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->cat_model->course_name = $data['course_name'];
                $this->cat_model->image = $data['image'];
                $this->cat_model->category_id = $data['course_id'];
                $this->cat_model->is_active = $data['is_active'];
                $this->cat_model->editCourse();
                $this->redirect("admin/course");
            }
        }
        $this->view->form = $form;
        $this->render('addcourse');
    }

    public function categorydetailsAction() {
        $this->cat_model->category_id = $this->getRequest()->getParam('id');
        $this->view->category = $this->cat_model->getCategory();
    }

// get material by course_id...  
    public function materialAction() {
        $id = $this->getRequest()->getParam('id');
        $this->view->materials = $this->model->getCategoryByCorID($id);
    }

#materials....    

    public function materialsAction() {
        //list All matrials with it's full data
        $materials = $this->model->listMaterials();
        $this->view->materials = $materials;
//        // list marial types
//        $matrialTypesDB = new Application_Model_MaterialTypes();
//        $materialsTypes = $matrialTypesDB->listMaterialTypes();
//        $this->view->materialsTypes = $materialsTypes;
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
        $action = $this->getRequest()->getParam('do');
        $this->model->activeMaterial($state,$action);
        $this->redirect('admin/materials');
    }

#add new material

    public function addmaterialdocAction() {
        $form = new Application_Form_MaterialDoc();
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
                $this->model->is_downloadable = $data['is_downloadable'];
                $this->model->is_active = $data['is_active'];
                if ($this->model->addMaterial($data))
                    $this->redirect('admin/materials');
            }
        }
        $this->view->form = $form;
    }

#edit new material

    public function editmaterialAction() {
        $form = new Application_Form_MaterialDoc();
        $this->model->id = $this->getRequest()->getParam('id');
        $material = $this->model->getMaterial();
//         $form->removeElement('image');
         $form->removeElement('path');
         $form->removeElement('material_type_id');
         $form->removeElement('course_id');
        $form->populate($material[0]);
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->model->material_name = $data['material_name'];
//                $this->model->image = $data['image'];
                $this->model->descib = $data['descib'];
//                $this->model->path = $data['path'];
//                $this->model->material_type_id = $data['material_type_id'];
//                $this->model->course_id = $data['course_id'];
                $this->model->is_downloadable = $data['is_downloadable'];
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
                $this->type_model->type = $data['type'];
                if ($this->type_model->addMaterialType())
                    $this->redirect('admin/materialtypes');
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
                $this->type_model->type = $data['type'];
                if ($this->type_model->updateMaterialType())
                    $this->redirect('admin/materialtypes');
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
    
    
      public function usersAction() {
        $this->view->users = $this->user_model->listUsers();
    }











    //comments control

       public function editcommentAction(){
        $id = $this->getRequest()->getParam('id');
        $material_id = $this->getRequest()->getParam('material_id');
        $comment_obj= new Application_Model_Comments();
        $comment_obj->id=$id;
        $comment=$comment_obj->getComment();
        $user_id=$comment[0]['user_id'];
        $user_obj= new Application_Model_Users();
        $user_obj->id=$user_id;
        $user=$user_obj->getUser();
        $username=$user[0]['username'];
        $this->view->username = $username;
        #comments
        $comments = $comment_obj->listComments();
        #$comments = $comment_obj->fetchAll($this->model->select('*')->where('material_id =?',$material_id ))->toArray();
        $this->view->comments = $comments;
        $form = new Application_Form_Comment();
        $form->populate($comment[0]);
        if($this->getRequest()->isPost()){
            if($form->isValid($this->getRequest()->getParams())){
                $data = $form->getValues();
                $comment_obj->comment = $data['comment'];
                $comment_obj->material_id = $data['material_id'];
                $comment_obj->user_id =$user_id;
                if ($comment_obj->updateComment())
                    $form->reset();
                $this->redirect('admin/comment');
                
            }
        }
        $this->view->form = $form;
        $this->render('comment');

   }
    function deletecommentAction(){
        $material_id = $this->getRequest()->getParam('material_id');
        $id = $this->getRequest()->getParam('id');
        $comment_obj= new Application_Model_Comments();
        $comment =$comment_obj->id=$id;
        $comment=$comment_obj->deleteComment();
        $this->redirect('admin/comment');
    } 

   public function commentAction(){
    $comment_obj=new Application_Model_Comments();
    $comments=$comment_obj->listComments();
    $this->view->comments=$comments;
   } 

#materials types ....    

    public function materialtypesAction() {
        //list All matrials with it's full data
//        $materials = $this->model->listMaterials();
//        $this->view->materials = $materials;
//        // list marial types
        $matrialTypesDB = new Application_Model_MaterialTypes();
        $materialsTypes = $matrialTypesDB->listMaterialTypes();
        $this->view->materialsTypes = $materialsTypes;
    }

#add new material
    public function addmaterialvidAction() {
        $form = new Application_Form_MaterialVid();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getParams())) {
                $data = $form->getValues();
                $this->model->material_name = $data['material_name'];
                if ($data['image'])
                    $this->model->image = $data['image'];
                else
                    $this->model->image = 'defaultmaterial.png';

                $this->model->descib = $data['descib'];
                if($data['path'])
                    $this->model->path = $data['path'];
                else
                    $this->model->path = $data['link'];
                $this->model->material_type_id = $data['material_type_id'];
                $this->model->course_id = $data['course_id'];
                $this->model->is_active = $data['is_downloadable'];
                $this->model->is_active = $data['is_active'];
                if ($this->model->addMaterial($data))
                    $this->redirect('admin/materials');
            }
        }
        $this->view->form = $form;
    }
    
    public function requestsAction(){
        
        $this->request_model = new Application_Model_Requests();
        $ureadrqst=  $this->request_model->unreadRequests();
        $this->view->unreadrqsts=$ureadrqst;
        
    }
    
    
    
    
    
    
    
    
    
    
    
    

}