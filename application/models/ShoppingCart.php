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
    public function checkProductAvailability($user_id, $product_id){

        
       $sql = $this->select()
                ->from ( array('p' => 'product'),array( 'quantity as storage_product_quantity', 'id') )
                ->joinLeft(array('cp' => 'cart_products'), "cp.productId = p.id", array('productId', 'quantity as cart_product_quantity'))
                ->joinLeft(array("sc" => "shoppingCart"), "sc.id = cp.cartId")
                ->where(" p.id = $product_id and (sc.userId is null or sc.userId = $user_id)")
                ->setIntegrityCheck(false);

      $query = $sql->query();
    
      $result = $query->fetchAll();
      if(!empty($result))
          $result = $result[0];
      else 
          return false;
      
      if ($result['storage_product_quantity'] > 0) {
          if (is_null($result['cart_product_quantity'])){
              return true;
          }
          else if (!is_null($result['cart_product_quantity']) && $result['cart_product_quantity'] >= $result['storage_product_quantity']){
              return false;
              
          }
//          else if(is_null($result['cart_product_quantity'])) {
//              $sql = $this->select()
//                      ->from("product")
//                      ->where("id = ".$product_id." and quantity > 0")
//                      ->setIntegrityCheck(false);
//              $query = $sql->query();
//              $result = $query->fetchAll();
//              if(empty($result))
//                  return false;
//              else
//                  return true;
//          }
          else {
              return true;
             
            
          }
      }
      else {
          return false;
        
      }
    }
    public function add($user_id, $product_id, $cartProductsModel){
        $bool  = $this->checkProductAvailability( $user_id, $product_id);
       if ( $bool == false ){
            echo  json_encode(['success' => 'fail']);
            die();
       }
     
       $sql = $this->select()
                ->from(array('sc' => "shoppingCart") )
                ->where("sc.userId= $user_id and purchasedFlag = 0")
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
       echo '{"success":"done"}';

        
    }
    
    public function removeCart($user_id){
        $this->delete("userId=$user_id");
    }
    
    public function incrementQuantity($user_id, $product_id, $cartProductsModel) {
       if ( ! $this->checkProductAvailability($user_id, $product_id) ){
            echo  json_encode(['success' => 'fail']);
            die();
       }
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
                ->joinLeft(array("s" => "sale"), "c.productId = s.productId", array("percentage as discount", "(s.endDate > CURRENT_DATE and s.startDate <= CURRENT_DATE) AS saleflag"))
                ->joinInner(array("p" => "product"), "p.id = c.productId", array("id as product_id" , "name as product_name", "price as product_price", "rate", "quantity as product_quantity", "photo as product_photo" ))
                ->joinInner(array("u" => "users"), "u.id = sc.userId", "email")
                ->where("sc.userId = $user_id and purchasedFlag = 0")
                ->setIntegrityCheck(false);          
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
        
    }
    public function purchased($user_id, $cart_id, $total_amount, $subtotal) {
        
        try {
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
            $subtotal = (int) $subtotal;
            $total_amount = (int) $total_amount;
                if ($subtotal != $total_amount) { 
                
                    $coupon->delete( array(
                    'userId = ?' => $user_id
                ));
            }
            return false;
        }
        catch(Exception $ex) {
            return true; 
        }
    }
           
    
    public function deleteUserCart($uid) {
        $this->delete("userId = ".$uid);
    }
    
}

