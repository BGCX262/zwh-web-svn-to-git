<?php
class MenuitemController extends Zend_Controller_Action {
	public function init() {
		/* Initialize action controller here */
		Zend_Layout::startMvc(APPLICATION_PATH.'/layouts/scripts/tiger');
		$this->_helper->layout->setLayout('layout');
		$user = new Zend_Session_Namespace ( 'user' );
		
		if($user->nickname!="admin"){
			$this->_redirect('/');
		}
	}
	public function indexAction() {
		$menu = $this->_request->getParam ( 'menu' );
		$mdlMenu = new Application_Model_DbTable_Menu ();
		$mdlMenuItem = new Application_Model_DbTable_MenuItem ();
		$this->view->menu = $mdlMenu->find ( $menu )->current ();
		$this->view->items = $mdlMenuItem->getItemsByMenu ( $menu );
	}
	public function addAction() {
		$menu = $this->_request->getParam ( 'menu' );
		$mdlMenu = new Application_Model_DbTable_Menu ();
		$this->view->menu = $mdlMenu->find ( $menu )->current ();
		//print_r($mdlMenu->find($menu);
		$frmMenuItem = new Application_Form_MenuItem ();
		if ($this->_request->isPost ()) {
			if ($frmMenuItem->isValid ( $_POST )) {
				$data = $frmMenuItem->getValues ();
				
				$mdlMenuItem = new Application_Model_DbTable_MenuItem ();
				$mdlMenuItem->addItem ( $data ['menu_id'], $data ['label'], $data ['link'],$data['access_rule'] );
				
				
				$this->_request->setParam ( 'menu', $data ['menu_id'] );
				$this->_forward ( 'index' );
			}
		}
		$frmMenuItem->populate ( array ('menu_id' => $menu ) );
		$this->view->form = $frmMenuItem;
	}
	public function moveAction() {
		$id = $this->_request->getParam ( 'id' );
		$direction = $this->_request->getParam ( 'direction' );
		$mdlMenuItem = new Application_Model_DbTable_MenuItem ();
		$menuItem = $mdlMenuItem->find ( $id )->current ();
		if ($direction == 'up') {
			$mdlMenuItem->moveUp ( $id );
		} elseif ($direction == 'down') {
			$mdlMenuItem->moveDown ( $id );
		}
		$this->_request->setParam ( 'menu', $menuItem->menu_id );
		$this->_forward ( 'index' );
	}
	public function updateAction() {
		$id = $this->_request->getParam ( 'id' );
		// fetch the current item 
		$mdlMenuItem = new Application_Model_DbTable_MenuItem ();
		$currentMenuItem = $mdlMenuItem->find ( $id )->current ();
		// fetch its menu 
		$mdlMenu = new Application_Model_DbTable_Menu ();
		$this->view->menu = $mdlMenu->find ( $currentMenuItem->menu_id )->current ();
		// create and populate the form instance 
		$frmMenuItem = new Application_Form_MenuItem ();
		$frmMenuItem->setAction ( '/menuitem/update' );
		// process the postback 
		if ($this->_request->isPost ()) {
			if ($frmMenuItem->isValid ( $_POST )) {
				$data = $frmMenuItem->getValues ();
				$mdlMenuItem->updateItem ( $data ['id'], $data ['label'], $data ['link'] );
				$this->_request->setParam ( 'menu', $data ['menu_id'] );
				return $this->_forward ( 'index' );
			}
		} else {
			$frmMenuItem->populate ( $currentMenuItem->toArray () );
		}
		$this->view->form = $frmMenuItem;
	}
	public function deleteAction() {
		$id = $this->_request->getParam ( 'id' );
		$mdlMenuItem = new Application_Model_DbTable_MenuItem ();
		$currentMenuItem = $mdlMenuItem->find ( $id )->current ();
		$mdlMenuItem->deleteItem ( $id );
		$this->_request->setParam ( 'menu', $currentMenuItem->menu_id );
		$this->_forward ( 'index' );
	}
}
