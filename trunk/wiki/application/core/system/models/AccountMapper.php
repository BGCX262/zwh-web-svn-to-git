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
    
    public function fetchTotals()
    {
    	$db = $this->getDbTable()->getAdapter();
    	$select = $db->select();
    	$select->from('account','count(*)');
    	$select->where('id != 0');
    	
    	return $db->fetchOne($select);
    }
    public function fetchAccountList()
    {
    	$db = $this->getDbTable()->getAdapter();
    	$select = $db->select();
    	$select->from('account',array('id','username','nickname'));
    	$select->joinLeft('article', 'account.id=article.account_id','count(article.id) as artnums');
    	$select->where('account.id != 0');
    	$select->group('account.id');
    	$result = $db->fetchAll($select);
    	
    	$select = $db->select();
    	$select->from('comment',array('account_id','count(id) as comnums'));
    	$select->group('account_id');
    	$comment = $db->fetchAll($select);
    	
    	$len = count($result);
    	for($i=0;$i<$len;$i++){
    		foreach($comment as $arr){
    			if($result[$i]['id']==$arr['account_id']){
    				$result[$i]['comnums'] = $arr['comnums'];
    			}
    		}
    		if(!isset($result[$i]['comnums'])){
    			$result[$i]['comnums']=0;
    		} 		  		
    	}
    	//print_r($comment);
    	return $result;
    }
}
