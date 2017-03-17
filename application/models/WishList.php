<?php

class Application_Model_WishList extends Zend_Db_Table_Abstract
{
    protected $_name  = "wishList";
    
    public function add($user_id, $product_id){
       $row=$this->createRow();
       $row->userId = $user_id;
       $row->productId = $product_id;
       $row->save();
        
    }
    public function is_exists($user_id , $product_id){
        $where = array();
        $where[] = "userId = $user_id ";
        $where[] = "productId = $product_id";
        if ( !empty ($this->fetchAll($where)->id)){
            return true; 
        }
        else {
            return false;
        }
    }
    public function remove($user_id, $product_id){
        $this->delete("userId=$user_id","productId = $product_id");
    }


}

