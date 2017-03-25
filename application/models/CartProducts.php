<?php

class Application_Model_CartProducts extends Zend_Db_Table_Abstract
{
    protected $_name = "cart_products";
    
    public function add($cartId , $product_id){
       $row=$this->createRow();
       $row->cartId = $cartId;
       $row->productId = $product_id;
       $row->quantity = 1;
       $row->save();
       //echo '{"success":"done"}';

    }
    
    public function incrementQuantity($cart_id, $product_id) {
        
       $where = array();
       $where[] = "cartId = $cart_id ";
       $where[] = "productId = $product_id";
       $data = array(
             'quantity'      =>  new Zend_DB_Expr('quantity + 1')
        );
        $this->update( $data, $where);
       // echo '{"success":"done"}';


    }
    public function listRelatedProducts($cart_id, $productModel) {
        $sql = $this->select()
            ->from(array('sc' => "cart_products"), array('id', 'quantity'))
            ->where("cartId =$cart_id")
            ->setIntegrityCheck(false);

        $query = $sql->query();
        $result = $query->fetchAll();
    }
    public function removeFromCart($cart_id , $product_id) {
        $this->delete("cartId=$cart_id and productId = $product_id");
    }
    public function updateCart($productArr, $cart_id){        
        
       for ($i=0; $i < count($productArr) ; $i++){
           
            $where = array();
            $where[] = "cartId = $cart_id ";
            $where[] = "productId = ". (int) $productArr[$i]['product_id'];
            $data = array(
                  'quantity'      =>    (int) $productArr[$i]['product_quantity']
             );
             $this->update( $data, $where);
        }
    }


}

