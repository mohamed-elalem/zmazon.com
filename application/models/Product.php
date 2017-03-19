<?php

class Application_Model_Product extends Zend_Db_Table_Abstract
{
    protected $_name = "product";
    
    public function listAllProducts()
    {
        return $this->fetchAll()->toArray();
    }
    public function deleteProduct($id)
    {
        $this->delete("id=$id");
    }
    public function productDetails($id)
    {
        return $this->find($id)->toArray()[0];
    }
    public function addProduct($productData)
    {
        $product=$this->createRow();
        $product->name =$productData['name'];
        $product->description=$productData['description'];
        $product->quantity=(int)$productData['quantity'];
        $product->price=(float)$productData['price'];
        $product->rate=0;
        $product->photo=$productData['photo'];
        $product->addDate=new Zend_Db_Expr('NOW()');
        $product->categoryId=(int)$productData['categoryId'];
//        var_dump($product);
//        exit();
        $product->save();
        
    }
    public function editProduct($id,$newData)
    {
        $product['name']=$newData['name'];
        $product['description']=$newData['description'];
        $product['price']=$newData['price'];
        $product['quantity']=$newData['quantity'];
        $product['photo']=$newData['photo'];
        $product['categoryId']=$newData['categoryId'];
        $this->update($product, "id=$id");
    }
    public function updateRating($product_id){
        $sql = $this->select()
                ->from(array('sc' => "rate"), array('avg(rate) as average'))
                ->group("sc.productId")
                ->having("productId =$product_id")
                ->setIntegrityCheck(false);
        //echo $sql->__toString();
        
        $query = $sql->query();
        $result = $query->fetchAll()[0];
        $product['rate'] = $result['average'];
        $this->update($product, "id=$product_id");        
    }
    
   
        
    

}

