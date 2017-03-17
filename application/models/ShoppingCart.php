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
    
    public function selectSpecificOrder($userId) {
        $sql = $this->select()
                ->from(array('sc' => "shoppingCart"))
                ->joinLeft(array("s" => "sale"), "sc.productId = s.productId", array("percentage as discount"))
                ->joinInner(array("p" => "product"), "p.id = sc.productId", array("name as product_name", "price", "rate", "quantity as product_quantity"))
                ->joinInner(array("c" => "category"), "p.categoryId = c.id", array("name as category_name"))
                ->where("sc.userId = ".$userId)
                ->setIntegrityCheck(false);
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
    }
}

