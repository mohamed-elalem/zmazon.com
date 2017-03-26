<?php
 
class Application_Model_Comment extends Zend_Db_Table_Abstract
{
    protected $_name = "comment";
    
    
    public function deleteUserComments($uid) {
        $this->delete("userId = ".$uid);
    }
    public function add($user_id , $product_id , $comment_body){
        $comment=$this->createRow();
        $comment->userId = $user_id;
        $comment->productId = $product_id;
        $comment->comment = $comment_body;
       
        $comment->save();
        //echo json_encode($this->listAll() );
    }
    public function listAll(){
        $sql = $this->select()
                ->from(array('c' => "comment"))
                ->joinInner(array("u" => "users"), "c.userId = u.id", array("userName"))
                ->setIntegrityCheck(false);
        
        //echo $sql->__toString();
        //die();
        $query = $sql->query();
        $result= $query->fetchAll();
        return $result;
    }
}

