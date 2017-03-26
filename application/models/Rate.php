<?php

class Application_Model_Rate extends Zend_Db_Table_Abstract
{
    protected $_name = "rate";
    /*
     * Author : Magdy
     */
    public function addRate($userId , $productId, $rate){
        $row = $this->createRow();
        $row->userId = $userId;
        $row->rate = $rate;
        $row->productId = $productId;
        $row->save();
        
    }
    public function hasBeenRated($product_id, $user_id){
         $sql = $this->select()
                ->from(array('sc' => "rate"), array('rate'))
                ->where("productId = $product_id and userId = $user_id")
                ->setIntegrityCheck(false);
        //echo $sql->__toString();
        $query = $sql->query();
        $result = $query->fetchAll()[0];
        if ($result['rate']){
            return true;
        }
        else {
            return false;
        }
            
    }
    
    public function deleteUserRates($uid) {
        $this->delete("userId = ".$uid);
    }

}

