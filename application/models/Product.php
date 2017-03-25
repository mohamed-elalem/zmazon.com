<?php

class Application_Model_Product extends Zend_Db_Table_Abstract
{
    protected $_name = "product";
    
    public function listAllProducts($userId)
    {
        $sql = $this->select()
                ->from("product")
                ->where("userId = ".$userId);
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
    }
    public function deleteProduct($id)
    {
        $this->delete("id=$id");
    }
    public function allProductDetails($id)
    {
        $sql = $this->select()
                ->from(array('p' => "product"))
                ->where("p.id = $id")
                ->joinLeft(array("s" => "sale"), "p.id = s.productId", array("percentage", "startDate", "endDate" , "(s.endDate > CURRENT_DATE and s.startDate <= CURRENT_DATE) AS saleflag"))
                ->joinLeft(array("w" => "wishList"),  "w.productId = p.id", array("userId as wishlist_user_id"))
                ->joinInner(array("cp" => "cart_products"), "cp.productId = p.id", array("productId as cart_product_id"))
                ->joinInner(array("sc" => "shoppingCart" ), "sc.id = cp.cartId" , array("id as cart_id", "userId as shopping_cart_user_id"))
                ->joinInner(array("c" => "category"), "p.categoryId = c.id" , array("name as category_name"))
                ->setIntegrityCheck(false);        
        $query = $sql->query();
        $result= $query->fetchAll()[0];
        return $result;
    }
    public function productDetails($id)
    {
        return $this->find($id)->toArray()[0];
	
    }
    public function allProductsDetails()
    {
        $sql = $this->select()
                ->from(array('p' => "product"))
                ->joinLeft(array("s" => "sale"), "p.id = s.productId", array("percentage", "startDate", "endDate", "(s.endDate > CURRENT_DATE and s.startDate <= CURRENT_DATE) AS saleflag"))
                ->joinLeft(array("w" => "wishList"),  "w.productId = p.id", array("userId as wishlist_user_id"))
                ->joinLeft(array("cp" => "cart_products"), "cp.productId = p.id", array("productId as cart_product_id"))
                ->joinLeft(array("sc" => "shoppingCart" ), "sc.id = cp.cartId" , array("id as cart_id", "userId as shopping_cart_user_id", "purchasedFlag"))
                ->setIntegrityCheck(false);
        
//        echo $sql->__toString();
//        die();
        $query = $sql->query();
        $result= $query->fetchAll();
        return $result;
    }
    
    public function allCategoryProductsDetails($categoryId)
    {
        $sql = $this->select()
                ->from(array('p' => "product"))
                ->joinLeft(array("s" => "sale"), "p.id = s.productId", array("percentage", "startDate", "endDate", "(s.endDate > CURRENT_DATE and s.startDate <= CURRENT_DATE) AS saleflag"))
                ->joinInner(array("w" => "wishList"),  "w.productId = p.id", array("userId as wishlist_user_id"))
                ->joinInner(array("cp" => "cart_products"), "cp.productId = p.id", array("productId as cart_product_id"))
                ->joinInner(array("sc" => "shoppingCart" ), "sc.id = cp.cartId" , array("id as cart_id", "userId as shopping_cart_user_id"))
                ->where("categoryId = ".$categoryId)
                ->setIntegrityCheck(false);
        
//        echo $sql->__toString();
//        die();
        $query = $sql->query();
        $result= $query->fetchAll();
        return $result;
    }
    
    public function addProduct($productData)
    {
        $product=$this->createRow();
        $product->name =$productData['name'];
        $product->name_ar = $productData['name_ar'];
        $product->description=$productData['description'];
        $product->description_ar = $productData['description_ar'];
        $product->quantity=(int)$productData['quantity'];
        $product->price=(float)$productData['price'];
        $product->userId = (int) $productData['userId'];
        $product->rate=0;
        $product->moneyGained =0;
        $product->numOfSale=0;
        $product->photo=$productData['photo'];
        $product->addDate=new Zend_Db_Expr('NOW()');
        $product->categoryId=(int)$productData['categoryId'];
        //var_dump($product);
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
        $product['name_ar'] = $newData['name_ar'];
        $product['description_ar'] = $newData['description_ar'];
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
    
    public function statisticsForCategory($productId)
    {
        $sql = $this->select()
                ->from(array('p' => "product"), array('categoryId'))
                ->where("id=$productId");
        $result = $sql->query()->fetchAll()[0];
        $categoryId=(int)$result['categoryId'];
        
        $sql = $this->select()
                ->from(array('p' => "product"), array('name as pName', 'max(numOfSale) as max'))
                ->joinInner(array("c" => "category"), "c.id = p.categoryId", array("name as cName"))
                ->group("p.id")
                ->where("categoryId =$categoryId")
                ->setIntegrityCheck(false);
        $result = $sql->query()->fetchAll()[0];

//        var_dump($result) ;
//        die();
        return $result;
    }
    
    public function statisticsForProduct() 
    {
        $sql = $this->select()
                ->from(array('p' => "product"), array('name', 'numOfSale','price','moneyGained','rate'))
                ->setIntegrityCheck(false);

        $result = $sql->query()->fetchAll();
        return $result;
        
    }

    
    public function search($name)
    {
        $word='%'.$name.'%';
        $sql = $this->select()
                ->from(['p'=>'product'])
                ->where('name like ?', $word)
                ->setIntegrityCheck(false);
        $result = $sql->query()->fetchAll();
        return $result;
    }
   
   
    public function hasOffer($product_id){
         $sql = $this->select()
                ->from(array('sc' => "sale"), array('id'))
                ->where("productId =$product_id")
                ->setIntegrityCheck(false);
        //echo $sql->__toString();
        
        $query = $sql->query();
        $result = $query->fetchAll()[0];
        $id = $result['id'];
        if ($id){
            return true;
        }
        else {
            return false;
        }
    }
    
    public function getCurrentPrice($product_id){
        $mainPrice  = $this->getMainPrice($product_id);
        if ($this->hasOffer($product_id)){
            $sql = $this->select()
                ->from(array('sc' => "sale"), array('percentage'))
                ->where("productId =$product_id")
                ->setIntegrityCheck(false);
        
            $query = $sql->query();
            $result = $query->fetchAll()[0];
            $percentage = $result['percentage'];
            return (((100-$percentage) * $mainPrice)/100);
        }
        else {
           return $mainPrice;
        }
        
    }
    public function getMainPrice($product_id){
        $sql = $this->select()
            ->from(array('sc' => "product"), array('price'))
            ->where("productId =$product_id")
            ->setIntegrityCheck(false);

        $query = $sql->query();
        $result = $query->fetchAll()[0];
        $price = $result['price'];
        return $price;
        
    }

    
    public function retrieveCategoryProducts($categoryId) {
        $sql = $this->select()
                ->from("product")
                ->where("categoryId = ".$categoryId);
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
    }

    //-----------------------------------------------------------------------------------------------------


    public function topProducts ()
    {
        $sql = $this->select()
        ->from(array('p' => "product"))
        ->order('addDate DESC')
        ->limit(5);

        return $this->fetchAll($sql)-> toArray();
    }
    
    //------------------------------fun2 -------------------------------------------------------------

     public function topSales ()
    {
        $sql = $this->select()
        ->from(array('p' => "product"))        
        ->order('numOfSale DESC')
        ->limit(5);
        return $this->fetchAll($sql)-> toArray();
    }   
    //----------------------------fun3-----------------------------------------------------------------

    public function topOffers()
    {
        // select p.name , s.percentage , s.startDate,s.endDate 
        // from product p ,sale s where  p.id=s.productId and s.endDate>CURRENT_DATE
        // order by(s.startDate) desc 
        // limit 5;
        $sql = $this->select()
        ->from(array('p' => "product"), array('name'))
        ->joinInner(array('s' => "sale"),"p.id = s.productId",array('percentage','startDate','endDate'))
        ->where("s.endDate > CURRENT_DATE and s.startDate <= CURRENT_DATE ")
        ->order('startDate DESC')
        ->limit(5)
        ->setIntegrityCheck(false);
        return $this->fetchAll($sql)-> toArray();

    }

    //-function to get 3 related product -

    public function relatedProdects($id)
    {   
        $sql=$this->select()
        ->from(array('p' => "product"),array('categoryId'))
        ->where("p.id =$id")
        ->setIntegrityCheck(false);

        $categoryIdArr =$this->fetchAll($sql)->toArray()[0];

        $categoryId= $categoryIdArr["categoryId"];

        // var_dump($categoryId);
        // exit();

        $sql = $this->select()
        ->from(array('p' => "product"))

        ->where("p.categoryId = $categoryId and p.id != $id")

        ->setIntegrityCheck(false);


        $result= $this->fetchAll($sql)-> toArray();

    }
    



}

