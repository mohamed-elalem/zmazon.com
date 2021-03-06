<?php

class CustomerUserController extends Zend_Controller_Action
{
    private $wishList;
    private $shoppingCart;
    private $rating;
    private $product;
    private $comment;
    private $cartProducts;
    private $coupon;

    public function init()
    {
        
        $actionName=$this->_request->getActionName();
        if ($actionName != 'view-cart' && $actionName != 'view-wish-list') {
            
            $ajaxContext = $this->_helper->getHelper('AjaxContext');
            $ajaxContext->addActionContext('addToWishList', 'json')
                ->initContext();
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout->disableLayout();
        }
        $this->wishList = new Application_Model_WishList();
        $this-> shoppingCart = new Application_Model_ShoppingCart();
        $this->rating = new Application_Model_Rate();
        $this->product = new Application_Model_Product();
        $this->comment = new Application_Model_Comment();
        $this->cartProducts = new Application_Model_CartProducts();
        $this->coupon =  new Application_Model_Coupon();
        
    }

    public function indexAction()
    {
        // action body
    }

    public function putRateAction()
    {
        if($this->_request->isPost()) {
            $user_id  = $this->_request->getParam('user_id');
            $product_id  = $this->_request->getParam('product_id');
            $rating = $this->_request->getParam('rating');
            $this->rating->addRate($user_id, $product_id, $rating);
            $this->product->updateRating($product_id);
            // The next line is for returning json object response to ajax
            echo '{"success":"done"}';
        }
        else {
            http_response_code(403);
        }
    }

    public function addToWishListAction()
    {
        if($this->_request->isPost()) {
            $user_id  = $this->_request->getParam('user_id');
            $product_id  = $this->_request->getParam('product_id');
            $this->wishList->add($user_id, $product_id);
            // The next line is for returning json object response to ajax
            echo '{"success":"done"}';
        }
        else {
            http_response_code(403);
        }
    }

    public function removeFromWishListAction()
    {
        if($this->_request->isPost()) {
        //die(json_encode($this->getRequest()->getParams()));
            $user_id  = $this->_request->getParam('user_id');
            $product_id  = $this->_request->getParam('product_id');
            $this->wishList->remove($user_id, $product_id);
            // The next line is for returning json object response to ajax
            echo '{"success":"done"}';
        }
        else {
            http_response_code(403);
        }
    }

    public function addToCartAction()
    {
        if($this->_request->isPost()) {
            $user_id  = $this->_request->getParam('user_id');
            $product_id  = $this->_request->getParam('product_id');
            $cartProducts = $this->cartProducts;
            $this->shoppingCart->add($user_id, $product_id, $cartProducts); 
            // The next line is for returning json object response to ajax
        }
        else{
            http_response_code(403);
        }
    }

    public function updateCartAction()
    {
        if($this->_request->isPost()) {
            $productArr =$this->_request->getParam('productArr');
            $cart_id = $this->_request->getParam('cart_id');
            $this->cartProducts->updateCart($productArr, $cart_id);
            echo '{"success":"done"}';
        }
        else {
            http_response_code(403);
        }

        
    }

    public function removeFromCartAction()
    {
        if($this->_request->isPost()) {
            $cart_id  = $this->_request->getParam('cart_id');
            $product_id  = $this->_request->getParam('product_id');
            $this->cartProducts->removeFromCart($cart_id, $product_id);
            // The next line is for returning json object response to ajax
            echo '{"success":"done"}';
        }
        else {
            http_response_code(403);
        }
    }

    public function addCommentAction()
    {
        if($this->_request->isPost()) {
            $user_id  = $this->_request->getParam('user_id');
            $product_id  = $this->_request->getParam('product_id');
            $comment_body = $this->_request->getParam('comment_body');
            $this->comment->add($user_id, $product_id, $comment_body);
            // The next line is for returning json object response to ajax
             echo '{"success":"done"}';
        }
        else {
             http_response_code(403);
        }
    }

    public function incrementQuantityAction()
    {   
        if($this->_request->isPost()) {
            $user_id  = $this->_request->getParam('user_id');
            $product_id  = $this->_request->getParam('product_id');
            $this->shoppingCart->incrementQuantity($user_id, $product_id, $this->cartProducts);
            // The next line is for returning json object response to ajax
            echo '{"success":"done"}';
        }
        else {
             http_response_code(403);
        }
    }

    public function viewCartAction()
    {
        $auth=Zend_Auth::getInstance();
        $user_id = $auth->getStorage()->read()->id;
        $this->view->cart = $this->shoppingCart->getCartDetails($user_id);
        $this->view->coupon = $this->coupon->getCouponCode($user_id);
        $this->view->user_id = $user_id;
        $this->view->user = $auth->getStorage();
        
    }

    public function checkoutAction()
    {
        if($this->_request->isPost()) {
            $cart_id = $this->_request->getParam('cart_id');
            $total_amount = $this->_request->getParam('totalAmount');
            $subtotal = $this->_request->getParam('subtotal');
            $user_id =  $this->_request->getParam('user_id');
            $cartDetails = $this->shoppingCart->getCartDetails($user_id);
            $mail_body = "<strong>Checkout Details</strong><br>";
            $totalPrice = 0;
            foreach($cartDetails as $product) {
                $productPrice = $product['product_price'] * (1 - (is_null($product['discount']) ? 0 : $product['discount'])) * $product['quantity'];
                $mail_body .= "<p>Product name: ".$product['product_name']."</p>";
                $mail_body .= "<p>Quantity purchaced: ".$product['quantity']."</p>";
                $mail_body .= "<p>Price: ".$productPrice."</p>";
                $mail_body .= "<hr>";
    //            $totalPrice += $productPrice;
            }
            $mail_body .= "<p>Subtotal price: " . $subtotal . "</p>";
            $mail_body .= "<p>Total price: ".$total_amount."</p>";

            $error = $this->shoppingCart->purchased($user_id, $cart_id, $total_amount, $subtotal);
            if($error) {
                echo '{"success": "failed"}';
            }
            else {
                echo '{"success":"done"}';
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
               $mail->setBodyHtml($mail_body);
               $mail->addTo("mohamed.el.alem.2017@gmail.com", 'Bill information');
               $mail->setSubject("Bill information");
               $mail->send($tr);

               $this->shoppingCart->deleteUserCart($user_id);

            }
        }
        else {
             http_response_code(403);
        }
        
                
    }

    public function viewWishListAction()
    {
        $userSession = new Zend_Session_Namespace("user");
        
        $userId = $userSession->user->id; // Stored in session
        $this->view->userWishList = $this->wishList->retrieveUserWishList($userId);
        $this->view->userId = $userId;
        // = $customerWishList;
        
    }


}























