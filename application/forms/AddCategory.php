<?php

class Application_Form_AddCategory extends Zend_Form
{

    public function init()
    {
        $categoryName = new Zend_Form_Element_Text("new_category_name");
        $categoryName->setAttribs(array(
            'class' => "form-control",
            'placeholder' => 'e.g. Sports'
        ));
        $categoryName->setLabel("Category name");
        $categoryName->setRequired();
        $categoryName->addValidator("StringLength", false, array(4, 80));
        
        $this->addElement($categoryName);
    }


}

