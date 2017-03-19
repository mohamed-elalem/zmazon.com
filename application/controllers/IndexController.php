<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->product = new Application_Model_Product();
        $this->wishList = new Application_Model_WishList();
        $this->shoppingCart = new Application_Model_ShoppingCart();
        $this->rating_form =  new Application_Form_Rating();
        $this->rate  = new Application_Model_Rate();
        $this->commentsForm = new Application_Form_Comment();
        $this->comment = new Application_Model_Comment();

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
        $this->view->rating_form = $this->rating_form;
        $this->view->rate = $this->rate;
        $auth=Zend_Auth::getInstance();
        $this->view->user = $auth->getStorage();
        $this->view->comments_form = $this->commentsForm;
        $this->view->all_comments = $this->comment->listAll();
   
    }


}





