<?php

class Readrankbox_readrankController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->layout->disableLayout();
	}
	public function indexAction()
	{
		$cache = Zend_Registry::get('cache');
		$id = md5("readrankControllerIndex");
		if(($result = $cache->load($id)) === false) {
			$article = new Application_Model_DbTable_Article();
			$db = $article->getAdapter();
			$select = $db->select();
			$select->from('article',array('id','title','view_counter'));
			$select->where('account_id = ?', BLOGGER_ID);
			$select->order('view_counter desc');
			$select->limit(10);
			$result = $db->fetchAll($select);
		
			$cache->save($result, $id, array('readrankbox'));
		}
				
		//print_r($result);
		$this->view->data = $result;
	}
}