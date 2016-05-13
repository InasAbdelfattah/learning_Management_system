<?php

class MaterialTypeController extends Zend_Controller_Action {

    private $model = null;

    public function init() {
        /* Initialize action controller here */
        $this->model = new Application_Model_MaterialTypes;

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
        else
                $this->redirect('user/login');
    }

    public function indexAction() {
        // action body
        $course_id = $this->getRequest()->getParam('course_id');

        $materials = new Application_Model_Materials;
        #select material_type_id from materials where course_id=$course_id

        $m = $materials->fetchAll($materials->select('*')->where("course_id=?", "$course_id"))->toArray();
        #$this->view->m = $m ;
        #select types from Materialtypes where id=$material_type_id
        $types = [];
        foreach ($m as $value) {
            $type_id = $value['material_type_id'];
            $types = $this->model->fetchAll($this->model->select('*')->where("id=?", "$type_id"))->toArray();
        }
        $this->view->types = $types;
        $this->view->course_id = $course_id;
    }

}

?>
