<?php

class Application_Model_ShoppingCart extends Zend_Db_Table_Abstract
{
    protected $_name = "shoppingCart";
    
    public function selectUsersOrders() {
        $sql = $this->select()
                ->from(array('sc' => "shoppingCart"), array('userId', 'count(*) as orders', 'sum(total) as paidCash'))
                ->joinInner(array("u" => "users"), "sc.userId = u.Id", array("userName"))
                ->group("sc.userId")
                ->where("purchasedFlag = 1")
                ->setIntegrityCheck(false);
        
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
    }
    
    public function selectSpecificOrder($userId) {
        /*$sql = $this->select()
                ->from(array('sc' => "shoppingCart"))
                ->joinInner(array("cp" => "cart_products"), "cartId = sc.id")
                ->joinLeft(array("s" => "sale"), "sc.productId = s.productId", array("percentage as discount"))
                ->joinInner(array("p" => "product"), "cp.id = sc.productId", array("name as product_name", "price", "rate", "quantity as product_quantity"))
                ->joinInner(array("c" => "category"), "p.categoryId = c.id", array("name as category_name"))
                ->where("sc.userId = ".$userId)
                ->setIntegrityCheck(false);
        $query = $sql->query();
        $result = $query->fetchAll();
         * 
         */
        
        $sql = $this->select()
                ->from(array("sc" => "shoppingCart"), array("userId"))
                ->joinInner(array("cp" => "cart_products"), "cp.cartId = sc.id", array("productId", "quantity"))
                ->joinInner(array("p" => "product"), "p.id = cp.productId", array("name as product_name", "price", "rate", "quantity as product_quantity"))
                ->joinLeft(array("s" => "sale"), "s.productId = p.id", array("percentage as discount"))
                ->joinInner(array("c" => "category"), "p.categoryId = c.id", array("name as category_name"))
                ->where("sc.userId = 4 and sc.purchasedFlag = 1")
                ->setIntegrityCheck(false);
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
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
    public function add($user_id, $product_id){
       $row=$this->createRow();
       $row->userId = $user_id;
       $row->productId = $product_id;
       $row->quantity = 1;
       $row->save();
        
    }
    public function remove($user_id, $product_id){
        $this->delete("userId=$user_id","productId = $product_id");
    }
    public function updateQuantity($user_id, $product_id) {
        
        $where = array();
        $where[] = "userId = $user_id ";
        $where[] = "productId = $product_id";
       $data = array(
             'quantity'      =>  new Zend_DB_Expr('quantity + 1')
        );

        $this->update( $data, $where);

    }
    
    public function deleteUserCart($uid) {
        $this->delete("userId = ".$uid);
    }
}

