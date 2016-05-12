<?php

class Application_Model_Comments extends Application_Model_MyModel
{
    protected $_name = 'comments';
    protected $primary_key = "id";
    protected $fields = array('comment', 'user_id', 'material_id', 'created_at');
    public $comment ;
    public $user_id ;
    public $material_id ;


    function listComments() {
        return $this->list_data();
     
    }

    function getComment() {
        return $this->get_id();
       
    }

   /* function addComment() {
        return $this->add_data();
    }*/

    function deleteComment() {
        return $this->delete_id();
    }

    function updateComment() {
        return $this->edit();
    }

  /*  	function addComment($commentInfo){
		$row = $this->createRow();
        #$row->user_id = $id;
		$row->user_id = 2;
		$row->material_id = $commentInfo['material_id'];
		$row->comment = $commentInfo['comment'];

		return $row->save();
	}*/
function addComment() {
        return $this->add_data();
    }
}

