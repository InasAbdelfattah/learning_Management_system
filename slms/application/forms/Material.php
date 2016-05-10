<?php

class Application_Form_Material extends Zend_Form {

    public function init() {
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setMethod('post');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $material_name = new Zend_Form_Element_Text('material_name');
        $material_name ->setLabel('* Material Name : ')
                ->setAttrib('class', 'form-control')
                ->setRequired(true);
        
        $descib = new Zend_Form_Element_Text('descib');
        $descib->setLabel('* Description : ')
                ->setAttrib('class', 'form-control')
                ->setRequired(true);
        
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Matrial Image :   Available extentions(jpeg,png,jpg)')
              ->setAttrib('class', ' btn btn-success changebutton');
                $image->addValidator(new Zend_Validate_File_IsImage)
                ->addValidator(new Zend_Validate_File_ImageSize(array('min' => 1, 'max' => 2000)))
                ->setDestination(APPLICATION_PATH.'/../public/img/materials_images_folder/')
                ->setRequired(true);
        
        $materialTypesObj = new Application_Model_MaterialTypes();
        $materialTypes = $materialTypesObj->listMaterialTypes();
        $avialableTypes = '';
        foreach ($materialTypes as $type)
        {
            $avialableTypes = $avialableTypes.$type['material_name'].",";
        }
        
        $path = new Zend_Form_Element_File('path');
        $path->setLabel('* Material File :  Available extentions('.$avialableTypes.')')
                ->setAttrib('class', 'form-group btn btn-danger')
               ->addValidator('Extension', false,$avialableTypes)
//               ->getValidator('Extension')
//                 ->setError('This File type is not supportted.')
                ->addValidator(new Zend_Validate_File_FilesSize(array('min' => 1, 'max' => 1125829.12)))
                ->setDestination(APPLICATION_PATH.'/../public/materials_upload_folder/')
                ->setRequired(true);
        
        $is_active = new Zend_Form_Element_Radio('is_active',array('multiOptions' => array('true'=>'Active', 'false'=>'Deactive')));
        $is_active->setLabel('Active :')->addValidator('NotEmpty', true)->setAttrib('class', 'form-group btn btn-default');
        
        $options = [];
        foreach ($materialTypes as $type)
        {
            $option[$type['id']] = $type['material_name']; 
        }
        $material_type_id = new Zend_Form_Element_Select('material_type_id',array('multiOptions' => $option));
        $material_type_id ->setLabel('Material Type')->addValidator('NotEmpty', true)->setAttrib('class', 'form-group btn btn-warning')->setRequired(true);
        
        
        
        
        $coursesObj = new Application_Model_Courses();
        $courses = $coursesObj->select('course_name','id')
                ->where('category_id > 0');
        
        $data = $coursesObj->fetchAll($courses)->toArray();
        foreach ($data as $type)
        {
           $options[$type['id']] = $type['course_name']; 
        }
        $course_id = new Zend_Form_Element_Select('course_id',array('multiOptions' => $options));
        $course_id-> setLabel('Course :')->setRequired(true)->addValidator('NotEmpty', true)->setAttrib('class', 'form-group btn btn-primary');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Add Material');
       
        $this->addElements(
                array
                    (
                    $id, $material_name,$image, $descib,$path, 
                    $is_active,$material_type_id, $course_id, $submit
        ));
    }

}