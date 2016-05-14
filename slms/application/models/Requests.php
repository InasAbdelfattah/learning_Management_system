<?php

class Application_Model_Requests  extends Application_Model_MyModel
{    protected $_name = 'requests';
    protected $primary_key = "id";
    protected $fields = array("user_id","category_id","course_id","description");
    public $user_id;
    public $category_id;
    public $course_id;
    public $description;
    function addRequest() {
        return $this->add_data();
    }

    function unreadRequests()
    {
        $query=  $this->select('*')
                ->setIntegrityCheck(FALSE)
//                ->from('requests')
                ->join('users','requests.user_id=users.id');
        return  $this->fetchAll($query);
    
    }

}

