<?php

class UserController extends Zend_Controller_Action {
	
	public function init() {
		/* Initialize action controller here */
		Zend_Layout::startMvc(APPLICATION_PATH.'/layouts/scripts');
		$response = $this->getResponse();
		$response->insert('logo', '/global/images/logo.jpg');
		$this->_helper->layout->setLayout('layout')
		->setLayoutPath(APPLICATION_PATH.'/layouts/scripts/login');
	}	
	public function loginAction() {	
		$this->view->headTitle("uiwiki-登陆");
		//auth实现用户登录
		if($this->_getParam('from')){
			$from = str_replace('-', '/', $this->_getParam('from') );
			$from .= '#comment_post';
		}
		if (strtolower ( $_SERVER ['REQUEST_METHOD'] ) == 'post') {
			Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			$filter = new Zend_Filter_StripTags ();
			//表单的post值
			$name = $filter->filter ( $this->_request->getPost ( 'name' ) );
			$password =$filter->filter($this->_request->getPost ( 'password' ));
			//$validcode = $filter->filter($this->_request->getPost('validcode'));//验证码
			//echo $validcode; exit;
			//echo $username;
			if (! empty ( $name )) {
				$authAdapter = new Zend_Auth_Adapter_DbTable ();
				$authAdapter->setTableName ( 'ui_project' )//数据库表名
							->setIdentityColumn ( 'name' )// 数据库表的列的名称，用来表示身份。身份列必须包含唯一的值，例如用户名或者e-mail地址。
							->setCredentialColumn ( 'password' )//数据库表的列的名称，用来表示证书。在一个简单的身份和密码认证scheme下，证书的值对应为密码
							->setIdentity ( $name )//认证的值
							->setCredential ( $password );
				$auth = Zend_Auth::getInstance ();
				$result = $auth->authenticate ( $authAdapter ); // 执行认证查询，并保存结果
			
				if ($result->isValid ()) //isValid() - 返回 true 当且仅当结果表示一个成功的认证尝试
				{
					$data = $authAdapter->getResultRowObject (array('name','id'));
					//print_r($data);
					//print_r($data->nickname);
					if ($auth->hasIdentity ()) //成功登录
					{
						//auth之后写入session
						$user = new Zend_Session_Namespace ( 'user' );
						$user->name = $data->name;
						$user->id = $data->id;
						//echo '<h3><font color=red> 登录成功!</font></h3>';
						if(isset($from)){
							//从哪传递过来的url
							$this->_redirect('/'.$from);
						}else{
							$this->_redirect('/');
						}
					}
				} else {
					echo '<h3><font color=red> 登录失败,请重新登录!</font></h3>';
				}
			}
		}
	}
	
	public function logoutAction() {
		// action body
     	//$user = new Zend_Session_Namespace('user');
		//unset($user->name);//销毁session
		Zend_Session::destroy();
		//$user = new Zend_Session_Namespace('user');
		//echo $user->nickname;
		//echo '已经安全退出!';
		$this->_helper->viewRenderer->setNoRender ();
		$this->_redirect('/');
	}

}





