<?php

class Application_Model_DbTable_ArticleCategory extends Zend_Db_Table_Abstract
{
    protected $_name = 'ui_article_category';

    public function createCate($name,$id,$project_id)
    {
    	$row = $this->createRow();
    	$row->subcate_name = $name;
    	$row->cate_id = $id;
    	$row->project_id = $project_id;
    	$row->position = $this->_getLastPosition($id) + 1;
    	return $row->save();
    }
    public function updateCate($id, $name)
    {
    	$currentCate = $this->find($id)->current();
    	if ($currentCate) {
    		$currentCate->subcate_name = $name;
    		return $currentCate->save();
    	} else {
    		return false;
    	}
    }
    public function deleteCate($cateId)
    {
    	$row = $this->find($cateId)->current();
    	if($row) {
    		return $row->delete();
    	}else{
    		throw new Zend_Exception("Error loading cate");
    	}
    }
    private function _getLastPosition ($pid)
    {
    	$select = $this->select();
    	$select->where('cate_id = ?',$pid);
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
    			$select->where("cate_id = ?", $row->cate_id);
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
    		if ($position == $this->_getLastPosition ( $row->cate_id )) {
    			// this is already the last item
    			return FALSE;
    		} else {
    			//find the next item
    			$select = $this->select ();
    			$select->order ( 'position ASC' );
    			$select->where ( "position > ?", $position );
    			$select->where("cate_id = ?", $row->cate_id);
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
