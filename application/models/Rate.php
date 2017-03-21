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
    
    public function deleteUserRates($uid) {
        $this->delete("userId = ".$uid);
    }

}

