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
       $sql = $this->select()
                ->from(array('sc' => "shoppingCart") )
                ->where("sc.userId= $user_id")
                ->setIntegrityCheck(false);
       $query = $sql->query();
       
       $cart_id=  $query->fetchAll()[0];
       $cart_id = $cart_id['id'];
       if (! $cart_id){
            $row=$this->createRow();
            $row->userId = $user_id;
            $row->purchasedFlag = 0;
            $row->save();
            $cart_id = $row->id;
       }
       $cartProductsModel->add($cart_id, $product_id);
        
    }
    
    public function removeCart($user_id){
        $this->delete("userId=$user_id");
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
    
    public function getCartDetails($user_id) {
        $sql = $this->select()
                ->from(array('sc' => "shoppingCart"))
                ->joinInner(array("c" => "cart_products"), "c.cartId = sc.id", array("productId", "quantity"))
                ->joinLeft(array("s" => "sale"), "c.productId = s.productId", array("percentage as discount"))
                ->joinInner(array("p" => "product"), "p.id = c.productId", array("id as product_id" , "name as product_name", "price as product_price", "rate", "quantity as product_quantity", "photo as product_photo" ))
                ->where("sc.userId = $user_id and purchasedFlag = 0")
                ->setIntegrityCheck(false);          
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
        
    }
    public function purchased($user_id, $cart_id, $total_amount, $subtotal) {
       $cart_details = $this->getCartDetails($user_id);
        foreach ($cart_details as $product){
            if ($product['discount'] ) {
                $product['price'] = ((100 - $product['discount']) * $product['price'])/100;
            }
            $data = array('numOfSale'   => new Zend_DB_Expr('numOfSale + 1'), 
                          'moneyGained' =>  new Zend_DB_Expr("moneyGained +" . ($product['product_price'] * $product['quantity'])) ,
                          'quantity'     => new Zend_DB_Expr("quantity - " .  $product['quantity'] ) 
                );

            $where = array(
                'id = ?' => $product['product_id']
            );
            $productModel = new Application_Model_Product();
            $productModel->update( $data, $where);
        }
       $where = array();
       
       $where[] = "id = $cart_id ";
       $data = array(
             'purchasedFlag'      =>  1 ,
             'total'         => $total_amount
        );
       $coupon = new Application_Model_Coupon();
        $this->update( $data, $where);
        if ($subtotal != $total_amount) {
            $coupon->delete( array(
                'userId = ?' => $user_id
            ));
        }
    }
           
}

