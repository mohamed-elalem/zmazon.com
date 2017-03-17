<?php

class CustomerUserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
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
        

        $wishList = new Application_Model_WishList();
        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $wishList->add($user_id, $product_id);
    }

    public function addToCartAction()
    {
        // action body
    }


}











