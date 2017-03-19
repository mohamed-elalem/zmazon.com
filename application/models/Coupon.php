<?php

class Application_Model_Coupon extends Zend_Db_Table_Abstract
{
    protected $_name = "coupon";
    
    public function newCoupon($discount, $userId, $code) {
        $this->createRow(array("discount" => $discount, "userId" => $userId, "code" => $code))->save();
    }
    
    public function deleteCoupon($id) {
        $this->delete("userId = ".$id);
    }

}

