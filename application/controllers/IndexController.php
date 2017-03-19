<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->product = new Application_Model_Product();
        $this->wishList = new Application_Model_WishList();
        $this->shoppingCart = new Application_Model_ShoppingCart();
        $this->rating =  new Application_Form_Rating();

    }

    public function indexAction()
    {
        
        $all_products = $this->product-> listAllProducts();
        $this->view->all_products = $all_products;
        $auth=Zend_Auth::getInstance();
        $this->view->user = $auth->getStorage();
        $this->view->wishList = $this->wishList;
        $this->view->shoppingCart = $this->shoppingCart;

    }

    public function productDetailsAction()
    {
        $product_id = $this->_request->getParam('product_id');
        $product = $this->product->productDetails($product_id);
        $this->view->product = $product;
        $ratingForm = new Application_Form_Rating();
        $this->view->rating_form = $ratingForm;
        $auth=Zend_Auth::getInstance();
        $this->view->user = $auth->getStorage();
   
    }


}





