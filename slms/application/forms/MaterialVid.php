<?php

class Application_Form_MaterialVid extends Zend_Form {

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
               ->setRequired(false)
                ->setAllowEmpty(true);
        
        $materialTypesObj = new Application_Model_MaterialTypes();
        $select = $materialTypesObj->select()->where("`type` = 'vid'");
        $materialTypes = $materialTypesObj->fetchAll($select)->toArray();
        $avialableTypes = '';
        foreach ($materialTypes as $type)
        {
            $avialableTypes = $avialableTypes.$type['material_name'].",";
        }
        $massage = new Zend_Form_Element_Note('massage');
        $massage->setAttrib('class', 'form-control alert alert-warning')
        ->setLabel('* You May upload you video or add link from you tube, Notice: if you upload file we will not check for your link --');
        
        $path = new Zend_Form_Element_File('path');
        $path->setLabel('* Material File :  Available extentions('.$avialableTypes.'), min-size:10KB max-siz:100MB')
                ->setAttrib('class', 'form-group btn btn-danger')
               ->addValidator('Extension', false,$avialableTypes)
                ->addValidator(new Zend_Validate_File_FilesSize(array('min' => '10kB', 'max' => '100MB')))
                ->setDestination(APPLICATION_PATH.'/../public/materials_upload_folder/')
                ;
        $link = new Zend_Form_Element_Text('link');
        $link->setLabel('* Material Link :  From Youtube')
                ->setAttrib('class', 'form-control')
                ;
        
       #check if this material can be dowenload
        $is_downloadable = new Zend_Form_Element_Radio('is_downloadable',array('multiOptions' => array('1'=>'Accept', '0'=>'Refuse')));
        $is_downloadable->setLabel('users can dowenload :')->addValidator('NotEmpty', true)->setAttrib('class', 'form-group btn btn-default');
        # check if this material active 
        $is_active = new Zend_Form_Element_Radio('is_active',array('multiOptions' => array('1'=>'Active', '0'=>'Deactive')));
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
                    $id, $material_name,$image, $descib,$material_type_id,$massage,$path,$link, 
                    $is_active,$is_downloadable, $course_id, $submit
        ));
    }

}
