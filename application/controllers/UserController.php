<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {

         $auth=Zend_Auth::getInstance();
         $request=$this->getRequest();
         $actionName=$request->getActionName();




        if($auth->hasIdentity()&&$actionName == 'login')
        {

            $this->redirect('user/home');

        }

         if(!$auth->hasIdentity() && $actionName != 'login' && $actionName != "add")
        {

            $this->redirect('user/login');

        }
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        $form=new Application_Form_SignUp();
        $this->view->signup_form=$form;
        $request=$this->getRequest();
        if($request->isPost())
        {

            if($form->isValid($request->getParams()))
            {
                $email = $request->getParam("email");
                $password = md5($request->getParam("password"));
                $user_model = new Application_Model_Users();
                $user_model->Register($request->getParams());
                
                $db=zend_Db_Table::getDefaultAdapter();

                $adapter=new Zend_Auth_Adapter_DbTable($db,'users','email','password');

                $adapter->setIdentity($email);

                $adapter->setCredential($password);
                
                
                $result=$adapter->authenticate();

                
                if($result->isValid()) {
                    $sessionDataObj=$adapter->getResultRowObject(['id','email','password','userName', 'fname', 'lname', 'privilege', 'status']);
                    $auth=Zend_Auth::getInstance();
                    $storage=$auth->getStorage();
                    $storage->write($sessionDataObj);
                
                    if($request->getParam("privilege") == "shopUser") {
                        $this->redirect("/shop-user");
                    }
                    else {
                        $this->redirect("/");
                    }
                }
            }
        }
    }

    public function loginAction()
    {
        $loginform=new Application_Form_Login();
        $this->view->login_form = $loginform;

        $request = $this->getRequest ();

        if($request-> isPost()){

            if($loginform-> isValid($request-> getPost()))
            {

                $email=$request->getParam('email');
                $password=md5($request->getParam('password'));
                //we get object of ZendDbAdapter to know which database we connect on
                $db=zend_Db_Table::getDefaultAdapter();



                $adapter=new Zend_Auth_Adapter_DbTable($db,'users','email','password');

                $adapter->setIdentity($email);

                $adapter->setCredential($password);
                //execute qyery
                $result=$adapter->authenticate();

                if($result->isValid())
                {

//session steps                             
                    $sessionDataObj=$adapter->getResultRowObject(['id','email','password','userName', 'fname', 'lname', 'privilege', 'status']);
                    if($sessionDataObj->status == "0") {
                        $this->view->error = true;
                        $this->view->message = "Account blocked by administrator";
                    }
                    else {
                        $auth=Zend_Auth::getInstance();
                        $storage=$auth->getStorage();
                        $storage->write($sessionDataObj);
                        $userSession = new Zend_Session_Namespace("user");
                        //$userSession->user->privilege = $sessionDataObj->privilege;
                        $userSession->user = $sessionDataObj;
                        if($sessionDataObj->privilege == "admin") {
                            $this->redirect("/admin/");
                        }
                        else if($sessionDataObj->privilege == "shop") {
                            $this->redirect("/shop/");
                        }
                        else {
                            $this->redirect("/");
                        }
                    }
                }
                else {
                    $this->view->error = true;
                    $this->view->message = "Wrong email or password";
                }

                

            } // if form is vaild & requset is post


        }//if request is post

    } // end of login action 

//-----------------------------------------------

    public function logoutAction()
    {
        $auth=Zend_Auth::getInstance();
        $auth->clearIdentity();
        Zend_Session::destroy(true);
        // Zend_Session::namespaceUnset('facebook');
        return $this->redirect('/');


    }
       
       




}
			








