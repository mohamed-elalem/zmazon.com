<?php

class ShopUserController extends Zend_Controller_Action
{

    protected $productModel = null;

    protected $saleModel = null;

    protected $productForm = null;

    protected $saleForm = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->productModel = new Application_Model_Product();
        $this->productForm =new Application_Form_ProductForm();
        
        $this->saleModel=new Application_Model_Sale();
        $this->saleForm =new Application_Form_SaleForm();
    }

    public function indexAction()
    {
        // action body
    }

    public function listAllProductsAction()
    {
        //$productsModel = new Application_Model_Product();
        $this->view->products = $this->productModel->listAllProducts();
        //$this->view->saleForm = $this->addSaleAction();
    }

    public function listProductDetailsAction()
    {
        //$productModel =new Application_Model_Product();
        $productId =(int)$this->_request->getParam("productId");
        $product= $this->productModel->productDetails($productId);
        $this->view->product = $product;
    }

    public function deleteProductAction()
    {
        //$productModel =new Application_Model_Product();
        $productId =(int)$this->_request->getParam("productId");
        $this->productModel->deleteProduct($productId);
        $this->redirect("/shop-user/list-all-products");
    }

    public function editProductAction()
    {
        //$productModel =new Application_Model_Product();
        $productId =(int)$this->_request->getParam("productId");
        $productData = $this->productModel->productDetails($productId);
        //$productForm =new Application_Form_ProductForm();
        $this->productForm->populate($productData);
        $this->view->productForm = $this->productForm;
        
        $request = $this->getRequest();
        if($request->isPost())
        {
            if($this->productForm->isValid($request->getPost()))
            {
//                $this->productModel->editProduct($productId,$_POST);
//                $this->redirect('/shop-user/list-all-products');
                $productData['name']= $this->productForm->name->getValue();
                $productData['description']= $this->productForm->description->getValue();
                $productData['quantity']= $this->productForm->quantity->getValue();
                $productData['price']= $this->productForm->price->getValue();
                if($this->productForm->photo->isUploaded())
                {
                    //$productData['photo']=$productForm->photo->getFileName();
                    $productData['photo']= $this->productForm->photo->getValue();
                }
                else {
                    $productData['photo']='Null';
                }
                $productData['categoryId']= $this->productForm->categoryId->getValue();
                $this->productModel->editProduct($productId,$productData);
                $this->redirect('/shop-user/list-all-products');
                
            }
        }
        
    }

    public function addProductAction()
    {
        //$productForm =new Application_Form_ProductForm();
        $request = $this->getRequest();
        if($request->isPost())
        {
            if($this->productForm->isValid($request->getPost()))
            {
                //$productModel =new Application_Model_Product();
                $productData['name']= $this->productForm->name->getValue();
                $productData['description']= $this->productForm->description->getValue();
                $productData['quantity']= $this->productForm->quantity->getValue();
                $productData['price']= $this->productForm->price->getValue();
                if($this->productForm->photo->isUploaded())
                {
                    //$productData['photo']=$productForm->photo->getFileName();
                    $productData['photo']= $this->productForm->photo->getValue();
                }
                else {
                    $productData['photo']='Null';
                }
                $productData['categoryId']= $this->productForm->categoryId->getValue();
                $this->productModel->addProduct($productData);
                $this->redirect('/shop-user/list-all-products');
                
            }
        }
        $this->view->productForm = $this->productForm;
    }

    public function listCurrentSaleAction()
    {
        //$saleModel=new Application_Model_Sale();
        $this->view->allSales = $this->saleModel->listAllSale();
    }

    public function addSaleAction()
    {
        //$saleForm =new Application_Form_SaleForm();
        $request = $this->getRequest();
        if($request->isPost())
        {
            if($this->saleForm->isValid($request->getPost()))
            {
                //$saleModel =new Application_Model_Sale();
                $saleData['productId']=(int) $this->saleForm->productId->getValue();
                $saleData['endDate']= $this->saleForm->endDate->getValue();
                $saleData['startDate']= $this->saleForm->startDate->getValue();
                $saleData['percentage'] =(int) $this->saleForm->percentage->getValue();
                $this->saleModel->addSale($saleData);
                $this->redirect('/shop-user/list-current-sale');
            }
        }
        return $this->view->saleForm = $this->saleForm;
    }

    public function deleteSaleAction()
    {
        $saleId =(int)$this->_request->getParam("saleId");
        $this->saleModel->deleteSale($saleId);
        $this->redirect("/shop-user/list-current-sale");
    }

    public function editSaleAction()
    {
        $saleId =(int)$this->_request->getParam("saleId");
        $saleData = $this->saleModel->saleDetails($saleId);
        $this->saleForm->populate($saleData);
        $this->view->saleForm = $this->saleForm;
        
        $request = $this->getRequest();
        if($request->isPost())
        {
            if($this->saleForm->isValid($request->getPost()))
            {
                //$saleModel =new Application_Model_Sale();
                $saleData['productId']=(int) $this->saleForm->productId->getValue();
                $saleData['endDate']= $this->saleForm->endDate->getValue();
                $saleData['startDate']= $this->saleForm->startDate->getValue();
                $saleData['percentage'] =(int) $this->saleForm->percentage->getValue();
                $this->saleModel->editSale($saleId,$saleData);
                $this->redirect('/shop-user/list-current-sale');
            }
        }
        
    }

    public function statisticsAction()
    {
        $this->view->categoryStatistics = $this->productModel->statisticsForCategory() ;
        $this->view->productStatistics =$this->productModel->statisticsForProduct();
    }


}

















