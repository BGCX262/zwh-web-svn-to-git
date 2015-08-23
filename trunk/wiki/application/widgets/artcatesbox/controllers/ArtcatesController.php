<?php

class Artcatesbox_artcatesController extends Zend_Controller_Action
{
public function init()
	{
		$this->_helper->layout->disableLayout();
	}
	public function indexAction()
	{

		$cache = Zend_Registry::get('cache');
		$id = md5("artcateControllerIndex");
		if(($result = $cache->load($id)) === false) {
			$mapCate = new Application_Model_CategoryMapper();
			$result = $mapCate->getCateAritcle(BLOGGER_ID);
			
			$cache->save($result, $id, array('artcatebox'));
		}		
		//print_r($result);
		$this->view->data = $result;
	}
}