<?php

class Application_Model_Users extends Application_Model_MyModel {

    protected $_name = 'users';
    protected $primary_key = "id";
    protected $fields = array("username", "email", "password", "image", "signature", "is_active", "is_admin", "is_loged", "joined_at", "updated_at");
    public $id;
    public $username;
    public $email;
    public $password;
    public $image;
    public $signature;
    public $is_active;
    public $is_admin;
    public $is_loged;
    public $joined_at;
    public $updated_at;

    function listUsers() {
        return $this->list_data();
    }

//    function getUserById($id) {
//        return $this->find($id)->toArray();
//    }


    function saveData($data) {
        $row = $this->createRow();
//        $row->username = $data['username'];
//        $row->email = $data['email'];
//        $row->signature = $data['signature'];
//        $row->image = "/images/" . $data['image'];
        $tme = new Zend_Date();
        $data['updated_at'] = $tme->now();
//        $row->updated_at=$tme->now();
//        return $row->save();
        $data['image'] = "/img/user/" . $data['image'];
        return $this->update($data, "id=2");
//         var_dump($row);		
    }

    function getUser() {
        return $this->get_id();
    }

    function addUser() {
        return $this->add_data();
    }

    function register() {
        $this->fields = array("username", "email", "password","signature");
        return $this->add_data();
        
    }

    function deleteUser() {
        return $this->delete_id();
    }

    function updateUser() {
        return $this->edit();
    }

    function loginUser($param) {

        $email = $param['email'];
        $password = $param['password'];

        $dp = Zend_Db_Table::getDefaultAdapter();

        $authAdapter = new Zend_Auth_Adapter_DbTable($dp, $this->_name, 'email', 'password');
        $authAdapter->setIdentity($email)->setCredential(md5($password));

        $result = $authAdapter->authenticate();
        if ($result->isValid()) {
            $auth = Zend_Auth::getInstance();
            $storage = $auth->getStorage();
            $storage->write($authAdapter->getResultRowObject(array('id', 'email')));

            return TRUE;
        } else {
            return FALSE;
        }
    }

}
