<?php

class CommentController extends Zend_Controller_Action
{
	public function init()
	{
		/* Initialize action controller here */
		$user = new Zend_Session_Namespace('user');
		if(!isset($user->nickname)){
			$this->_redirect('/user/login');
		}
	}

	/*
	 * 功能： 发表评论
	 * 权限： 需要登陆
	 */
	public function speakAction()
	{
		if($this->getRequest()->isPost()){
			$comment = new Application_Model_DbTable_comment();
			$db = $comment->getAdapter();
			$article_id = $this->_request->getPost('article_id');
			$content = trim($this->_request->getPost('comment_content'));
			$content = str_replace(array('<p>','</p>'), array('',''), $content);
			$row = array(
					'id'=>null,
					'nickname'=> $this->_request->getPost('nickname'),
					'content' =>$content,
					'account_id' => $this->_request->getPost('account_id'),
					'replywho' =>$this->_request->getPost('replywho'),
					'comment_id' =>$this->_request->getPost('comment_id'),
					'article_id' =>$article_id
			);
			//print_r($row);
			$rows_affected = $db->insert('comment', $row);
			
			$cache = Zend_Registry::get('cache');
			
			$cache->clean(
					Zend_Cache::CLEANING_MODE_MATCHING_TAG,
					array('article_comment')
			);
			
			$this->_helper->viewRenderer->setNoRender();
			//$this->_forward('detail','article',null,array('id'=>$last_insert_id));
			$this->_redirect('/article/detail/id/'.$article_id."#look_comment");
		}
	}
}

