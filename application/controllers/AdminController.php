<?php

class AdminController extends Zend_Controller_Action
{

    private $user = null;

    private $coupon = null;

    private $category = null;

    private $db = null;

    private $privileges = null;

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
        $this->db = Zend_Db_Table::getDefaultAdapter();
        $metadata = $this->db->describeTable("users");
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
        $userList = $this->user->retrieveAllUsers();
        $this->view->userList = $userList;
    }

    public function manageCategoriesAction()
    {
        $categories = $this->category->retrieveAll();
        $this->view->categories = $categories;
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

    public function removeAction()
    {
        $id = (int) $this->getParam("id");
        $this->user->remove($id);
        $this->redirect("/admin/manage-users");
    }


}













