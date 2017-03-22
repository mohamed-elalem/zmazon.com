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
        $where= "userId = $user_id & productId = $product_id";
        $select = $this->select();
        $select->where($where);
        $rows = $this->fetchAll($select);
        if ( !empty ($rows['id'])){
            return true; 
        }
        else {
            return false;
        }
    }
    public function remove($user_id, $product_id){
        $this->delete("userId=$user_id","productId = $product_id");
    }
    
    public function retrieveUserWishList($userId) {
        $sql = $this->select()
                ->from(array("wl" => "wishList"), array("id as wish_list_id"))
                ->joinInner(array("p" => "product"), "p.id = wl.productId and wl.userId = ".$userId)
                ->setIntegrityCheck(false);
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
    }


}

