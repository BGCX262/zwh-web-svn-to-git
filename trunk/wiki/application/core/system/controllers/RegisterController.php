<?php 
class RegisterController extends Zend_Controller_Action {
	public function init() {
	Zend_Layout::startMvc(APPLICATION_PATH.'/layouts/scripts');
		$response = $this->getResponse();
		$response->insert('logo', '/global/images/logo.jpg');
		$this->_helper->layout->setLayout('layout')
			->setLayoutPath(APPLICATION_PATH.'/layouts/scripts/system');
	}
	
	public function indexAction() {
		$this->view->headTitle("创建项目");
		
		if ($this->getRequest ()->isPost ()) {
			$filter = new Zend_Filter_StripTags ();
			$name = $filter->filter (trim($this->_request->getParam('name')));
			$pwd = $filter->filter (trim($this->_request->getParam('pwd')));
			$confirmpwd = $filter->filter (trim($this->_request->getParam('confirmpwd')));
			$email =$filter->filter ( trim($this->_request->getParam('email')));
			$issue_time = date('Y-m-d H:i:s',time());
				
			if($this->getRequest ()->isXmlHttpRequest ()|| $this->_request->getParam('ajax')==1){
				$project = new Application_Model_DbTable_Project();
				$lastinsret_id = $project->addProject($name, $pwd, $email, $issue_time);
				
				if($lastinsret_id){
					if($this->createFile($name,$lastinsret_id)){
						$status = "ok";
						$response = "恭喜您，注册成功！";
						$user = new Zend_Session_Namespace ( 'user' );
						$user->name = $name;
					}else{
						$status = "sorry";
						$response = "抱歉！ 系统出错，请稍后再试！";
					}					
				}else{
					$status = "sorry";
					$response = "抱歉！ 系统出错，请稍后再试！";
				}
				$res = '{"status":"' . $status . '","name":"'.$name.'"}';
				$this->_helper->layout->setLayout ( 'empty_layout' );
				$this->_helper->viewRenderer->setNoRender ();
				$this->_response->appendBody ( $res );
			}	
		}
	}
	public function checknickAction($name=null){
		
		if($this->getRequest ()->isXmlHttpRequest ()|| $this->_request->getParam('ajax')==1){			
			$name = trim($this->_request->getParam('name'));
			
			if($name!="tiger"){
				$account = new Application_Model_DbTable_Project();
				$db = $account->getAdapter();
				$select = $db->select();
				$select->from('ui_project','name');
				$select->where('name = ?', $name);
				$result = $db->fetchAll($select);
			}else{
				$result = array('tiger');
			}
			
			
			if(count($result)==0){
				$check = true;
			}else{
				$check = false;
			}
			
			$this->_helper->layout->setLayout ( 'empty_layout' );
			$this->_helper->viewRenderer->setNoRender ();
			$this->_response->appendBody ( $check );
		}
	}
	private function createFile($name,$blogger_id)
	{
		$publicname = BLOG_ROOT.'/public';
		$dirname = BLOG_ROOT.'/public/'.$name;
		$configdir = $dirname.'/config';
		$uploaddir = $dirname.'/upload';
		if (!file_exists($dirname)) {
			mkdir($dirname,0777);
			mkdir($uploaddir,0777);
			mkdir($configdir,0777);
			//copy(BLOG_ROOT.'/data/init/widgets.config.xml',$configdir.'/widgets.config.xml');
			copy(BLOG_ROOT.'/data/init/skin.xml',$configdir.'/skin.xml');
			copy($publicname.'/.htaccess',$dirname.'/.htaccess');
$str =<<<EOD
<?php
// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application'));
// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
realpath(APPLICATION_PATH . '/../library'),
get_include_path(),
)));

defined('BLOG_ROOT')
|| define('BLOG_ROOT', realpath(dirname(dirname(__FILE__))));

defined('BLOGGER_ID')
|| define('BLOGGER_ID', $blogger_id);
defined('BLOGGER_NAME')
|| define('BLOGGER_NAME', '$name');


/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
\$application = new Zend_Application(
APPLICATION_ENV,
APPLICATION_PATH . '/configs/application.ini'
);
\$application->bootstrap()
->run();
EOD;
			file_put_contents($dirname.'/index.php', $str);

			return true;
			
			} else {
				
			return false;
		}
	}
}