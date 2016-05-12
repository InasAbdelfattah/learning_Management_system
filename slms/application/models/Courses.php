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
#
    //list all category to admin.
    function listCategories() {

        return $this->fetchAll($this->select('*')->where("category_id=?", "0"))->toArray();
    }
    
    //list active category only to user.
    function listActiveCategories() {
         
        return $this->fetchAll($this->select('*')->where("category_id=?","0")->where("is_active",1))->toArray();
        
    }

    //get category of this course .
    function getCategory() 
    {
       $cat_id = $this->category_id;
       return $this->fetchAll($this->select('*')->where("category_id=?","$cat_id")->where("is_active",1))->toArray();
    }

    //get category by id.
    function getCategoryByID() {
        return $this->get_id();
    }

# by salama
    function getoneCategory() {
        $cat_id = $this->category_id;
        return $this->fetchAll($this->select('*')->where("id=?", "$cat_id"))->toArray();
    }
    //add category.
    function addCategory() {
        return $this->add_data();
    }
    
    //delete category.
    function deleteCategory() {
        return $this->delete_id();
    }
    //edit category.
    function editCategory() {
        return $this->edit();
    }

    #Course Operation ...   
    
    //list all courses to admin.
    function listCourses() {
        return $this->fetchAll($this->select('*')->where("category_id !=?", "0"))->toArray();
    }
    
    //get active courses only to show.
    function listActiveCourses() {
         return $this->fetchAll($this->select('*')->where("category_id !=?","0")->where("is_active",1))->toArray();
    }
    
    //get course by id.
    function getCourse() {

        return $this->get_id();
    }
    //add course.
    function addCourse() {
        return $this->add_data();
    }

    
    //delete course .
    function deleteCourse() {
        return $this->delete_id();
    }

    //edit course.
    function editCourse() {
        return $this->edit();
    }

    function categoryCourses($cat_id) {
        $courses = $this->fetchAll($this->select('*')->where('category_id=?', $cat_id))->toArray();
        return $courses;
        
    }
    
    function makeActive()
    {
        //
    }

}
