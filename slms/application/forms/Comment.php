<?php

class Application_Form_Comment extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $id = new Zend_Form_Element_Hidden('id');
        $material_id=new Zend_Form_Element_Hidden('material_id');
        #$user_id=new Zend_Form_Element_Hidden('user_id');
		$comment = new Zend_Form_Element_Text('comment');
        $comment->setRequired();
		$submit = new Zend_Form_Element_Submit('submit');
		#$submit->setAttrib('class', 'btn');
		#$submit->setAttrib('class', 'btn btn-primary');
		$this->addElements(array($id,$material_id,$comment,$submit));
    }


}

