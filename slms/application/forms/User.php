<?php

class Application_Form_User extends Zend_Form {

    public function init() {
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setMethod('post');
//        $this->add(array(
//            'type' => 'Zend\Form\Element\Csrf',
//            'name' => 'csrf'
//        ));
        $image = new Zend_Form_Element_File('image');
        $id = new Zend_Form_Element_Hidden('id');
        $username = new Zend_Form_Element_Text('username');
        $email = new Zend_Form_Element_Text('email');
        $password = new Zend_Form_Element_Password('password');
        $signature = new Zend_Form_Element_Text('signature');
//        $captcha = new Zend_Form_Element_Captcha('captcha');
//        $captcha->setCaptcha(new Captcha\Dumb())->setLabel('Please verify you are human');
        $is_active = new Zend_Form_Element_Text('is_active');
        $is_admin = new Zend_Form_Element_Text('is_admin');
        $is_loged = new Zend_Form_Element_Text('is_loged');
        $joined_at = new Zend_Form_Element_Text('joined_at');
        $updated_at = new Zend_Form_Element_Text('updated_at');
        $submit = new Zend_Form_Element_Submit('submit');


        $username->setLabel('user name : ');
        $email->setLabel('Email : ');
        $signature->setLabel('Your Signature : ');
        $password->setLabel('password : ');

        $username->setAttrib('class', 'form-control');
        $email->setAttrib('class', 'form-control');
        $image->setAttrib('class', 'changeButton');
        $signature->setAttrib('class', 'form-control');
        $submit->setAttrib('class', 'btn btn-primary');

        $image->addValidator('Extension', false, 'jpeg,png,jpg')
                ->getValidator('Extension')->setMessage('This file type is not supportted.');
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
//        $image->setDestination(APPLICATION_PATH."/../img/user");
//        $image->setDestination($this->baseUrl.'img/user');

        $this->addElements(
                array
                    (
                    $id, $username, $email, $password, $image, $signature, $is_active,
                    $is_active, $is_loged, $joined_at, $updated_at, $submit
//                ,$captcha
        ));








        /**/
    }

}
