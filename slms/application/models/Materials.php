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

    function activeMaterial($state) {
        if ($state == 1)
            $data = array('is_active' => 0);
        else
            $data = array('is_active' => 1);
        $where = 'id = ?' . $this->id;
        $this->update($data, $where);
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
