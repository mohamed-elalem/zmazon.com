<?php

class Application_Form_EditCategoryImage extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);
        
        $categoryPhoto = new Zend_Form_Element_File("photo");
        $categoryPhoto->setLabel("Image")
                ->setDestination("images")
                ->setRequired()
                ->setDescription("Upload image")
                ->addValidator('Count', false, 1)
                ->addValidator('Size', false, 2097152)
                ->addValidator('Extension', false, 'jpg,png,jpeg,ico,bmp');
        
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setAttribs(array(
            'class' => 'btn btn-primary'
        ));
        
        
        
        
        $this->addElements(array($categoryPhoto, $submit));
    }


}

