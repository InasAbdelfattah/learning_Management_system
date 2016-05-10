<?php

class Application_Model_Materials extends Application_Model_MyModel {
//class Application_Model_Materials extends Zend_Db_Table_Abstract {

    protected $_name = 'materials';
    protected $primary_key = "id";
    protected $fields = array('material_name','image','descib','path','created_at','material_type_id','course_id','is_active');
    public $id;
    public $material_name;
    public $image;
    public $descib;
    public $path;
    public $created_at;
    public $material_type_id;
    public $course_id;
    public $is_active;
    function listMaterials() {
//        return $this->list_data();
        $select = $this->select('*')
                ->setIntegrityCheck(false)
                ->join('courses','materials.course_id = courses.id'
                ,array('course'=>'courses.course_name','courseId'=>'courses.id'))
                ->join('material_types','materials.material_type_id=material_types.id'
                ,array('type'=>'material_types.material_name','typeId'=>'material_types.id'));
        return $this->fetchAll($select)->toArray();
//        return $this->fetchRow($select);
    }

    function getMaterial() {
        return $this->get_id();
       
    }

    function addMaterial() {
        return $this->add_data();
    }

    function deleteMaterial() {
        return $this->delete_id();
    }

    function updateMaterial() {
        return $this->edit();
    }
    

}
