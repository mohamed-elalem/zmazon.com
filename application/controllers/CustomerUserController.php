<?php

class CustomerUserController extends Zend_Controller_Action
{
    
    public function init()
    {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('addToWishList', 'json')
            ->initContext();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $this->wishList = new Application_Model_WishList();
        $this-> shoppingCart = new Application_Model_ShoppingCart();
        $this->rating = new Application_Model_Rate();
    }

    public function indexAction()
    {
        // action body
    }

    public function putRateAction()
    {
        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $rating = $this->_request->getParam('rating');
        $this->rating->addRate($user_id, $product_id, $rating);
        // The next line is for returning json object response to ajax
        echo '{"success":"done"}';
    }

    public function addToWishListAction()
    {        
        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $this->wishList->add($user_id, $product_id);
        // The next line is for returning json object response to ajax
        echo '{"success":"done"}';
    }
     public function removeFromWishListAction()
    {
        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $this->wishList->remove($user_id, $product_id);
        // The next line is for returning json object response to ajax
        echo '{"success":"done"}';
    }

    public function addToCartAction()
    {

       
        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $this->shoppingCart->add($user_id, $product_id);
        // The next line is for returning json object response to ajax
        echo '{"success":"done"}';
    }

   

    public function updateCartAction()
    {


        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $this->shoppingCart->updateQuantity($user_id, $product_id);
        // The next line is for returning json object response to ajax
        echo '{"success":"done"}';
    }
    public function removeFromCartAction()
    {

        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $this->shoppingCart->remove($user_id, $product_id);
        // The next line is for returning json object response to ajax
        echo '{"success":"done"}';
    }
    


}















