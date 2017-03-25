<?php

class Application_Form_SignUp extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */


    	 $this->setMethod('post');





// username
        $userName = new Zend_Form_Element_Text('userName');
        $userName->setLabel('Username');
        $userName->setAttribs(array('class'=>'form-control','placeholder'=>'e.g. username'));
        $userName->setRequired();
        $userName->addValidator('StringLength', false, Array(10,45));
        $userName->addFilter('StringTrim');



        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email');
        $email->setAttribs(array('class'=>'form-control','placeholder'=>'e.g. exmaple@yahoo.com'));
        $email->setRequired();
        $email->addValidator('StringLength', false, Array(10,50));
        $email->addValidator('EmailAddress', true);
        $email->addFilter('StringTrim');



        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('password');
        $password->setAttribs(array('class'=>'form-control'))
                ->setRequired()
                ->addValidator("StringLength", false, array(10, 150));
        
        $confirmPassword = new Zend_Form_Element_Password("confirm_password");
        $confirmPassword->setLabel("Password confirmation")
                ->setRequired()
                ->setAttribs([
                    "class" => "form-control"
                ])
                ->addValidator(new Zend_Validate_Identical("password"));

        
        $privilege = new Zend_Form_Element_Select("privilege");
        $privilege->setAttribs([
            "class" => "form-control"
        ])
                ->setRequired()
                ->addMultiOptions([
                    "customerUser" => "Customer",
                    "shopUser" => "Shop"
                 ])
                ->setLabel("Role");
        
        $first_name = new Zend_Form_Element_Text("fname");
        $first_name->setAttribs([
            "class" => "form-control",
            "placeholder" => "e.g. Mohamed"
        ])
                ->setLabel("First name")
                ->setRequired()
                ->addValidator("StringLength", false, array(4, 80));

        $last_name = new Zend_Form_Element_Text("lname");
        $last_name->setAttribs([
            "class" => "form-control",
            "placeholder" => "e.g. Mohamed"
        ])
                ->setLabel("Last name")
                ->setRequired()
                ->addValidator("StringLength", false, array(4, 80));

        $submit=new Zend_Form_Element_Submit('submit');
        $submit->setAttribs(array('class'=>'btn btn-success'));





        $reset=new Zend_Form_Element_Reset('reset');
        $reset->setAttribs(array('class'=>'btn btn-danger'));



        $this->addElements(array($userName,$email, $first_name, $last_name, $privilege,$password, $confirmPassword,$submit,$reset));















    }


}

