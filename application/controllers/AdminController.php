<?php

class AdminController extends Zend_Controller_Action
{

    private $user = null;

    private $coupon = null;

    private $category = null;

    private $shoppingCart = null;

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
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $metadata = $this->db->describeTable("users");
        $config = array(
            'ssl' => 'tls',
            'port' => 587,
            'auth' => 'login',
            'username' => 'faintingdetection@gmail.com',
            'password' => 'Tizen2016'
        );
        $this->transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
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
        $userList = $this->user->retrieveAllUsersWithCoupons();
        $this->view->userList = $userList;
        
        $paginator = Zend_Paginator::factory($userList);
        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber(1);
        $this->view->paginator = $paginator;
        
        $newCouponForm = new Application_Form_NewCoupon();
        
        $request = $this->getRequest();
        
        if($request->isPost() && $newCouponForm->isValid($request->getParams())) {
            $domain = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
            $len = strlen($domain);
            $code = '';
            for($i = 0; $i < 45; $i++) {
                $code .= $domain[random_int(0, $len - 1)];
            }
            $uid = $request->getParam("uid");
            $discount = $request->getParam("discount");
            $reciever = $request->getParam("email");
            $this->coupon->newCoupon($discount, $uid, $code);
            
            $mail = new Zend_Mail();
            $mail_body = "You've been promoted with a coupon that gives you discount on an order you select.<br>";
            $mail_body .= "coupon: ".$code."<br>";
            $mail_body .= "Please note that this coupon is one time use only.";
            $mail->setBodyHtml($mail_body);
            $mail->setFrom('faintingdetection@gmail.com');
            $mail->addTo($reciever, "site_admin");
            $mail->setSubject("Coupon promotion");
            //var_dump($this->transport);
            //die();
            
            $mail->send($this->transport);
            
            
            $this->redirect("/admin/manage-users");
        }
        
        $this->view->newCouponForm = $newCouponForm;
    }

    public function manageCategoriesAction()
    {
        $categories = $this->category->retrieveAll();
        $this->view->categories = $categories;
        
        $updateCategoryForm = new Application_Form_UpdateCategory();
        
        $request = $this->getRequest();
        
        if($request->isPost() && $updateCategoryForm->isValid($request->getParams())) {
            $id = $request->getParam("id");
            $this->category->edit($id, array("name" => $request->getParam("category")));
            $this->redirect("/admin/manage-categories");
        }
        
        $this->view->updateCategoryForm = $updateCategoryForm;
    }

    public function sendCouponAction()
    {
        // action body
    }

    public function changeStatusAction()
    {
        $id = (int) $this->getParam("id");
        $status = (int) $this->getParam("status");
        
        $this->user->editRecord($id, array('status' => 1 - $status));
        $this->redirect("/admin/manage-users");
        
    }

    public function changePrivilegeAction()
    {
        $id = (int) $this->getParam("id");
        $privilege = $this->getParam("privilege");
        $newPrivilege = $this->privileges[($this->privileges[$privilege] + 1) % 3];
        
        $this->user->editRecord($id, array('privilege' => $newPrivilege));
        $this->redirect("/admin/manage-users");
    }

    /**
     * Beware this is remove user action typo mistake
     */
    public function removeAction()
    {
        $id = (int) $this->getParam("id");
        $this->user->remove($id);
        $this->redirect("/admin/manage-users");
    }

    public function updateCategoryAction()
    {
        
    }

    public function deleteCategoryAction()
    {
        $request = $this->getRequest();
        $id = $request->getParam("id");
        $this->category->remove($id);
        $this->redirect("/admin/manage-categories");
    }

    public function deleteCouponAction()
    {
        $id = $this->getParam("id");
        $this->coupon->deleteCoupon($id);
        $this->redirect("/admin/manage-users");
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


}























