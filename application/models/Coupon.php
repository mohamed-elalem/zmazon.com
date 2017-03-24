<?php
class Application_Model_Coupon extends Zend_Db_Table_Abstract
{ 
    protected $_name = "coupon";
    
    public function newCoupon($discount, $userId, $code) {
        $this->createRow(array("discount" => $discount, "userId" => $userId, "code" => $code))->save();
    }
    
    public function deleteCoupon($id) {
        $this->delete("id = ".$id);
    }
    public function getCouponCode($user_id){
        $sql = $this->select()
                ->from(array('coup' => "coupon"),  array('code', 'discount'))
                ->where("coup.userId = $user_id")
                ->setIntegrityCheck(false);
        $query = $sql->query();
        $result = $query->fetchAll()[0];
        return $result;

    }

}

