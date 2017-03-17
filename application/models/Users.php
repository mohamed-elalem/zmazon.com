<?php

class Application_Model_Users extends Zend_Db_Table_Abstract
{
    protected $_name = "users";
    
    public function retrieveAllUsers() {
        return $this->fetchAll();
    }
    
    public function retrieveAllUsersWithCoupons() {
        $sql =  $this->select()
                ->from(array('u' => 'users'))
                ->joinLeft(array('c' => 'coupon'), "u.id = c.userId", array('c.id as coupon_id', 'c.discount as discount'))
                ->setIntegrityCheck(false)
                ->order('id');
        $data = $sql->query();
        $result = $data->fetchAll();
        return $result;
    }
    
    public function editRecord($id, $data) {
        $this->update($data, "id = ".$id);
    }
    
    public function remove($id) {
        $this->delete("id = ".$id);
    }

 	function Register($formData)
	{

	$row=$this->createRow();
	$row->userName=$formData['userName'];
	$row->email=$formData['email'];
	$row->password=$formData['password'];
	$row->save();

	}




}

