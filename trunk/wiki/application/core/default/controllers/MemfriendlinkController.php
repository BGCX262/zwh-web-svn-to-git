<?php
class MemfriendlinkController extends Zend_Controller_Action {
	public function init() {
		/* Initialize action controller here */
		$this->_helper->layout->setLayout('container_layout');
	}
	public function indexAction() {
		$mdlMemfriendLink = new Application_Model_DbTable_MemfriendLink();
		$this->view->items = $mdlMemfriendLink->getItemsByMenu ( BLOGGER_ID );
	}
	public function addAction() {
		$frmMenuItem = new Application_Form_MemfriendLink();
		if ($this->_request->isPost ()) {
			if ($frmMenuItem->isValid ( $_POST )) {
				$data = $frmMenuItem->getValues ();
				
				$mdlMemfriendLink = new Application_Model_DbTable_MemfriendLink();
				$mdlMemfriendLink->addItem ( BLOGGER_ID, $data ['label'], $data ['link']);
				$this->_forward ( 'index' );
			}
		}
		$this->view->form = $frmMenuItem;
	}
	public function moveAction() {
		$id = $this->_request->getParam ( 'id' );
		$direction = $this->_request->getParam ( 'direction' );
		$mdlMemfriendLink = new Application_Model_DbTable_MemfriendLink();
		$menuItem = $mdlMemfriendLink->find ( $id )->current ();
		if ($direction == 'up') {
			$mdlMemfriendLink->moveUp ( $id );
		} elseif ($direction == 'down') {
			$mdlMemfriendLink->moveDown ( $id );
		}
		$this->_forward ( 'index' );
	}
	public function updateAction() {
		$id = $this->_request->getParam ( 'id' );
		// fetch the current item 
		$mdlMemfriendLink = new Application_Model_DbTable_MemfriendLink();
		$currentMenuItem = $mdlMemfriendLink->find ( $id )->current ();
		// create and populate the form instance 
		$frmMenuItem = new Application_Form_MemfriendLink();
		$frmMenuItem->setAction ( '/' . BLOGGER_NAME . '/memfriendlink/update' );
		// process the postback 
		if ($this->_request->isPost ()) {
			if ($frmMenuItem->isValid ( $_POST )) {
				$data = $frmMenuItem->getValues ();
				$mdlMemfriendLink->updateItem ( $data ['id'], $data ['label'], $data ['link'] );
				return $this->_forward ( 'index' );
			}
		} else {
			$frmMenuItem->populate ( $currentMenuItem->toArray () );
		}
		$this->view->form = $frmMenuItem;
	}
	public function deleteAction() {
		$id = $this->_request->getParam ( 'id' );
		$mdlMemfriendLink = new Application_Model_DbTable_MemfriendLink();
		$currentMenuItem = $mdlMemfriendLink->find ( $id )->current ();
		$mdlMemfriendLink->deleteItem ( $id );
		$this->_forward ( 'index' );
	}
	public function renderAction() {
		//获取用户设置的友情链接
		$memfriendlink = new Application_Model_DbTable_MemfriendLink();
		$db = $memfriendlink->getAdapter();
		$select = $db->select();
		$select->from('memfriend_link',array('label','link'));
		$select->where('account_id = ?', BLOGGER_ID);
		$result = $db->fetchAll($select);
		$itemArray = array();
		if(!empty($result)){
			foreach($result as $item){
				$label = $item['label'];
				if (! empty ( $item['link'] )) {
					$uri = $item['link'];
				} else {
					$uri = '#';
				}
				$itemArray [] = array ('label' => $label, 'uri' => $uri,'target'=>'_blank');
			}
		}
		$container = new Zend_Navigation ( $itemArray );
		$this->view->container  = $container;
	}
}
