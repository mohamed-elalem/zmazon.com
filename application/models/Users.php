<?php

class Application_Model_Users extends Zend_Db_Table_Abstract
{
    protected $_name = "users";

 	function Register($formData)
	{

	$row=$this->createRow();
	$row->userName=$formData['userName'];
	$row->email=$formData['email'];
	$row->password=$formData['password'];
	$row->save();

	}




}

