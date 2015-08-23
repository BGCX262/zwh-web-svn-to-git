<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public function _inintSession()
	{
		Zend_Session::start();
	}
	public function _initView(){
		$skinData = new Zend_Config_Xml(BLOG_ROOT.'/'.BLOGGER_NAME.'/config/skin.xml');
		$skin = $skinData->name;
		$view = new Zend_View();
		$view->skin = $skin;
		// Add it to the ViewRenderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
				'ViewRenderer'
		);
		$viewRenderer->setView($view);
		
		// Return it, so that it can be stored by the bootstrap
		return $view;
	}
	public function _initController(){
		$front = Zend_Controller_Front::getInstance();
		$front->addControllerDirectory(APPLICATION_PATH . "/core/default/controllers",'default');
		//$front->addControllerDirectory(APPLICATION_PATH . "/member/controllers",'member');
		//$front->addControllerDirectory(APPLICATION_PATH . "/default2/controllers",'default2');
	}
	public function _initModule(){
		$front = Zend_Controller_Front::getInstance();
		$front->addModuleDirectory(APPLICATION_PATH . "/core");
		$front->addModuleDirectory(APPLICATION_PATH . "/widgets");
	}
	protected function _initMenus ()
	{
		$view = $this->getResource('view');
		$view->mainMenuId = 1;
		$view->topMenuId = 2;
		$view->bottomMenuId = 3;
	}
	public function _initLogo(){
		$arr = include_once APPLICATION_PATH.'/../data/config.inc.php';
		//print_r($arr);
		foreach($arr as $key=>$value){
			defined($key)|| define($key, $value);
		}
	}
	public function _initCache(){
		$frontendOptions = array(
				'caching'  => CACHE,
				'lifetime' => LIFETIME,
				'automatic_serialization' => true,
		);
		$cach_dir = APPLICATION_PATH . '/../data/cache/'.BLOGGER_NAME;
		if(!file_exists($cach_dir)){
			mkdir($cach_dir,0777);
		}
		$backendOptions = array(
				'cache_dir' => $cach_dir,
		);
		$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
		Zend_Registry::set('cache', $cache);
		//return $cache;
	}
}

