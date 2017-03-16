<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $product = new Application_Model_Product();
        $all_products = $product-> listAllProducts();
        $this->view->all_products = $all_products;
    }

   

}



