<?php

class Application_Model_Courses extends Application_Model_MyModel {

    protected $_name = 'courses';
    protected $primary_key = "id";
    protected $fields = array("course_name", "image", "category_id", "is_active");
    public $id;
    public $course_name;
    public $image;
    public $category_id;
    public $is_active;

#Category Operation ...

    function listCategories() {

        return $this->fetchAll($this->select('*')->where("category_id=?", "0"))->toArray();
    }

# by maram

    function getCategory() {
        $cat_id = $this->category_id;
        return $this->fetchAll($this->select('*')->where("category_id=?", "$cat_id"))->toArray();
    }

    function getCategoryByID() {
        return $this->get_id();
    }

# by salama

    function getoneCategory() {
        $cat_id = $this->category_id;
        return $this->fetchAll($this->select('*')->where("id=?", "$cat_id"))->toArray();
    }

    function addCategory() {
        return $this->add_data();
    }

    function deleteCategory() {
        return $this->delete_id();
    }

    function editCategory() {
        return $this->edit();
    }

    #Course Operation ...   

    function listCourses() {
        return $this->fetchAll($this->select('*')->where("category_id !=?", "0"))->toArray();
    }

    function getCourse() {

        return $this->get_id();
    }

    function addCourse() {
        return $this->add_data();
    }

    function deleteCourse() {
        return $this->delete_id();
    }

    function editCourse() {
        return $this->edit();
    }

    function categoryCourses($cat_id) {
        $courses = $this->fetchAll($this->select('*')->where('category_id=?', $cat_id))->toArray();
        return $courses;
        
    }

}
