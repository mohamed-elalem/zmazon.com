<?php

class IndexController extends Zend_Controller_Action
{

    private $categories = null;

    public function init()
    {
        $this->product = new Application_Model_Product();
        $this->wishList = new Application_Model_WishList();
        $this->shoppingCart = new Application_Model_ShoppingCart();
        $this->rating_form =  new Application_Form_Rating();
        $this->rate  = new Application_Model_Rate();
        $this->commentsForm = new Application_Form_Comment();
        $this->comment = new Application_Model_Comment();
        $this->categories = new Application_Model_Category();

    }

    public function indexAction()
    {
        
        $all_products = $this->product->allProductsDetails();
        $this->view->all_products = $all_products;
        $auth=Zend_Auth::getInstance();
        $this->view->user = $auth->getStorage();
        $this->view->wishList = $this->wishList;
        $this->view->shoppingCart = $this->shoppingCart;
        $this->view->categories = $this->categories->retrieveAll();
        $top_products = new Application_Model_Product();
        $this->view->topProducts = $top_products->topProducts(); 
        $this->view->topSales = $this->product->topSales(); 
        $this->view->topOffers = $this->product->topOffers();


    }

    public function productDetailsAction()
    {
        $product_id = $this->_request->getParam('product_id');
        $product = $this->product->allProductDetails($product_id);
        $this->view->product = $product;
        $this->view->rating_form = $this->rating_form;
        $this->view->rate = $this->rate;
        $auth=Zend_Auth::getInstance();
        $this->view->user = $auth->getStorage();
        $this->view->comments_form = $this->commentsForm;
        $this->view->all_comments = $this->comment->listAll();

        $this->view->relatedProduct = $this->product->relatedProdects($product_id); 
    }

    public function setArabicLanguageAction()
    {
        $languageSession = new Zend_Session_Namespace("language");
        $languageSession->language = "Ar";
    }

    public function setEnglishLanguageAction()
    {
        $languageSession = new Zend_Session_Namespace("language");
        $languageSession->unsetAll();
    }

    public function toggleLanguageAction()
    {
        $languageSession = new Zend_Session_Namespace("language");
        if($languageSession->language == "Ar") {
            $languageSession->unsetAll();
        }
        else {
            $languageSession->language = "Ar";
        }
        $this->redirect($this->getRequest()->getServer('HTTP_REFERER'));
    }

    public function categoriesAction()
    {
        $this->view->categories = $this->categories->retrieveAll();
        $userSession = new Zend_Session_Namespace("user");
        $this->view->user = $userSession->user;
    }

    public function listProductsAction()
    {
        $categoryId = $this->getParam("id");
        $this->view->products = $this->product->allCategoryProductsDetails($categoryId);
        //die(var_dump($this->view->products));
        
        $auth=Zend_Auth::getInstance();
        $this->view->user = $auth->getStorage();
        
    }

    public function topproductAction()
    {
        $top_products = new Application_Model_Product();
        $this->view->topProducts = $top_products->topProducts();   
    }

    public function topsaleAction()
    {
        $top_sales = new Application_Model_Product();
        $this->view->topSales = $top_sales->topSales(); 
    }

    public function topoffersActionAction()
    {
        $top_offers = new Application_Model_Product();
        $this->view->topOffers = $top_offers->topOffers(); 
    }

    public function error404Action()
    {
        // action body
    }

    public function error403Action()
    {
        // action body
    }


}



























