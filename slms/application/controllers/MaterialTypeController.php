<?php

class MaterialTypeController extends Zend_Controller_Action
{
    private $model = null;
    public function init()
    {
        /* Initialize action controller here */
        $this->model = new Application_Model_MaterialTypes;
    }

    public function indexAction()
    {
        // action body
        $course_id=$this->getRequest()->getParam('course_id');
        
        $materials = new Application_Model_Materials;
        #select material_type_id from materials where course_id=$course_id

        $m=$materials->fetchAll($materials->select('*')->where("course_id=?","$course_id"))->toArray();
        #$this->view->m = $m ;
        #select types from Materialtypes where id=$material_type_id
        $types=[];
        foreach ($m as $value) {
            $type_id=$value['material_type_id']; 
            $types=$this->model->fetchAll($this->model->select('*')->where("id=?","$type_id"))->toArray();
        }
         $this->view->types = $types ;
        $this->view->course_id=$course_id;
    }
}

?>