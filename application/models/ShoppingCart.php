<?php

class Application_Model_ShoppingCart extends Zend_Db_Table_Abstract
{
    protected $_name = "shoppingCart";
    
    public function selectUsersOrders() {
        $sql = $this->select()
                ->from(array('sc' => "shoppingCart"), array('userId', 'count(*) as orders'))
                ->joinInner(array("u" => "users"), "sc.userId = u.Id", array("userName"))
                ->group("sc.userId")
                ->setIntegrityCheck(false);
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
    }
}

