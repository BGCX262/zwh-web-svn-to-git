<?php

class Application_Model_DbTable_Article extends Zend_Db_Table_Abstract
{
    protected $_name = 'ui_article';
    public function getLastPosition ($id)
    {
    	$select = $this->select();
    	$select->where('parent_id = ?', $id);
    	$select->order('position DESC');
    	$row = $this->fetchRow($select);
    	if ($row) {
    		return $row->position;
    	} else {
    		return 0;
    	}
    }
}
