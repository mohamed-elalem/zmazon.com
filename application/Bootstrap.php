<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initDB() {
	$dbAdapter = Zend_Db::factory('PDO_MYSQL', array(
		'host'     => 'localhost',
		'username' => 'root',
		'password' => 'root',
		'dbname'   => 'Zamazon'
        ));
	Zend_Db_Table::setDefaultAdapter($dbAdapter);
    }
   
    protected function _initACL() {
        $helper = new My_Controller_Helper_Acl();
        $helper->setRoles();
        $helper->setResources();
        $helper->setPrivileges();
        $helper->setAcl();
    }
    
}

