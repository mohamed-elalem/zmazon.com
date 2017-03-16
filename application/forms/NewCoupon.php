<?php

class Application_Form_NewCoupon extends Zend_Form
{

    public function init()
    {
        $discount = new Zend_Form_Element_Text('discount');
        $discount->setAttribs(array(
            'class' => 'form-control',
            'placeholder' => 'e.g. 30 is 30%'
        ));
        $discount->setLabel("Discount");
        $discount->setRequired();
        $discount->setValidators(array(
                array('Between', false, array('min' => 1, 'max' => 100))
            )
        );
        //$discount->addFilter("int");
        
        $this->addElement($discount);
    }


}

