<?php
class Application_Form_Category extends Zend_Form {

    public function init()
    {
	$this->setAttrib('enctype', 'multipart/form-data');
        $this->setMethod('post');
	$course_name = new Zend_Form_Element_Text('course_name');
        $course_name ->setLabel('* Category Name : ')
                ->setAttrib('class', 'form-control')
                ->setRequired(true);
 	$id = new Zend_Form_Element_Hidden('id');
        
          
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Category Image :   Available extentions(jpeg,png,jpg)')
              ->setAttrib('class', ' btn btn-success changebutton');
                $image->addValidator(new Zend_Validate_File_IsImage)
                ->addValidator(new Zend_Validate_File_ImageSize(array('min' => 1, 'max' => 2000)))
                ->setDestination(APPLICATION_PATH.'/../public/img')
                ->setRequired(true);
                
        
                
        $is_active = new Zend_Form_Element_Radio('is_active',array('multiOptions' => array('true'=>'Active', 'false'=>'Deactive')));
        $is_active->setLabel('Active :')->addValidator('NotEmpty', true)->setAttrib('class', 'form-group btn btn-default');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Add Category');
       
        $this->addElements(
                array
                    (
                    $id, $course_name,$image, 
                    $is_active, $submit
        ));
    
	


    }
    
}



