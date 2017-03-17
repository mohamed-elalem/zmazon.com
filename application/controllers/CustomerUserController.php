<?php

class CustomerUserController extends Zend_Controller_Action
{

    public function init()
    {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('addToWishList', 'json')
            ->initContext();
    }

    public function indexAction()
    {
        // action body
    }

    public function putRateAction()
    {
        // action body
    }

    public function addToWishListAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();

        $wishList = new Application_Model_WishList();
        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $wishList->add($user_id, $product_id);
        // The next line is for returning json object response to ajax
        echo '{"success":"done"}';
    }
     public function removeFromWishListAction()
    {
       $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();

        $wishList = new Application_Model_WishList();
        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $wishList->remove($user_id, $product_id);
        // The next line is for returning json object response to ajax
        echo '{"success":"done"}';
    }

    public function addToCartAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();

        $shoppingCart = new Application_Model_ShoppingCart();
        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $shoppingCart->add($user_id, $product_id);
        // The next line is for returning json object response to ajax
        echo '{"success":"done"}';
    }

   

    public function updateCartAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();

        $shoppingCart = new Application_Model_ShoppingCart();
        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $shoppingCart->updateQuantity($user_id, $product_id);
        // The next line is for returning json object response to ajax
        echo '{"success":"done"}';
    }
    public function removeFromCartAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();

        $shoppingCart = new Application_Model_ShoppingCart();
        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $shoppingCart->remove($user_id, $product_id);
        // The next line is for returning json object response to ajax
        echo '{"success":"done"}';
    }
    


}















