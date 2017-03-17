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
    public function delete($user_id, $product_id){
        
    }

}

