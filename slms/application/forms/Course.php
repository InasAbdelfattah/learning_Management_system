<?php

class Application_Form_Course extends Zend_Form {

    public function init() {
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setMethod('post');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $course_name = new Zend_Form_Element_Text('course_name');
        $course_name ->setLabel('* Course Name : ')
                ->setAttrib('class', 'form-control')
                ->setRequired(true);
        
    
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Matrial Image :   Available extentions(jpeg,png,jpg)')
              ->setAttrib('class', ' btn btn-success changebutton');
                $image->addValidator(new Zend_Validate_File_IsImage)
                ->addValidator(new Zend_Validate_File_ImageSize(array('min' => 1, 'max' => 2000)))
                ->setDestination(APPLICATION_PATH.'/../public/img/courses_images_folder/');
     
        
//        $is_active = new Zend_Form_Element_Radio('is_active',array('multiOptions' => array('true'=>'Active', 'false'=>'Deactive')));
//        $is_active->setLabel('Active :')->addValidator('NotEmpty', true)->setAttrib('class', 'form-group btn btn-default');
        
        $options = [];
       
        
        
        $cat = new Application_Model_Courses();
        $categories = $cat-> listCategories();
 
        foreach ($categories as $type)
        {
           $options[$type['id']] = $type['course_name']; 
        }
        $course_id = new Zend_Form_Element_Select('course_id',array('multiOptions' => $options));
        $course_id-> setLabel('Course :')->setRequired(true)->addValidator('NotEmpty', true)->setAttrib('class', 'form-group btn btn-primary');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Add course');
       
        $this->addElements(
                array
                    (
                    $id, $course_name,$image,  $course_id, $submit
//                    $is_active
        ));
    }

}
