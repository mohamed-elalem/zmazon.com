<?php
 
class Application_Model_Comment extends Zend_Db_Table_Abstract
{
    protected $_name = "comment";
    
    
    public function deleteUserComments($uid) {
        $this->delete("userId = ".$uid);
    }
}

