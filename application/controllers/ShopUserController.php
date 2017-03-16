<?php

class ShopUserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function listAllProductsAction()
    {
        $productsModel = new Application_Model_Product();
        $this->view->products =$productsModel->listAllProducts();
    }

    public function listProductDetailsAction()
    {
        $productModel =new Application_Model_Product();
        $productId =$this->_request->getParam("productId");
        $product= $productModel->productDetails($productId);
        $this->view->product = $product[0];
    }


}





