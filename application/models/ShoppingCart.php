<?php

class Application_Model_ShoppingCart extends Zend_Db_Table_Abstract
{
    protected $_name = "shoppingCart";
    
    public function selectUsersOrders() {
        $sql = $this->select()
                ->from(array('sc' => "shoppingCart"), array('userId', 'count(*) as orders'))
                ->joinInner(array("u" => "users"), "sc.userId = u.Id", array("userName"))
                ->group("sc.userId")
                ->setIntegrityCheck(false);
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
    }
    
    public function selectSpecificOrder($userId) {
        $sql = $this->select()
                ->from(array('sc' => "shoppingCart"))
                ->joinLeft(array("s" => "sale"), "sc.productId = s.productId", array("percentage as discount"))
                ->joinInner(array("p" => "product"), "p.id = sc.productId", array("name as product_name", "price", "rate", "quantity as product_quantity"))
                ->joinInner(array("c" => "category"), "p.categoryId = c.id", array("name as category_name"))
                ->where("sc.userId = ".$userId)
                ->setIntegrityCheck(false);
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
    }
    
     public function is_exists($user_id){
        $where= "userId = $user_id ";
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
    
    public function add($user_id, $product_id, $cartProductsModel){
       $row=$this->createRow();
       $row->userId = $user_id;
       $row->purchasedFlag = 0;
       $row->save();
       $cartId = $row->id;
       $cartProductsModel->add($cartId, $product_id);
        
    }
    
    public function remove($user_id,$product_id){
        $this->delete("userId=$user_id","productId = $product_id");
    }
    
    public function incrementQuantity($user_id, $product_id, $cartProductsModel) {
        $sql = $this->select()
                ->from(array('sc' => "shoppingCart"), array('id'))
                ->where("userId = $user_id")
                ->setIntegrityCheck(false);
        //echo $sql->__toString();
        $query = $sql->query();
        $result= $query->fetchAll()[0];
        $cartId = $result['id'];
        $cartProductsModel->incrementQuantity($cartId, $product_id);
    }
    
    public function cartDetails($cart_id) {
        $sql = $this->select()
                ->from(array('sc' => "shoppingCart"))
                ->joinInner(array("p" => "cart_products"), "p.cartId = sc.id", array("productId", "quantity"))
                ////
                ->joinLeft(array("s" => "sale"), "p.productId = s.productId", array("percentage as discount"))
                ->joinInner(array("p" => "product"), "p.id = sc.productId", array("name as product_name", "price", "rate", "quantity as product_quantity"))
                ->where("sc.userId = ".$userId)
                ->setIntegrityCheck(false);
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
        
    }
    
}

