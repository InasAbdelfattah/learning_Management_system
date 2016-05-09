<?php

class Application_Model_Materials extends Application_Model_MyModel {

    protected $_name = 'materials';
    protected $primary_key = "id";
    protected $fields = array('','');

    function listMaterials() {
        return $this->list_data();
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
