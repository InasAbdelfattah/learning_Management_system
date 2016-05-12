<?php

class Application_Model_MaterialTypes  extends Application_Model_MyModel
{
    protected $_name = 'material_types';
    protected $primary_key = "id";
    protected $fields = array("material_name");
    public $id;
    public $material_name;
    function listMaterialTypes() {
        return $this->list_data();
     
    }

    function getMaterialType() {
        return $this->get_id();
       
    }

    function addMaterialType() {
        return $this->add_data();
    }

    function deleteMaterialType() {
        return $this->delete_id();
    }

    function updateMaterialType() {
        return $this->edit();
    }

}
