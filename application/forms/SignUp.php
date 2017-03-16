<?php

class Application_Form_SignUp extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */


    	 $this->setMethod('post');





// username
        $userName=new Zend_Form_Element_Text('userName');
        $userName->setLabel('userName: ');
        $userName->setAttribs(array('class'=>'form-control','placeholder'=>'example. username'));
        $userName->setRequired();
        $userName->addValidator('StringLength', false, Array(3,10));
        $userName->addFilter('StringTrim');



        $email=new Zend_Form_Element_Text('email');
        $email->setLabel('Email: ');
        $email->setAttribs(array('class'=>'form-control','placeholder'=>'example@ yahoo.com'));
        $email->setRequired();
        $email->addValidator('StringLength', false, Array(10,50));
        $email->addFilter('StringTrim');



        $password=new Zend_Form_Element_Text('password');
        $password->setLabel('password: ');
        $password->setAttribs(array('class'=>'form-control'));





        $submit=new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class'=>'btn btn-success'));





        $reset=new Zend_Form_Element_Reset('reset');
        $reset->setAttribs(array('class'=>'btn btn-danger'));



      $this->addElements(array($userName,$email,$password,$submit,$reset));















    }


}

