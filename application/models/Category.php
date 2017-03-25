<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name = "category";
    
    public function retrieveAll() {
        return $this->fetchAll();
    }
    
    public function edit($id, $data) {
        $this->update($data, 'id = '.$id);
    }
    
    public function remove($id) {
        $this->delete('id = '.$id);
    }
    
    public function add($data) {
        $this->createRow($data)->save();
    }

}

