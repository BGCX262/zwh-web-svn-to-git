<?php

class Application_Model_DbTable_Category extends Zend_Db_Table_Abstract
{
    protected $_name = 'ui_category';

    public function createCate($name,$pro_id)
    {
    	$row = $this->createRow();
    	$row->name = $name;
    	$row->project_id = $pro_id;
    	$row->position = $this->_getLastPosition() + 1;
    	return $row->save();
    }
    public function updateCate($id, $name)
    {
    	$currentCate = $this->find($id)->current();
    	if ($currentCate) {
    		$currentCate->name = $name;
    		return $currentCate->save();
    	} else {
    		return false;
    	}
    }
    public function deleteCate($cateId)
    {
    	$row = $this->find($cateId)->current();
    	if($row) {
    		$this->deleteCates($cateId);
    		return $row->delete();
    	}else{
    		throw new Zend_Exception("Error loading cate");
    	}
    }
    public function deleteCates($cate_id){
    	$select = $this->select();
    	$db = $select->getAdapter();
    	$where = $db->quoteInto('cate_id = ?',$cate_id);
    	$db->delete('ui_article_category',$where);
    }
    private function _getLastPosition ()
    {
    	$select = $this->select();
    	$select->order('position DESC');
    	$row = $this->fetchRow($select);
    	if ($row) {
    		return $row->position;
    	} else {
    		return 0;
    	}
    }
    public function moveUp($itemId)
    {
    	$row = $this->find($itemId)->current();
    	if($row) {
    		$position = $row->position;
    		if($position < 1) {
    			// this is already the first item
    			return FALSE;
    		}else{
    			//find the previous item
    			$select = $this->select();
    			$select->order('position DESC');
    			$select->where("position < ?", $position);
    			$previousItem = $this->fetchRow($select);
    			if($previousItem) {
    				//switch positions with the previous item
    				$previousPosition = $previousItem->position;
    				$previousItem->position = $position;
    				$previousItem->save();
    				$row->position = $previousPosition;
    				$row->save();
    			}
    		}
    	} else {
    		throw new Zend_Exception("Error loading menu item");
    	}
    }
    public function moveDown($itemId) {
    	$row = $this->find ( $itemId )->current ();
    	if ($row) {
    		$position = $row->position;
    		if ($position == $this->_getLastPosition ()) {
    			// this is already the last item
    			return FALSE;
    		} else {
    			//find the next item
    			$select = $this->select ();
    			$select->order ( 'position ASC' );
    			$select->where ( "position > ?", $position );
    			$nextItem = $this->fetchRow ( $select );
    			if ($nextItem) {
    				//switch positions with the next item
    				$nextPosition = $nextItem->position;
    				$nextItem->position = $position;
    				$nextItem->save ();
    				$row->position = $nextPosition;
    				$row->save ();
    			}
    		}
    	} else {
    		throw new Zend_Exception ( "Error loading menu item" );
    	}
    }
}
