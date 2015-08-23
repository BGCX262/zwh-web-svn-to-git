<?php

class Newcommentbox_newcommentController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->layout->disableLayout();
	}
	public function indexAction()
	{
		$cache = Zend_Registry::get('cache');
		$id = md5("newcommentControllerIndex");
		if(($result = $cache->load($id)) === false) {
			$comment = new Application_Model_CommentMapper();
			$result = $comment->findBloggerNewComment(BLOGGER_ID);
		
			$cache->save($result, $id, array('newcommentbox'));
		}
		
		//print_r($result);
		$this->view->data = $result;
	}
}