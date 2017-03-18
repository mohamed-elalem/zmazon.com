<?php

class Application_Form_Rating extends Zend_Form
{

    public function init()
    {
        $rating= new Zend_Form_Element_Radio('Rating');
        $rating->addMultiOptions(array(
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5'
        ));
        $rating->setLabel('Add rating for this product');
        $rating->setAttrib('class', 'form-control');
        
        $submit = new Zend_Form_Element_Submit('Add rating');
        $this->addElements([$rating, $submit]);
    }


}

