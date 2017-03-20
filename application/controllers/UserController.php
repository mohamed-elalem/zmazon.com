<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */




         $auth=Zend_Auth::getInstance();
         $request=$this->getRequest();
         $actionName=$request->getActionName();




        if($auth->hasIdentity()&&$actionName == 'login')
        {

            $this->redirect('user/home');

        }

         if(!$auth->hasIdentity()&&$actionName != 'login')
        {

            $this->redirect('user/login');

        }



    }

    public function indexAction()
    {
        // action body
    }



//---------------------------------------------------

public function homeAction()
	{

// just for test login 
    }
//-----------------------------------------
    // sign up operation 

    public function addAction()
	{


	    $form=new Application_Form_SignUp();
	    $this->view->signup_form=$form;
		$request=$this->getRequest();
		if($request->ispost())
		{

	    	if($form->isValid($request->getParams()))
			{

				$user_model = new Application_Model_Users();
				$user_model->Register($request->getParams());
				$this->redirect("/user/add");
			}
		}
	}// end add action 


//-----------------------------------------

// user login 
	public function loginAction()
	{
		$loginform=new Application_Form_Login();
		$this->view->login_form = $loginform;

		$request = $this->getRequest ();

		if($request-> isPost()){

			if($loginform-> isValid($request-> getPost()))
			{

				$email=$request->getParam('email');
				$password=$request->getParam('password');
				//we get object of ZendDbAdapter to know which database we connect on
				$db=zend_Db_Table::getDefaultAdapter();



				$adapter=new Zend_Auth_Adapter_DbTable($db,'users','email','password');

				$adapter->setIdentity($email);

				$adapter->setCredential($password);
				//execute qyery
				$result=$adapter->authenticate();

					if($result->isValid())
					{
    					print_r('authentiacte');

//session steps                             
					    $sessionDataObj=$adapter->getResultRowObject(['id','email','password','userName']);
					    $auth=Zend_Auth::getInstance();
					    $storage=$auth->getStorage();
					    $storage->write($sessionDataObj);
					    $this->redirect('/user/home');

					}

					else
					{

   						$this->redirect('/user/add');
					}

				} // if form is vaild & requset is post


			}//if request is post

		} // end of login action 

//-----------------------------------------------


		public function logoutAction()
          {
		    $auth=Zend_Auth::getInstance();
		    $auth->clearIdentity();
		    // Zend_Session::namespaceUnset('facebook');
		    return $this->redirect('user/login');


       }
       
       










//------------------------------
}// end of class 

