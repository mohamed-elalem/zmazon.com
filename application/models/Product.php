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
        return $this->find($id)->toArray();
    }
    public function addProduct($productData)
    {
        $product=$this->createRow();
        $product->name =$productData['name'];
        $product->description=$productData['description'];
        $product->quantity=$productData['quantity'];
        $product->rate=0;
        $product->photo=$productData['photo'];
        $product->addDate=new Zend_Db_Expr('NOW()');
        $product->categoryId=$productData['categoryId'];
        $product->save();
        
    }
    public function editProduct($id,$newData)
    {
        $product['name']=$newData['name'];
        $product['description']=$newData['description'];
        $product['quantity']=$newData['quantity'];
        $product['photo']=$newData['photo'];
        $product['categoryId']=$newData['categoryId'];
        $this->update($product, 'id=$id');
    }
   
   
        
    

}

