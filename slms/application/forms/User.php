<?php

class Application_Form_User extends Zend_Form {

    public function init() {
        $id = new Zend_Form_Element_Hidden('id');
        $username = new Zend_Form_Element_Text('username');
        $email = new Zend_Form_Element_Text('email');
        $password = new Zend_Form_Element_Password('password');
        $image = new Zend_Form_Element_Image('image');
        $signature = new Zend_Form_Element_Text('signature');
        $is_active = new Zend_Form_Element_Text('is_active');
        $is_admin = new Zend_Form_Element_Text('is_admin');
        $is_loged = new Zend_Form_Element_Text('is_loged');
        $joined_at = new Zend_Form_Element_Text('joined_at');
        $updated_at = new Zend_Form_Element_Text('updated_at');
        $submit = new Zend_Form_Element_Submit('submit');

//        $username->setAttrib('class', 'form-control');

        $email->setRequired()->addValidator(new Zend_Validate_EmailAddress)->addValidator(
                new Zend_Validate_Db_NoRecordExists(
                array
            (
            'table' => 'users',
            'field' => 'email'
                )
        ));

        $password->setRequired()->addValidator(new Zend_Validate_StringLength(array('min' => 5, 'max' => 32)));
        $image->addValidator(new Zend_Validate_File_IsImage)->addValidator(new Zend_Validate_File_ImageSize(array('min' => 1, 'max' => 2000)));


        $this->addElements(
                array
                    (
                    $id, $username, $email, $password, $image, $signature, $is_active,
                    $is_active, $is_loged, $joined_at, $updated_at, $submit
        ));








        /**/
    }

}
