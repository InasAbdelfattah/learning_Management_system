<?php

class Application_Model_MyModel extends Zend_Db_Table_Abstract {

    protected $_name;
    protected $fields = array();
    protected $primary_key;

    function get_columns() {
        $row = $this->createRow();
        foreach ($this->fields as $column) {
            $row->$column = $this->$column;
        }
        return $row;
    }

    function list_data() {

        return $this->fetchAll()->toArray();
    }

    function get_id() {
        $primary_key = $this->primary_key;
        return $this->find($this->$primary_key)->toArray();
    }

    function add_data() {
        return $this->get_columns()->save();
    }

    function deleteID() {
        $primary_key = $this->primary_key;
        return $this->delete($this->primary_key . '=' . $this->$primary_key);
    }

    function edit() {
        $primary_key = $this->primary_key;
        $this->update($this->get_columns(), "$this->primary_key = $this->$primary_key");
    }

}