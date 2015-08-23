<?php
class TestController extends Zend_Controller_Action {
	public function init() {
		/* Initialize action controller here */
		Zend_Layout::startMvc(APPLICATION_PATH.'/layouts/scripts');
		$response = $this->getResponse();
		$response->insert('logo', '/global/images/logo.jpg');
		$this->_helper->layout->setLayout('layout')
		->setLayoutPath(APPLICATION_PATH.'/layouts/scripts/login');
	}
	public function indexAction()
	{
		$ipObj = new Cblog_Ip_RealIp();
		$ip = $ipObj->getIp();
		print_r($ip);
		
	}
}