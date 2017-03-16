<?php

class Application_Form_UpdateCategory extends Zend_Form
{

    public function init()
    {
        $category = new Zend_Form_Element_Text("category");
        $category->setAttribs(array(
            "class" => 'form-control',
            'placeholder' => 'e.g. Sports'
        ));
        $category->setLabel("New category name");
        $category->setRequired();
        $category->addValidator("StringLength", false, array(4,100));
        
        $submit = new Zend_Form_Element_Submit("update");
        $submit->setAttrib("class", "btn btn-primary");
        
        $this->addElements(array($category, $submit));
    }


}

