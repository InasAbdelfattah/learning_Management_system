<?php

class Application_Model_Downloads  extends Application_Model_MyModel
{
   protected $_name = 'downloads';
    protected $primary_key = "id";
    protected $fields = array('user_id', 'material_id', 'downloaded_at');
    public $user_id ;
    public $material_id ;
    public $downloaded_at; 


    function listDowenloads() {
        $select= $this->select('*');
        return count($this->fetchAll($select)->toArray());
                
     
    }

    function getDowenload($material_id) {
        $select= $this->select('*')
                ->where('material_id = '.$material_id);
        return count($this->fetchAll($select)->toArray());
       
    }
    function addDowenload() {
        return $this->add_data();
    }
}

