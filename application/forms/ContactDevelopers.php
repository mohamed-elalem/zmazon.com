<?php

class Application_Form_ContactDevelopers extends Zend_Form
{

    public function init()
    {
        $subject = new Zend_Form_Element_Text("subject");
        $subject->setAttribs(array(
            "placeholder" => "Brief problem description",
            "class" => "form-control"
        ))
                ->setRequired();
        
        $content = new Zend_Form_Element_Textarea("content");
        $content->setAttribs(array(
            "placeholder" => "Full problem description",
            "class" => "form-control",
            "rows" => "8",
            "style" => "resize: none;"
        ))
                ->setRequired();
                
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setAttribs(array(
            "class" => "btn btn-default"
        ));
        
        $this->addElements(array($subject, $content, $submit));
        
    }


}

