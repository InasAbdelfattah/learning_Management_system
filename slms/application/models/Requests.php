<?php

class Application_Model_Requests extends Application_Model_MyModel {

    protected $_name = 'requests';
    protected $primary_key = "id";
    protected $fields = array("user_id", "category_id", "course_id", "description");
    public $user_id;
    public $category_id;
    public $course_id;
    public $description;

    function addRequest() {
        return $this->add_data();
    }

    function unreadRequests() {
        $query = $this->select('*')
                ->setIntegrityCheck(FALSE)
//                ->from('requests')
                ->join('users', 'requests.user_id=users.id', array('users.email'))
                ->join('courses', 'requests.category_id=courses.id', array('categoryName' => 'courses.course_name'))
                ->where('status=?',0);
//        ->join('courses', 'requests.course_id=courses.id and courses.category_id != 0 ',
//                array('courseName'=>'courses.course_name'));


        return $this->fetchAll($query);
    }

}
