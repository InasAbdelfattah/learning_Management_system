<?php

class Application_Form_Requset extends Zend_Form {

    public function init() {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setMethod('post');
//         $this->addElement(new Application_Form_HandleSelect());
        $categoryType = new Application_Model_MaterialTypes();
//        $csrf = new Zend_Form_Element_Csrf('security');
        $id = new Zend_Form_Element_Hidden('id');

        $category = new Zend_Form_Element_Checkbox('category');
        $category->setLabel('* Choose Category :')
                ->setCheckedValue(1)
                ->setUncheckedValue(0)
                ->setRequired(true);

        $course = new Zend_Form_Element_Checkbox('course');
        $course->setLabel('* Choose Course :')
                ->setCheckedValue(1)
                ->setUncheckedValue(0);

        $courseStatus = new Zend_Form_Element_Text('courseStatus', array(
            'decorators' => array('ViewHelper', (array('Label', array('class' => 'blue-color', 'placement' => 'prepend'))))));
        $courseStatus->setLabel('* Status : ')
                ->setAttrib('class', 'form-control');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Send Request')
                ->setAttrib('class', 'btn btn-primary');
        
        $country = $this->createElement('select', 'country');
        $country->setLabel('country: ')
                ->addMultiOption(0, 'Please select......')
                ->addMultiOption(1,'name')
                ->addMultiOption(2,'email')
                ->setAttrib('class', 'form-control')
                ->setRequired(true);

        $this->addElements(
                array
                    (
                    $id, $category, $course,$country, $courseStatus, $submit
        ));
    }

}
