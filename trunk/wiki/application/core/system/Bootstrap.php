<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public function _inintSession()
	{
		Zend_Session::start();
	}
	public function _initView(){
		$view = new Zend_View();
		$view->skin = 'default';
		// Add it to the ViewRenderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
				'ViewRenderer'
		);
		$viewRenderer->setView($view);
		
		// Return it, so that it can be stored by the bootstrap
		return $view;
	}
	public function _initModule(){
		$front = Zend_Controller_Front::getInstance();
		$front->addModuleDirectory(APPLICATION_PATH . "/core");
		$front->addModuleDirectory(APPLICATION_PATH . "/widgets");
	}
	public function _initController(){
		$front = Zend_Controller_Front::getInstance();
		$front->addControllerDirectory(APPLICATION_PATH . "/core/system/controllers",'default');
	}
	public function _initRoute()
	{
		//$front为前段控制器实例
		/*
		$front = Zend_Controller_Front::getInstance();
		$router = $front->getRouter();
		
		//实现如http://www.example.com/id/4类型的url
		
		$router->addRoute(		
				'blogRoute',		
				new Zend_Controller_Router_Route(		
						'/:blogger',		
						array('controller' => 'index' , 'action' => 'index')		
						)	
		);
		*/
	}
	public function _initLogo(){
		$arr = include_once APPLICATION_PATH.'/../data/config.inc.php';
		//print_r($arr);
		foreach($arr as $key=>$value){
			defined($key)|| define($key, $value);
		}
	}
}

