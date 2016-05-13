<?php

class Application_Model_Materials extends Application_Model_MyModel {

//class Application_Model_Materials extends Zend_Db_Table_Abstract {

    protected $_name = 'materials';
    protected $primary_key = "id";
    protected $fields = array('material_name', 'image', 'descib', 'path', 'created_at', 'material_type_id', 'course_id', 'is_active');
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
                ->join('material_types', 'materials.material_type_id=material_types.id'
                        , array('type' => 'material_types.material_name', 'typeId' => 'material_types.id'))
                ->join('courses', 'materials.course_id = courses.id and courses.category_id != 0 '
                , array('Course' => 'courses.course_name', 'CourseId' => 'courses.id', 'CategoryId' => 'courses.category_id'))
        ;
        return $this->fetchAll($select)->toArray();
//        return $this->fetchRow($select);
    }

    function getCategory($id) {
        $select = $this->select()
                ->from('courses', '*')
                ->setIntegrityCheck(false)
                ->where('course.id = ' . $id);
        return $this->fetchAll($select)->toArray();
    }

    function getCategoryByCorID($id) {
        $select = $this->select()
                ->where('course_id = ' . $id);
        return $this->fetchAll($select)->toArray();
    }

    function activeMaterial($state, $action) {
        $now = new Zend_Date();
        
        if ($action == 2) {
            if ($state == 1) {
                $sql = "Update materials set is_active = 0 
        Where id =" . $this->id;
            } else {
                $sql = "Update materials set is_active = 1 
        Where id =" . $this->id;
            }
        }
        elseif($action == 1) {
            if ($state == 1) {
                $sql = "Update materials set is_downloadable = 0 
        Where id =" . $this->id;
            } else {
                $sql = "Update materials set is_downloadable = 1 
        Where id =" . $this->id;
            }
        }
        $query = $this->getAdapter()->query($sql);
        $query->execute();
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
