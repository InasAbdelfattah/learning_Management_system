<?php

class Application_Form_Materialtype extends Zend_Form {

    public function init() {
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setMethod('post');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $material_name = new Zend_Form_Element_Text('material_name');
        $material_name ->setLabel('* Type Extintion : ')
                ->setAttrib('class', 'form-control')
                ->setRequired(true);
        
        $type = new Zend_Form_Element_Select('type',array('multiOptions' => array('vid'=>'Video', 'doc'=>'Document')));
        $type->setLabel('Type :')->addValidator('NotEmpty', true)->setAttrib('class', 'form-group btn btn-default');
        
       
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Add Material');
       
        $this->addElements(
                array
                    (
                    $id, $material_name, $type, $submit
        ));
    }

}
