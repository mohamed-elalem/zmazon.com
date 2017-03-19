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
        $product->numOfSale=0;
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
    public function statisticsForCategory()
    {
        $sql = $this->select()
                ->from(array('p' => "product"), array('name as pName', 'numOfSale as max'))
                ->joinInner(array("c" => "category"), "c.id = p.categoryId", array("name as cName"))
                ->where('numOfSale IN(?)', $this->select()
                        ->from(array('p' => "product"), array('max(numOfSale)'))
                        ->group('categoryId'))
                ->setIntegrityCheck(false);
        
        $result = $sql->query()->fetchAll();
        return $result;
    }
    
    public function statisticsForProduct() 
    {
        $sql = $this->select()
                ->from(array('p' => "product"), array('name', 'numOfSale','price'))
                ->setIntegrityCheck(false);

        $result = $sql->query()->fetchAll();
        return $result;
        
    }
   
   
        
    

}

