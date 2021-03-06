<?php

class Application_Model_Sale extends Zend_Db_Table_Abstract
{
    protected $_name = "sale";
    
    public function addSale($saleData)
    {
        $sale = $this->createRow();
        $sale->productId =(int)$saleData['productId'];
        $sale->percentage =(int)$saleData['percentage'];
        $sale->endDate =$saleData['endDate'];
        //$sale->startDate =new Zend_Db_Expr('NOW()');
        $sale->startDate =$saleData['startDate'];
        $sale->save();
    }
    public function deleteSale($id)
    {
        $this->delete("id=$id"); 
    }
    public function editSale($id,$saleData)
    {
        $sale['productId']=(int)$saleData['productId'];
        $sale['percentage']=(int)$saleData['percentage'];
        $sale['startDate']=$saleData['startDate'];
        $sale['endDate']=$saleData['endDate'];
        $this->update($sale, "id=$id");
    }
    public function listAllSale()
    {
        $sql = $this->select()
                ->from(array('s' => "sale"), array('id','percentage', 'startDate','endDate'))
                ->joinInner(array('p' => "product"), "p.id = s.productId", array("name"))
                ->setIntegrityCheck(false);
        $query = $sql->query();
        $result = $query->fetchAll();
        return $result;
        
    }

    public function saleDetails($id)
    {
        return $this->find($id)->toArray()[0];
    }
}

