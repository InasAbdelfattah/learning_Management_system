<?php

class Application_Model_Users extends Application_Model_MyModel {

    protected $_name = 'users';
    protected $primary_key = "id";
    protected $fields = array("username", "email", "password", "image", "signature", "is_active", "is_admin", "is_loged", "last_login", "joined_at", "updated_at");
    public $id;
    public $username;
    public $email;
    public $password;
    public $image;
    public $signature;
    public $is_active;
    public $is_admin;
    public $is_loged;
    public $last_login;
    public $joined_at;
    public $updated_at;

    function listUsers() {
        return $this->list_data();
    }

    function getUser() {
        return $this->get_id();
    }

    function addUser() {
        return $this->add_data();
    }

    function register() {
        $this->fields = array("username", "email", "password", "signature", "image");

//        $this->add_data();
        if ($this->add_data()) {
            $email = $this->email;
            $password = $this->password;
            $dp = Zend_Db_Table::getDefaultAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($dp, $this->_name, 'email', 'password');
            $authAdapter->setIdentity($email)->setCredential($password);
            $result = $authAdapter->authenticate();

            /////////////////////////////////////////////////////////////////////
//            mail('abanob.todary@gmail.com', 'My Subject', 'login');

            require_once 'Zend/Mail/Transport/Smtp.php';
            $tr = new Zend_Mail_Transport_Sendmail('abanob.todary@gmail.com');
            Zend_Mail::setDefaultTransport($tr);
            $mail = new Zend_Mail();
            $mail->setBodyText('slms-ahmedsalama.rhcloud.com/user/active/email/'.$email);
            $mail->setFrom('abanoub.raafat.todary@gmail.com', 'Site Adime');
            $mail->addTo($email, $this->username);
            $mail->setSubject('active account');
            $mail->send();

            ///////////////////////////////////////////////////////////////////////
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

    function deleteUser() {
        return $this->delete_id();
    }

    function updateUser() {
        $this->fields = array("username", "email", "image", "signature");
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

            $this->auth = Zend_Auth::getInstance()->getIdentity();
            $this->id = $this->auth->id;

            return $this->get_id();
        } else {
            return FALSE;
        }
    }

    function IsActive() {
        $this->fields = array("is_active");
        return $this->edit();
    }

    function IsAdmin() {
        $this->fields = array("is_admin");
        return $this->edit();
    }

    function IsLoged() {
        $this->fields = array("is_loged");
        return $this->edit();
    }

    function LastLogin() {
        $this->fields = array("last_login", "is_loged");
        return $this->edit();
    }

    function out() {
        $this->fields = array("is_loged");
        return $this->edit();
    }

    function active() {
        $row = array();
        $row['is_active'] = 1;
        return $obj->update($row, 'email' . '=' . $this->email);
    }

}
