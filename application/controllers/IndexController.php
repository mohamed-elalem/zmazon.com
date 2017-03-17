<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->product = new Application_Model_Product();
        $this->wishList = new Application_Model_WishList();
        $this->shoppingCart = new Application_Model_ShoppingCart();

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
        // action body
    }


}





