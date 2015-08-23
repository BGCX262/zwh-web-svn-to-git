<?php
class Application_Model_DbTable_MemfriendLink extends Zend_Db_Table_Abstract {
	protected $_name = 'memfriend_link';
	public function getItemsByMenu($accountId)
	{
		$select = $this->select();
		$select->where("account_id = ?", $accountId);
		$select->order("position");
		$items = $this->fetchAll($select);
		if($items->count() > 0) {
			return $items;
		}else{
			return null;
		}
	}
	public function addItem($accountId, $label,$link = null)
	{
		$row = $this->createRow();
		$row->account_id = $accountId;
		$row->label = $label;
		$row->link = $link;
		// note that you wil create the _getLastPosition method in listing 7-36
		$row->position = $this->_getLastPosition($accountId) + 1;
		return $row->save();
	}
	public function updateItem($itemId, $label, $link = null) {
		$row = $this->find ( $itemId )->current ();
		if ($row) {
			$row->label = $label;
			$row->link = $link;
			return $row->save ();
		} else {
			throw new Zend_Exception ( "Error loading menu item" );
		}
	}
	private function _getLastPosition ($accountId)
	{
		$select = $this->select();
		$select->where("account_id = ?", $accountId);
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
				$select->where("account_id = ?", $row->account_id);
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
			if ($position == $this->_getLastPosition ( $row->account_id )) {
				// this is already the last item
				return FALSE;
			} else {
				//find the next item
				$select = $this->select ();
				$select->order ( 'position ASC' );
				$select->where ( "position > ?", $position );
				$select->where("account_id = ?", $row->account_id);
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
	public function deleteItem($itemId) {
		$row = $this->find ( $itemId )->current ();
		if ($row) {
			return $row->delete ();
		} else {
			throw new Zend_Exception ( "Error loading menu item" );
		}
	}
	
}