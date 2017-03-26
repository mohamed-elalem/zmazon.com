<?php

class Application_Form_Comment extends Zend_Form
{

    public function init()
    {
        $textarea = new Zend_Form_Element_Textarea('comment');
        $textarea->setRequired();
        $textarea->setLabel('Add comment');
        $textarea->setAttribs(['rows' => 3 , 'class'=> 'comment-body']);
        
        $submit = new Zend_Form_Element_Button('Add Comment');
        $submit->setAttrib('class', 'comment-submit-btn btn btn-primary');
        
        $this->addElements([$textarea , $submit]);
    }
    


}

