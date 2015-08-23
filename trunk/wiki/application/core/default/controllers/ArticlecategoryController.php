<?php

class ArticlecategoryController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
		/*
		 *这里进行用户身份确认 
		 */
		$user = new Zend_Session_Namespace('user');
		if($user->name!=BLOGGER_NAME){
			$this->_redirect('/user/login');
		}
		$this->_helper->layout->setLayout('container_layout');
	}
	/*
	 * 功能： 显示博主所有文章分类,添加文章分类
	 * 权限： 管理员
	 */
	public function indexAction()
	{
		//获取文章分类
		$mapCate = new Application_Model_CategoryMapper();
		$result = $mapCate->getCateAritcle(BLOGGER_ID);
		$this->view->data = $result;
	}
	public function createAction() {
		$frmCate = new Application_Form_Category ();
		if ($this->getRequest ()->isPost ()) {
			$cateName = $this->_request->getParam ('cate_name');
			if ($frmCate->isValid ( $_POST )) {
					$mdlCate = new Application_Model_DbTable_ArticleCategory();
					$result = $mdlCate->createCate ( $cateName ,$this->_request->getPost('id'),BLOGGER_ID);
				if ($result) {
					$cache = Zend_Registry::get('cache');
					$cache->clean(
							Zend_Cache::CLEANING_MODE_MATCHING_TAG,
							array('artcatebox')
					);
					// redirect to the index action
					$this->_redirect ( '/category/index' );
				}
			}
		}else{
			$pelem = $frmCate->createElement('hidden', 'id');
			$pelem->setValue($this->_request->getParam ( 'id' ));
			$frmCate->addElement($pelem);
			
			$frmCate->setAction ( '/'.BLOGGER_NAME.'/articlecategory/create' );
			$this->view->form = $frmCate;
		}
		
		
	}
	/*
	 * 功能：编辑文章分类
	 * 权限： 管理员
	 */
	public function editAction()
	{
		$id = $this->_request->getParam ( 'id' );
		$frmCate = new Application_Form_CategoryEdit();
		$mdlCate = new Application_Model_DbTable_ArticleCategory ();
		// if this is a postback, then process the form if valid 
		if ($this->getRequest ()->isPost ()) {
			if ($frmCate->isValid ( $_POST )) {
				$cateName = $this->_request->getPost( 'cate_name' );
				$result = $mdlCate->updateCate ( $id, $cateName );
				if ($result) {
					
					$cache = Zend_Registry::get('cache');
					$cache->clean(
							Zend_Cache::CLEANING_MODE_MATCHING_TAG,
							array('artcatebox')
					);
					
					// redirect to the index action 
					return $this->_forward ( 'index' );
				}
			}
		} else {
			// fetch the current menu from the db 
			$currentCate = $mdlCate->find ( $id )->current ();
			// populate the form 
			$frmCate->getElement ( 'id' )->setValue ( $currentCate->id );
			$frmCate->getElement ( 'cate_name' )->setValue ( $currentCate->subcate_name );
		}
		$frmCate->setAction ( '/' . BLOGGER_NAME . '/articlecategory/edit' );
		// pass the form to the view to render 
		$this->view->form = $frmCate;
	}
	/*
	 * 功能：保存文章分类
	 * 权限：管理员
	 */
	public function saveAction()
	{
		if($this->getRequest()->isPost()){
			$article = new Application_Model_DbTable_Article();
			$db = $article->getAdapter();
			$row = array(
				'id'=>null,
				'title'=> $this->_request->getPost('title'),
				'content' =>$this->_request->getPost('blog_content'),
				'account_id' => BLOGGER_ID,
				'atype_id' =>$this->_request->getPost('atype'),
			);
			$rows_affected = $db->insert('article', $row);
			//获取插入id
			$last_insert_id = $db->lastInsertId();
			$cache = Zend_Registry::get('cache');
			$cache->clean(
					Zend_Cache::CLEANING_MODE_MATCHING_TAG,
					array('artcatebox')
			);
			//print_r($last_insert_id);
			$this->_helper->viewRenderer->setNoRender();
			//$this->_forward('detail','article',null,array('id'=>$last_insert_id));
			$this->_redirect('/article/detail/id/'.$last_insert_id);
		}
	}
	public function moveAction() {
		$id = $this->_request->getParam ( 'id' );
		$direction = $this->_request->getParam ( 'direction' );
		$mdlCategory = new Application_Model_DbTable_ArticleCategory ();
		if ($direction == 'up') {
			$mdlCategory->moveUp ( $id );
		} elseif ($direction == 'down') {
			$mdlCategory->moveDown ( $id );
		}
		
		$cache = Zend_Registry::get('cache');
		$cache->clean(
				Zend_Cache::CLEANING_MODE_MATCHING_TAG,
				array('artcatebox')
		);
		
		$this->_forward ( 'index' );
	}
	public function deleteAction() {
		
		if($this->getRequest()->isGet()){
			$id = $this->_request->getParam ( 'id' );
			$mdlCate = new Application_Model_DbTable_ArticleCategory();
			$mdlCate->deleteCate ( $id );
		}
		
		$cache = Zend_Registry::get('cache');
		$cache->clean(
				Zend_Cache::CLEANING_MODE_MATCHING_TAG,
				array('artcatebox')
		);
		
		$this->_forward ( 'index' );
	}
}
