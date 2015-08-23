<?php

class IndexController extends Zend_Controller_Action {
	
	public function init() {
		/* Initialize action controller here */
		Zend_Layout::startMvc(APPLICATION_PATH.'/layouts/scripts');
		$response = $this->getResponse();
		$response->insert('logo', '/global/images/logo.jpg');
		$this->_helper->layout->setLayout('layout')
		->setLayoutPath(APPLICATION_PATH.'/layouts/scripts/login');
	}
	
	public function indexAction() {
		$this->view->headTitle("uiwiki-登陆");
		if ($this->getRequest ()->isPost ()) {
			Zend_Loader::loadClass ( 'Zend_Filter_StripTags' );
			$filter = new Zend_Filter_StripTags ();
			//表单的post值
			$name = $filter->filter ( $this->_request->getPost ( 'name' ) );
			$password = $filter->filter($this->_request->getPost ( 'password' ) );
			
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
					
					if ($auth->hasIdentity ()) //成功登录
					{
						//auth之后写入session
						$user = new Zend_Session_Namespace ( 'user' );
						$user->name = $data->name;
						$user->id = $data->id;
						$user->setExpirationSeconds ( 6000 ); //命名空间 "user" 将在第一次访问后 6000 秒过期
						//echo '<h3><font color=red> 登录成功!</font></h3>';
					
						$this->_redirect('/'.$name);
					
						
					}					
				} else {
					echo '<h3><font color=red> 登录失败,请重新登录!</font></h3>';
				}
			}
		}
	}
	
	public function findAction()
	{
		$this->view->headTitle("密码找回");
		//$this->_helper->viewRenderer->setNoRender ();
		if ($this->getRequest ()->isPost ()) {
			$nickname = trim($this->_request->getParam('nickname'));
			$email = trim($this->_request->getParam('email'));
			
			$account = new Application_Model_DbTable_Account();
			$db = $account->getAdapter();
			$select = $db->select();
			$select->from('account',array('nickname','password'));
			$select->where('nickname = ?',$nickname);
			$select->where('email = ?', $email);
			$result = $db->fetchRow($select);
			
			if($result){
				$smtpemailto = $email;
				$mailsubject = "cblog登陆密码找回";
				$mailbody = "<h1>cblog博客登陆密码找回</h1><p>您的博客:<br/><span>登陆账户为： ".$result['nickname']."</span> <br/> <span>登陆密码为：  ".$result['password']."</span></p>";
				if($this->send($smtpemailto,$mailsubject,$mailbody)){
		//		if($this->mailSend($smtpemailto,$mailsubject,$mailbody)){
					$status = "ok";
					$response = "密码已发到您的邮箱，请注意查收！";
				}else{
					$status = "sorry";
					$response = "邮箱服务出错，请稍后再试！";
				}
			}else{
				$status = "sorry";
				$response = "你输入的用户名和邮箱不匹配，请重试！";
			}
			//print_r($this->_request->getParams());
			//var_dump($result);
			if($this->getRequest ()->isXmlHttpRequest ()|| $this->_request->getParam('ajax')==1){
				$this->_helper->layout->setLayout ( 'empty_layout' );
				$this->_helper->viewRenderer->setNoRender ();
				$this->_response->appendBody ( $status );
			}else{
				echo "<script type='text/javascript'>alert('$response')</script>";
			}
		}
	}
	public function mailSend($smtpemailto,$mailsubject,$mailbody)
	{
		$smtpserver = "smtp.163.com";//SMTP服务器
		$smtpserverport =25;//SMTP服务器端口
		$smtpusermail = "blog_send_info@163.com";//SMTP服务器的用户邮箱
		//$smtpemailto = "";//发送给谁
		$smtpuser = "blog_send_info@163.com";//SMTP服务器的用户帐号
		$smtppass = "CblogMail163";//SMTP服务器的用户密码
		//$mailsubject = "";
		//$mailbody = "";
$mailHeader =<<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
EOD;

$mailFooter =<<<EOD
</body>
</html>
EOD;
		$mailContent = $mailHeader.$mailbody.$mailFooter;
		$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
		$smtp = new Cblog_Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
		$smtp->debug = false;//是否显示发送的调试信息
		if($smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailContent, $mailtype)){
			return true;	
		}else{
			return false;
		}
	}
	public function send($ToEmail,$subject,$message)
	{
		$sender = "cblog";//SMTP服务器的用户邮箱
		//$smtpemailto = "";//发送给谁
		$email = "blog_send_info@163.com";//SMTP服务器的用户帐号
		$password = "CblogMail163";//SMTP服务器的用户密码
		$mailObj = new Cblog_Mail($sender, $email, $password, $subject, $message);
		$mailObj->setToMail($ToEmail);
		return $mailObj->sendMail();
	}

}





