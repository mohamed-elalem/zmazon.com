<?php

class AdminController extends Zend_Controller_Action
{

    private $user = null;

    private $coupon = null;

    private $category = null;

    private $shoppingCart = null;

    private $wishList = null;

    private $comment = null;

    private $rates = null;

    private $db = null;

    private $privileges = null;

    private $transport = null;

    public function init()
    {
        $this->privileges = array(
            0 => 'admin',
            'admin' => 0,
            1 => 'shopUser',
            'shopUser' => 1,
            2 => 'customerUser',
            'customerUser' => 2
        );
        $this->user = new Application_Model_Users();
        $this->coupon = new Application_Model_Coupon();
        $this->category = new Application_Model_Category();
        $this->shoppingCart = new Application_Model_ShoppingCart();
        $this->wishList = new Application_Model_WishList();
        $this->comments = new Application_Model_Comment();
        $this->rates = new Application_Model_Rate();
        $this->db = Zend_Db_Table::getDefaultAdapter();
        
        $metadata = $this->db->describeTable("users");
        $config = array(
            'ssl' => 'tls',
            'port' => 587,
            'auth' => 'login',
            'username' => 'faintingdetection@gmail.com',
            'password' => 'Tizen2016'
        );

        //Zend_Mail::setDefaultTransport($this->transport);
        //$cols = array_keys($metadata);
        
        // Sending required variables to admin views
        $this->view->db = $this->db;
        //$this->view->cols = $cols;
        
    }

    public function indexAction()
    {
        // action body
    }

    public function manageUsersAction()
    {
        $users = $this->user->retrieveAllUsersWithCoupons();
        
        
        $this->view->users = $users;
    }

    public function manageCategoriesAction()
    {
        $categories = $this->category->retrieveAll();
        $this->view->categories = $categories;
        
    }

    public function sendCouponAction()
    {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('addToWishList', 'json')
            ->initContext();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        $request = $this->getRequest();
        if($request->isPost()) {
            $domain = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
            $len = strlen($domain);
            $code = '';
            for($i = 0; $i < 45; $i++) {
                $code .= $domain[random_int(0, $len - 1)];
            }
            
            $userId = $request->getParam("userId");
            $discount = $request->getParam("discount");
            $email = $request->getParam("email");
            
            $this->coupon->newCoupon($discount, $userId, $code);
            
            $tr = new Zend_Mail_Transport_Smtp('smtp.gmail.com',
                     array(
                            'auth' => 'login',
                            'port' => 587,
                            'ssl' => 'tls',
                            'username' => 'faintingdetection@gmail.com',
                            'password' => 'Tizen2016'
                         )
                    );
            Zend_Mail::setDefaultTransport($tr);

            $mail = new Zend_Mail();
            $mail->setFrom('faintingdetection@gmail.com');
            $mail->setBodyHtml("You've been promoted with a coupon that gives you discount on an order you select.<br>Code: ".$code."<br>Discount: ".$discount." %<br>Please note that this coupon is one time use only.");
            $mail->addTo($email, 'Dear customer');
            $mail->setSubject('Coupon Promotion');
            $mail->send($tr);
            
            echo '["success"]';
        }
        
    }

    public function changeStatusAction()
    {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('addToWishList', 'json')
            ->initContext();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        $request = $this->getRequest();
        
         
        if($request->isPost()) {
            $id = (int) $request->getParam("id");
            $status = (int) $request->getParam("status");
            
            
            $this->user->editRecord($id, array('status' => $status));
            echo '["Success"]';
        }
        else {
            http_response_code(403);
            die("<h1>Access Forbidden 403</h1>");
        }
        
    }

    public function changePrivilegeAction()
    {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('addToWishList', 'json')
            ->initContext();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        if($request->isPost()) {
            $id = (int) $this->getParam("id");
            $privilege = $this->getParam("privilege");
            
            $newData = $this->user->editRecord($id, array('privilege' => $privilege));
            echo json_encode($newData);
        }
        else {
            http_response_code(403);
            die("<h1>Access Forbidden 403</h1>");
        }
    }

    /**
     * Beware this is remove user action typo mistake
     */
    public function removeAction()
    {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('addToWishList', 'json')
            ->initContext();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $request = $this->getRequest();
        if($request->isPost()) {
            $id = (int) $this->getParam("id");
            $this->coupon->deleteCoupon($id);
            $this->shoppingCart->deleteUserCart($id);
            $this->wishList->deleteUserWishList($id);
            $this->rates->deleteUserRates($id);
            $this->user->remove($id);
            echo '["success"]';
        }
        else {
            http_response_code(403);
            die("<h1>Access Forbidden 403</h1>");
        }
    }

    public function updateCategoryAction()
    {
       
    }

    public function deleteCategoryAction()
    {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('addToWishList', 'json')
            ->initContext();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        
        $request = $this->getRequest();
        if($request->isPost()) {
            $id = $request->getParam("id");
            $this->category->remove($id);
            echo '["success"]';
        }
        else {
            http_response_code(403);
            die("<h1>Access Forbidden 403</h1>");
        }
    }

    public function deleteCouponAction()
    {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('addToWishList', 'json')
            ->initContext();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        $request = $this->getRequest();
        if($request->isPost()) {
            $id = $this->getParam("id");
            $this->coupon->deleteCoupon($id);
            echo json_encode($this->user->retrieveUser($id)); 
            
        }
        else {
            http_response_code(403);
            die("<h1>Access Forbidden 403</h1>");
        }
    }

    public function listOrdersAction()
    {
        $orders = $this->shoppingCart->selectUsersOrders();
        $this->view->orders = $orders;
    }

    public function orderDetailsAction()
    {
        $id = $this->getParam("id");
        $order = $this->shoppingCart->selectSpecificOrder($id);
        
        $this->view->cart = $order;
    }

    public function addCategoryAction()
    {
        $categoryForm = new Application_Form_AddCategory();
        
        $request = $this->getRequest();
        //var_dump($request->getParams());
        //die();
        
        if($request->isPost()) {
            if($categoryForm->isValid($request->getParams())) {
                if($categoryForm->photo->isUploaded()) {
                    $name = $request->getParam("name");
                    $photo = $categoryForm->photo->getValue();
                    $this->category->add(array(
                        "name" => $name,
                        "photo" => $photo
                    ));
                    $this->redirect("/admin/manage-categories");
                }
            }
            
        }
        
        $this->view->categoryForm = $categoryForm;
    }

    public function editCategoryNameAction()
    {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('addToWishList', 'json')
            ->initContext();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        $request = $this->getRequest();
        
        if($request->isPost()) {
            $id = $request->getParam("id");
            $name = $request->getParam("name");
            
            $this->category->edit($id, array('name' => $name));
        }
        else {
            http_response_code(403);
            die("<h1>Access Forbidden 403</h1>");
        }
        
        echo '["success"]';
    }

    public function editCategoryImageAction()
    {
        $categoryForm = new Application_Form_EditCategoryImage();
        
        $request = $this->getRequest();
        
        if($request->isPost()) {
            if($categoryForm->isValid($request->getParams())) {
                if($categoryForm->photo->isUploaded()) {
                    $id = $this->getParam('id');
                    $photo = $categoryForm->photo->getValue();
                    $this->category->edit($id, array(
                        "photo" => $photo
                    ));
                    $this->redirect("/admin/manage-categories");
                }
            }
            
        }
        
        $this->view->categoryForm = $categoryForm;
        
    }

    public function contactDevelopersAction()
    {
        $contactForm = new Application_Form_ContactDevelopers();
        
        $request = $this->getRequest();
        
        if($request->isPost()) {
            if($contactForm->isValid($request->getParams())) {
                $first_name = "Session_First_Name";
                $last_name = "Session_Last_Name";
                $subject = $request->getParam("subject");
                $content = $request->getParam("content");
                
                $tr = new Zend_Mail_Transport_Smtp('smtp.gmail.com',
                     array(
                            'auth' => 'login',
                            'port' => 587,
                            'ssl' => 'tls',
                            'username' => 'faintingdetection@gmail.com',
                            'password' => 'Tizen2016'
                         )
                    );
                Zend_Mail::setDefaultTransport($tr);

                $mail = new Zend_Mail();
                $mail->setFrom('faintingdetection@gmail.com');
                $mail->setBodyHtml("First name: ".$first_name."<br>Last name: ".$last_name."<br><br><strong>Problem Description</strong><br><br>".$content);
                $mail->addTo("mohamed.el.alem.2017@gmail.com", 'Site issue');
                $mail->setSubject($subject);
                $mail->send($tr);
                
                $this->redirect("/admin");
            }
        }
        
        $this->view->contactForm = $contactForm;
        
    }


}































