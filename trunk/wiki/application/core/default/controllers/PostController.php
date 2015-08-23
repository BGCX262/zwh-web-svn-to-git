<?php

class PostController extends Zend_Controller_Action
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
		$this->view->headScript()->appendFile('/lib/kindeditor/kindeditor.js')
    								->appendFile('/lib/kindeditor/lang/zh_CN.js');
	}
	/*
	 * 添加文章
	*/
	public function newAction()
	{
		if($this->getRequest()->isGet()){
			$article_id = $this->_request->get('pid');
			
			$this->view->pid = $article_id;
		}
	}
	/*
	 * 编辑文章
	 */
	public function editAction()
	{
		//获取用户与文章id
		if($this->getRequest()->isGet()){
			$article_id = $this->_request->get('pid');
			$section_id = $this->_request->get('id');
			$article = new Application_Model_DbTable_Article();
			$db = $article->getAdapter();
			$select = $db->select();
			$select->from('ui_article',array('content'));
			$select->where('id = ?', $section_id);
			$data = $db->fetchRow($select);
			
			$this->view->article_id = $article_id;
			$this->view->section_id = $section_id;
			$this->view->content = $data['content'];
			
		}	
	}
	public function buildAction(){
		$project = new Application_Model_DbTable_Project();
		if($this->getRequest()->isGet()){
			$type = $this->_request->get('type');
			
			
			$db = $project->getAdapter();
			$select = $db->select();
			$select->from('ui_project',$type);
			$select->where('id = ?', BLOGGER_ID);
			$data = $db->fetchRow($select);

			$this->view->type = $type;
			$this->view->content = $data[$type];
				
		}
		if($this->getRequest()->isPost()){
			$db = $project->getAdapter();
			$type = $this->_request->getPost('type');
			$set = array(
					$type =>$this->_request->getPost('content'),
			);
			$where = $db->quoteInto('id = ?', BLOGGER_ID);
			$rows_affected = $db->update('ui_project', $set, $where);
			
			$this->_redirect('/');
		}
	}
	/*
	 * 保存文章
	 */
	public function saveAction()
	{
		if($this->getRequest()->isPost()){
			$article = new Application_Model_DbTable_Article();
			$pid = $this->_request->getPost('pid');
			$db = $article->getAdapter();
			$row = array(
				'id'=>null,
				'parent_id' => $pid,
				'position' => $article->getLastPosition($pid),
				'content' =>$this->_request->getPost('content'),
				'issue_time' => date('Y-m-d H:i:s',time())
			);
			$rows_affected = $db->insert('ui_article', $row);
			//获取插入id
			//$last_insert_id = $db->lastInsertId();
			//print_r($last_insert_id);
			$this->_helper->viewRenderer->setNoRender();
			//$this->_forward('detail','article',null,array('id'=>$last_insert_id));
			$this->_redirect('/article/detail/id/'.$pid);
		}
	}
	/*
	 * 更新文章
	 */
	public function updateAction()
	{
		if($this->getRequest()->isPost()){
			$article = new Application_Model_DbTable_Article();
			$db = $article->getAdapter();
			$set = array(
					'content' =>$this->_request->getPost('content'),
			);
			$article_id = $this->_request->getPost('article_id');
			$section_id = $this->_request->getPost('section_id');
			$where = $db->quoteInto('id = ?', $section_id);
			$rows_affected = $db->update('ui_article', $set, $where);
			
			$cache = Zend_Registry::get('cache');
			
			$cache->clean(
					Zend_Cache::CLEANING_MODE_MATCHING_TAG,
					array('article_index','article_list')
			);
			
			$this->_helper->viewRenderer->setNoRender();
			$this->_redirect('/article/detail/id/'.$article_id);
		}
	}
}
