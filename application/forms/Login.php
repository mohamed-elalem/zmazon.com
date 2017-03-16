<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');
     
        $email=new Zend_Form_Element_Text('email');
		$email->setLabel('Email: ');
		$email->setAttribs(array('class'=>'form-control'));


        $password=new Zend_Form_Element_Password('password');
		$password->setLabel('password: ');
		$password->setAttribs(array('class'=>'form-control'));

        $submit=new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class'=>'btn btn-success'));

        $reset=new Zend_Form_Element_Reset('reset');
        $reset->setAttribs(array('class'=>'btn btn-danger'));

		$this->addElements(array($email,$password,$submit,$reset));

    }


}

