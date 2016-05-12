<?php

class Application_Model_Requests  extends Application_Model_MyModel
{    protected $_name = 'requests';
    protected $primary_key = "id";
    protected $fields = array("user_id","category_id","course_id","status");
    public $user_id;
    public $category_id;
    public $course_id;
    public $status;
    function addRequest() {
        return $this->add_data();
    }



}

