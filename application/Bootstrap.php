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
    
    protected function _initSMTP() {
        $config = array(
            'ssl' => 'tls',
            'port' => 587,
            'auth' => 'login',
            'username' => 'faintingdetection@gmail.com',
            'password' => 'Tizen2016'
        );
        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
        Zend_Mail::setDefaultTransport($transport);
    }
    
}

