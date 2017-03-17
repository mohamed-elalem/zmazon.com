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
        echo '{"error":"HIBA2"}';
    }

    public function addToCartAction()
    {
        // action body
    }

    public function removeFromWishListAction()
    {
       $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();

        $wishList = new Application_Model_WishList();
        $user_id  = $this->_request->getParam('user_id');
        $product_id  = $this->_request->getParam('product_id');
        $wishList->remove($user_id, $product_id);
        echo '{"error":"HIBA2"}';
    }


}













