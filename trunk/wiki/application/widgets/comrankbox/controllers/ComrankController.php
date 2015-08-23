<?php

class Comrankbox_comrankController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->layout->disableLayout();
	}
	public function indexAction()
	{
		$cache = Zend_Registry::get('cache');
		$id = md5("comrankControllerIndex");
		if(($result = $cache->load($id)) === false) {
			$comment = new Application_Model_DbTable_Comment();
	  		$db = $comment->getAdapter();
	  		$select = $db->select();
	  		$select->from('article',array('title','id'));
	   		$select->joinLeft('comment','comment.article_id=article.id','count(comment_id) as total');
	   		//$select->join('article','comment.article_id=article.id','title');
	   		$select->where('article.account_id = ?', BLOGGER_ID);
	   		$select->group('article.id');
	   		$select->order('total desc');
	   		$select->limit(10);
	   		$result = $db->fetchAll($select);
		
			$cache->save($result, $id, array('calendarbox'));
		}
		  		
   		$this->view->data = $result;
   		$user = new Zend_Session_Namespace('user');
   		if(isset($user->nickname)&&$user->nickname==BLOGGER_NAME){
   			$this->view->show = true;
   		}else{
   			$this->view->show = false;
   		}    		
	}
}