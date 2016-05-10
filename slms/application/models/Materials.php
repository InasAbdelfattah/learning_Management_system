<?php

class Application_Model_Materials extends Application_Model_MyModel {
//class Application_Model_Materials extends Zend_Db_Table_Abstract {

    protected $_name = 'materials';
    protected $primary_key = "id";
    protected $fields = array('','');
    public $id;
    public $material_name;
    public $image;
    public $descib;
    public $material_type_id;
    public $course_id;
    function listMaterials() {
        return $this->list_data();
    }

    function getMaterial() {
        return $this->get_id();
//        return $this->select()
//        ->from('materials')
//        ->where('id='.$id);
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
