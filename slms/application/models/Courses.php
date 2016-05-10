<?php

class Application_Model_Courses extends Application_Model_MyModel {

    protected $_name = 'courses';
    protected $primary_key = "id";
    protected $fields = array("course_name","image","category_id","is_active");
    public $id;
    public $course_name;
    public $image;
    public $category_id;
    public $is_active;

    function listCourses() {
        return $this->list_data();
    }
    
     function listCategories() {
         
        return $this->list_data();
        
    }
    function getCategory() {
        return $this->get_id();
    }

}
