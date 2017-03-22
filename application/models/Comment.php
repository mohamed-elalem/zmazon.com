<?php
 
class Application_Model_Comment extends Zend_Db_Table_Abstract
{
    protected $_name = "comment";
    
    public function add($user_id , $product_id , $comment_body){
        $comment=$this->createRow();
        $comment->userId = $user_id;
        $comment->productId = $product_id;
        $comment->comment = $comment_body;
       
        $comment->save();
        //echo json_encode($this->listAll() );
    }
    public function listAll(){
        return $this->fetchAll()->toArray();
    }
}

