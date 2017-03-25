<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        $this->google =new Zend_Session_Namespace('google');
        $this->facebook =new Zend_Session_Namespace('facebook');
         $auth=Zend_Auth::getInstance();
         $request=$this->getRequest();
         $actionName=$request->getActionName();




//        if($auth->hasIdentity()&&$actionName == 'login')
//        {
//
//            $this->redirect('user/home');
//
//        }
//
//         if(!$auth->hasIdentity() && $actionName != 'login' && $actionName != "add")
//        {
//
//            $this->redirect('user/login');
//
//        }
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
                $error = $user_model->Register($request->getParams());
                $this->view->error = $error;
                
                
                
                $db=zend_Db_Table::getDefaultAdapter();

                $adapter=new Zend_Auth_Adapter_DbTable($db,'users','email','password');

                $adapter->setIdentity($email);

                $adapter->setCredential($password);
                
                
                $result=$adapter->authenticate();

                
                if(!$error && $result->isValid()) {
                    $sessionDataObj=$adapter->getResultRowObject(['id','email','password','userName', 'fname', 'lname', 'privilege', 'status']);
                    $auth=Zend_Auth::getInstance();
                    $storage=$auth->getStorage();
                    $storage->write($sessionDataObj);
                    
                    $userSession = new Zend_Session_Namespace("user");
                    //$userSession->user->privilege = $sessionDataObj->privilege;
                    $userSession->user = $sessionDataObj;
                        
                
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
                        else if($sessionDataObj->privilege == "shopUser") {
                            $this->redirect("/shop-user/");
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

    }

    public function logoutAction()
    {
        $auth=Zend_Auth::getInstance();
        $auth->clearIdentity();
        //Zend_Session::destroy(true);
        $userSession = new Zend_Session_Namespace("user");
        $userSession->unsetAll();
        // Zend_Session::namespaceUnset('facebook');
        return $this->redirect('/');


    }

    public function fbloginAction()
    {
        $fb=new Facebook\Facebook(['app_id'=>'247319282399938',
        'app_secret'=>'868327d848ee32ad8f869f52dfead155',
        'default_graph_version'=>'v2.2']);
        $helper=$fb->getRedirectLoginHelper();
        $loginUrl =$helper->getLoginUrl($this->view->serverUrl().'/user/fbcallback',array('scope'=>'email'));
        header('Location: ' . $loginUrl);
    }

    public function fbcallbackAction()
    {
        $fb=new Facebook\Facebook(['app_id'=>'247319282399938',
        'app_secret'=>'868327d848ee32ad8f869f52dfead155',
        'default_graph_version'=>'v2.2']);
        $helper=$fb->getRedirectLoginHelper();
        try{
          $accessToken =$helper->getAccessToken();
        }catch(Facebook\Exceptions\FacebookResponseException $e) {
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        }catch(Facebook\Exceptions\FacebookSDKException $e) {
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }
        if(! isset($accessToken)){
          if($helper->getError()){
              header('HTTP/1.0 401 Unauthorized');
              echo "Error: " . $helper->getError() . "\n";
              echo "Error Code: " . $helper->getErrorCode() . "\n";
              echo "Error Reason: " . $helper->getErrorReason() . "\n";
              echo "Error Description: " . $helper->getErrorDescription() . "\n";
          }else {
              header('HTTP/1.0 400 Bad Request');
              echo 'Bad request';
          }
          exit;

        }
       
        $oAuth2Client=$fb->getOAuth2Client();
        if(!$accessToken->isLongLived()){
          try {
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
            exit;
            }

            echo '<h3>Long-lived</h3>';

        }
        $fb->setDefaultAccessToken($accessToken);
        try{
          $response = $fb->get('/me?fields=id,name,email');
          $userNode=$response->getGraphUser();

        }catch (Facebook\Exceptions\FacebookResponseException $e) {
          echo 'Graph returned an error: ' . $e->getMessage();
          Exit;
        }catch (Facebook\Exceptions\FacebookSDKException $e) {
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          Exit;
        }

        $data['userName']=$userNode['name'];
        $data['email']=$userNode['email'];
        //$this->view->fname = $this->facebook->fname;
        
        if(! $data['email'])
        {
            $this->redirect('/user/add');
        }
        $user = new Application_Model_Users();
        if(! $user->searchForUser($data['email'])){
            $data['password']='NULL';
            $data['privilege']='customerUser';
            $user->Register($data);

        }
        
        $data =$user->searchForUser($data['email']);
        $this->facebook->userName = $data[0]['userName'];
        $this->facebook->email =$data[0]['email'];
        $this->facebook->privilege =  $data[0]['privilege']; 
        $this->facebook->id = $data[0]['id'];
        $this->facebook->status = $data[0]['status'];
        $this->redirect('/index');
        
    }

    public function googleLoginAction()
    {
        $clientId= '820666566293-gjuufcri6vlb5tgtkmrpfq089r1q0pbi.apps.googleusercontent.com';
        $clientSecret = 'h4O5K3eCN4KRkpv-FLV9hhh4'; 
        
        $client = new Google_Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/user/google-callback');
        $client->addScope("email");
        $client->addScope("profile");
        if (! isset($_GET['code'])) {
            $authUrl = $client->createAuthUrl();
            //$objOAuthService = new Google_Service_Oauth2($client);
            header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        }else{
            $client->authenticate($_GET['code']);
            $this->google->accessToken = $client->getAccessToken();
            $redirectUri = 'http://' . $_SERVER['HTTP_HOST'] . '/user/google-callback';
            header('Location: ' . filter_var($redirectUri, FILTER_SANITIZE_URL));
        }
    }

    public function googleCallbackAction()
    {
        $clientId= '820666566293-gjuufcri6vlb5tgtkmrpfq089r1q0pbi.apps.googleusercontent.com';
        $clientSecret = 'h4O5K3eCN4KRkpv-FLV9hhh4'; 
        
        $client = new Google_Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/user/google-callback');
        $client->addScope("email");
        $client->addScope("profile");
        $service = new Google_Service_Oauth2($client);
        
        if (! isset($_GET['code'])) {
            $authUrl = $client->createAuthUrl();
            header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        }else{
            $client->authenticate($_GET['code']);
            $this->google->accessToken = $client->getAccessToken();
            
            $redirectUri = 'http://' . $_SERVER['HTTP_HOST'] . '/user/google-callback';
            //header('Location: ' . filter_var($redirectUri, FILTER_SANITIZE_URL));
        }
          
        if(isset($this->google->accessToken) && $this->google->accessToken){
            $client->setAccessToken($this->google->accessToken);
        }

        if($client->getAccessToken())
        {
            $userData = $service->userinfo->get();
//            var_dump($userData);
//            exit();
            if(!empty($userData)){
                $data['email'] =$userData->email;
                $data['fname'] =$userData->givenName;
                $data['lname'] =$userData->familyName;
                $data['userName']=$userData->givenName." ".$userData->familyName;

                if(! $data['email'])
                {
                    $this->redirect('/user/add');
                }
                $user = new Application_Model_Users();
                if(! $user->searchForUser($data['email'])){
                    $data['password']='NULL';
                    $data['privilege']='customerUser';
                    $user->Register($data);
                    //echo "data saved";
                }
                $data =$user->searchForUser($data['email']);
                $this->google->userName = $data[0]['userName'];
                $this->google->email =$data[0]['email'];
                $this->google->privilege =  $data[0]['privilege']; 
                $this->google->id = $data[0]['id'];
                $this->google->status = $data[0]['status'];
                $this->google->fname = $data[0]['fname'];
                $this->google->lname = $data[0]['lname'];
                
                $this->redirect('/index');
                
                
            }
            
        }
    }



}




			












