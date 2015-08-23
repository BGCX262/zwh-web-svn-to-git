<?php
class MenuController extends Zend_Controller_Action {
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
		// action body
		$mdlMenu = new Application_Model_DbTable_Menu ();
		$this->view->menus = $mdlMenu->getMenus ();
		//$this->_redirect ( '/' );
		//print_r($this->view->menus);
		//$this->_helper->viewRenderer->setNoRender ();
	}
	public function createAction() {
		$frmMenu = new Application_Form_Menu ();
		if ($this->getRequest ()->isPost ()) {
			if ($frmMenu->isValid ( $_POST )) {
				$menuName = $frmMenu->getValue ( 'name' );
				$mdlMenu = new Application_Model_DbTable_Menu ();
				$result = $mdlMenu->createMenu ( $menuName );
				if ($result) {
					// redirect to the index action 
					$this->_redirect ( '/menu/index' );
				}
			}
		}
		$frmMenu->setAction ( 'create' );
		$this->view->form = $frmMenu;
	}
	public function editAction() {
		$id = $this->_request->getParam ( 'id' );
		$mdlMenu = new Application_Model_DbTable_Menu ();
		$frmMenu = new Application_Form_Menu ();
		// if this is a postback, then process the form if valid 
		if ($this->getRequest ()->isPost ()) {
			if ($frmMenu->isValid ( $_POST )) {
				$menuName = $frmMenu->getValue ( 'name' );
				$mdlMenu = new Application_Model_DbTable_Menu ();
				$result = $mdlMenu->updateMenu ( $id, $menuName );
				if ($result) {
					// redirect to the index action 
					return $this->_forward ( 'index' );
				
		//$this->_redirect('/menu/index');
				

				}
			}
		} else {
			// fetch the current menu from the db 
			$currentMenu = $mdlMenu->find ( $id )->current ();
			// populate the form 
			$frmMenu->getElement ( 'id' )->setValue ( $currentMenu->id );
			$frmMenu->getElement ( 'name' )->setValue ( $currentMenu->name );
		}
		$frmMenu->setAction ( '/menu/edit' );
		// pass the form to the view to render 
		$this->view->form = $frmMenu;
	}
	public function deleteAction() {
		$id = $this->_request->getParam ( 'id' );
		$mdlMenu = new Application_Model_DbTable_Menu ();
		$mdlMenu->deleteMenu ( $id );
		$this->_forward ( 'index' );
	}
}