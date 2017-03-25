<?php

class Application_Model_Users extends Zend_Db_Table_Abstract
{
    protected $_name = "users";
    
    public function retrieveUser($id) {
        return $this->find($id)->toArray();
    }
    
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
        $sql = $this->select()
                ->from(array("u" => "users"))
                ->joinLeft(array("c" => "coupon"), "u.id = c.userId", array("c.id as coupon_id", "c.discount as discount"))
                ->where("u.id = ".$id)
                ->setIntegrityCheck(false);
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
        
    }
    
    public function remove($id) {
        $this->delete("id = ".$id);
    }

    public function Register($formData)
    {

        $row=$this->createRow();
//        var_dump($formData);
//        exit();
        $row->userName = $formData['userName'];
        $row->email = $formData['email'];
        $row->password = md5($formData['password']);
        $row->fname = $formData['fname'];
        $row->lname = $formData['lname'];
        $row->privilege = $formData['privilege'];
        $row->status = "1";
        
        try {
            $row->save();
            return false;
        } catch (Exception $ex) {
            return true;
        }
    }

    public function checkUsernameExistence($username) {
        return $this->fetchRow("userName = ".$username);
    }
    
    public function searchForUser($email){
        $sql =$this->select()
                ->where("email='$email'")
                ->setIntegrityCheck(false);
        $query = $sql->query();

        $result = $query->fetchAll();
        return $result;
    }


}

