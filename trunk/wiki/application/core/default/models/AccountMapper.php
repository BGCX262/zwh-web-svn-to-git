<?php
class Application_Model_AccountMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
         if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        } 
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Account');
        }
        return $this->_dbTable;
    }


    public function find($id, Application_Model_Account $account)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $account->setId($row->id)
             	->setPassword($row->password);
    }
    public function fetchAll()
    {
    	$resultSet = $this->getDbTable()->fetchAll();
    	$entries   = array();
    	foreach ($resultSet as $row) {
    		$entry = new Application_Model_User();
    		$entry->setId($row->id)
             	  ->setPassword($row->password)
              	  ->setUserName($row->username);
    		$entries[] = $entry;
    	}
    	return $entries;
    }
    
}
