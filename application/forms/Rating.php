<?php

class Application_Form_Rating extends Zend_Form
{

    public function init()
    {
       $element = new Zend_Form_Element_Radio('rating');
        $element->addMultiOptions(array(
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5'
        ))
            ->setDecorators(array(array('ViewScript', array('viewScript' => 'index/product-details.phtml'))));
        $this->addElement($element);
    }


}

