<?php
class BloggerController extends Zend_Controller_Action {
	private $_numPerPage = 10;
	private $_pageRange = 10;
	public function init() {
		$this->_helper->layout->setLayout ( 'container_layout' );
		$user = new Zend_Session_Namespace('user');
		if($user->nickname!=BLOGGER_NAME){
			$this->_redirect('/user/login');
		}
	}
	/*
	 * 功能： 显示博主发表的评论列表
	 * 权限： 管理员
	 */
	public function comlistAction() {
		$commentMapper = new Application_Model_CommentMapper ();
		$result = $commentMapper->findBloggerComment ( BLOGGER_ID );
		//var_dump($result);
		//分页
		$numPerPage = $this->_numPerPage;
		$pageRange = $this->_pageRange;
		$page = $this->_request->getParam ( 'page', 1 );
		$offset = $numPerPage * $page;
		
		$paginator = Zend_Paginator::factory ( $result );
		$paginator->setCurrentPageNumber ( $page )->setItemCountPerPage ( $numPerPage )->setPageRange ( $pageRange );
		$this->view->data = $paginator; 
		//$this->_helper->viewRenderer->setNoRender ();
		$this->view->headLink ()->appendStylesheet ( "/lib/syntaxhighlighter/styles/shCore.css" )->appendStylesheet ( "/lib/syntaxhighlighter/styles/shThemeDefault.css" );
	}
	/*
	 * 功能： 显示博主文章所有的评论列表
	 * 权限： 管理员
	 */
	public function comartlistAction() {
		$commentMapper = new Application_Model_CommentMapper ();
		$result = $commentMapper->findBloggerAritcleComment ( BLOGGER_ID );
		
		//分页
		$numPerPage = $this->_numPerPage;
		$pageRange = $this->_pageRange;
		$page = $this->_request->getParam ( 'page', 1 );
		$offset = $numPerPage * $page;
		
		$paginator = Zend_Paginator::factory ( $result );
		
		$paginator->setCurrentPageNumber ( $page )->setItemCountPerPage ( $numPerPage )->setPageRange ( $pageRange );
		$this->view->data = $paginator;

		
		$this->view->headLink ()->appendStylesheet ( "/lib/syntaxhighlighter/styles/shCore.css" )->appendStylesheet ( "/lib/syntaxhighlighter/styles/shThemeDefault.css" );
	}
	/*
	 *功能： 删除评论
	 *权限: 管理员
	 */
	public function comdelAction() {
		if ($this->getRequest ()->isGet ()) {
			$id = $this->_request->get ( 'id' );
			$comment = new Application_Model_CommentMapper ();
			$affected = $comment->delete ( $id );
		}
		if ($this->getRequest ()->isXmlHttpRequest () || $this->_getParam ( 'ajax' ) == 1) {
			$this->_helper->layout->setLayout ( 'empty_layout' );
			$this->_helper->viewRenderer->setNoRender ();
			$this->_response->appendBody ( $affected );
		} else {
			if ($this->_request->get ( 'from' )) {
				$url = $this->_request->get ( 'from' );
				$url = str_replace ( '-', '/', $url );
				$this->_helper->viewRenderer->setNoRender ();
				$this->_redirect ( '/' . $url . '#look_comment' );
			}
			$this->_redirect ( '/' . BLOGGER_NAME . '/blogger/comlist' );
		}
	}
	/*
	 * 功能： 博客配置
	 * 权限： 管理员
	 */
	public function configAction() {
		$skin = $this->view->skin;  //用户配置的皮肤
		
		$data = array(); 
		//获取皮肤列表
		$dh  = opendir(BLOG_ROOT.'/skins');
		while (false !== ($filename = readdir($dh))) {
			if($filename!='.'&&$filename!='..'){
				$files[] = $filename;
			}			
		}
		foreach($files as $skin){
			$data[$skin] = $this->view->loadSkinImage($skin);
		}
		$this->view->defaultSkin = $skin;
		$this->view->skinList = $data;
		
		if ($this->getRequest ()->isPost ()){
			$welcom = $this->_request->getParam('description');
			$skin = $this->_request->getParam('skin');
			$account = new Application_Model_DbTable_Account();
			$result = $account->updateDescription(BLOGGER_ID, $welcom);
			$this->setSkin($skin);
			echo "<script type='text/javascript'>alert('配置成功！');window.location.href='/".BLOGGER_NAME."'</script>";
		}
	}
	private function setSkin($skin)
	{	
		$xml = simplexml_load_file(BLOG_ROOT.'/'.BLOGGER_NAME.'/config/skin.xml');
		$xml->name = $skin;
		$newXML = $xml->asXML();
		$fp = fopen(BLOG_ROOT.'/'.BLOGGER_NAME.'/config/skin.xml', "w");
		fwrite($fp, $newXML);
		fclose($fp);
	}
	/*
	 * 功能： 个人设置
	 * 权限： 管理员
	 */
	public function profileAction() {
		//读取用户信息
		$account = new Application_Model_DbTable_Account ();
		$data = $account->getAccount ( BLOGGER_ID );
		
		//print_r($this->_request->getParams());
		

		$this->view->data = $data;
	
	}
	/*
	 * 功能： 个人信息
	 * 权限： 管理员
	 */
	public function infoAction(){
		if ($this->getRequest ()->isPost () || $this->getRequest ()->isXmlHttpRequest ()) {
			$username = $this->_request->getParam('username');
			$site = $this->_request->getParam('site');
			$introduce = $this->_request->getParam('introduce');
			$qq = $this->_request->getParam('qq');
			$msn = $this->_request->getParam('msn');
			$account = new Application_Model_DbTable_Account();
			$result = $account->updateInfo(BLOGGER_ID, $username, $site, $introduce, $qq, $msn);
		}
		//$response = '{"img":"' . $response . '","error":"'.$error.'"}';
		$this->_helper->viewRenderer->setNoRender ();
		//$this->_response->appendBody ( );
		$this->_forward('profile');
	}
	/*
	 * 功能： 修改邮箱
	 * 权限： 管理员
	 */
	public function emailAction(){
		if ($this->getRequest ()->isPost ()) {
			$nickname = trim($this->_request->getParam('nickname'));
			$pwd = trim($this->_request->getParam('pwd'));
			$oldmail = trim($this->_request->getParam('oldmail'));
			$newmail = trim($this->_request->getParam('newmail'));
			
			
			$account = new Application_Model_DbTable_Account();
			$db = $account->getAdapter();
			$select = $db->select();
			$select->from('account',array('nickname','password','email'));
			$select->where('id = ?', BLOGGER_ID);
			$data = $db->fetchRow($select);
			
			if($nickname!=$data['nickname']){
				$response = "用户名错误！";
			}else if($pwd!=$data['password']){
				$response = "密码错误！";
			}else if($oldmail!=$data['email']){
				$response ="请输入您的原注册邮箱！";
			}else if(!preg_match("/^[\\w\\-\\.]+@[\\w\\-\\.]+(\\.\\w+)+$/", $newmail)){
				$response = "请您输入正确的新邮箱账号！";
			}else{
				$affected = $account->updateMail(BLOGGER_ID, $newmail);
				if($affected>=1){
					$response = "邮箱修改成功！";
				}else{
					$response = "系统出错，请稍后再试！";
				}
			}
			if($this->getRequest ()->isXmlHttpRequest ()|| $this->_request->getParam('ajax')==1){
				$this->_helper->layout->setLayout ( 'empty_layout' );
				$this->_helper->viewRenderer->setNoRender ();
				$this->_response->appendBody ( $response );
			}else{
				$this->_forward('profile');
				echo "<script type='text/javascript'>alert('$response')</script>";
			}
		}
	}
	/*
	 * 功能： 修改密码
	 * 权限： 管理员
	 */
	public function pwdAction(){
		if ($this->getRequest ()->isPost ()) {
			$oldpwd = trim($this->_request->getParam('oldpwd'));
			$newpwd = trim($this->_request->getParam('newpwd'));
			$confirmpwd = trim($this->_request->getParam('confirmpwd'));
		
		
			$account = new Application_Model_DbTable_Account();
			$db = $account->getAdapter();
			$select = $db->select();
			$select->from('account','password');
			$select->where('id = ?', BLOGGER_ID);
			$data = $db->fetchRow($select);
		
			if($oldpwd!=$data['password']){
				$response = "请输入原始注册密码！";
			}else if($newpwd!=$confirmpwd){
				$response = "两次密码输入不一致！";
			}else{
				$affected = $account->updatePwd(BLOGGER_ID, $newpwd);
				if($affected>=1){
					$response = "密码修改成功！";
				}else{
					$response = "系统出错，请稍后再试！";
				}
			}
			if($this->getRequest ()->isXmlHttpRequest ()|| $this->_request->getParam('ajax')==1){
				$this->_helper->layout->setLayout ( 'empty_layout' );
				$this->_helper->viewRenderer->setNoRender ();
				$this->_response->appendBody ( $response );
			}else{
				$this->_forward('profile');
				echo "<script type='text/javascript'>alert('$response')</script>";
			}
		}
	}
	public function uploadAction() {
		$this->_helper->layout->setLayout ( 'empty_layout' );
		
		//$file = $this->_request->getParam('file');
		

		if ($this->getRequest ()->isPost () || $this->getRequest ()->isXmlHttpRequest ()) {
			$config = array ();
			$config ['type'] = array ("img" ); //上传允许type值
			$type = "img";
			$config ['img'] = array ("jpg", "bmp", "gif", 'png' ); //img允许后缀
			$config ['img_size'] = 500; //上传img大小上限 单位：KB
			$config ['message'] = "上传成功"; //上传成功后显示的消息，若为空则不显示
			$config ['name'] = mktime (); //上传后的文件命名规则 这里以unix时间戳来命名
			$config ['img_dir'] = "upload/temp/" . BLOGGER_NAME; //上传img文件地址 采用绝对地址 采用绝对地址 方便upload.php文件放在站内的任何位置 后面不加"/"
			$config ['site_url'] = ""; //网站的网址 这与图片上传后的地址有关 最后不加"/" 可留空
			if (is_uploaded_file ( $_FILES ['file'] ['tmp_name'] )) {
				
				//判断上传文件是否允许
				$filearr = pathinfo ( $_FILES ['file'] ['name'] );
				$filetype = $filearr ["extension"];
				if (! in_array ( $filetype, $config [$type] )) {
					//mkhtml($fn,"","错误的文件类型！");
					$error = "错误的文件类型！";
				}
				//判断文件大小是否符合要求
				if ($_FILES ['file'] ['size'] > $config [$type . "_size"] * 1024) {
					//mkhtml($fn,"","上传的文件不能超过".$config[$type."_size"]."KB！");
					$error = "上传的文件不能超过".$config[$type."_size"]."KB！";
				}
				
				if (! file_exists ( $_SERVER ['DOCUMENT_ROOT'] .'/'. $config [$type . "_dir"] )) {
					mkdir ( $_SERVER ['DOCUMENT_ROOT'].'/'. $config [$type . "_dir"], 0777 );
				}
				
				$file_abso = $config [$type . "_dir"] .'/'. $config ['name'] . "." . $filetype;
				$file_host = $_SERVER ['DOCUMENT_ROOT'] .'/'. $file_abso;
				
				if(!isset($error)){
					if (move_uploaded_file ( $_FILES ['file'] ['tmp_name'], $file_host )) {
						//mkhtml($fn,$config['site_url'].$file_abso,$config['message']);
						@chmod ( $file_host, 0777 );
					
						$response = $file_abso;
						
						$cache = Zend_Registry::get('cache');
						$cache->clean(
								Zend_Cache::CLEANING_MODE_MATCHING_TAG,
								array('aboutmebox')
						);
						$cache->clean(
								Zend_Cache::CLEANING_MODE_MATCHING_TAG,
								array('calendarbox')
						);
					} else {
						//mkhtml($fn,"","文件上传失败，请检查上传目录设置和目录读写权限");
						$error = "文件上传失败，请检查上传目录设置和目录读写权限";
					}
				}				
			}
		}
		if(!isset($response)) $response="";
		if(!isset($error)) $error="";
		$response = '{"img":"'.$response.'","error":"'.$error.'"}';
		$this->_helper->viewRenderer->setNoRender ();
		$this->_response->appendBody ( $response );
	}
	public function saveAction() {
		$this->_helper->layout->setLayout ( 'empty_layout' );
		if ($this->getRequest ()->isPost () || $this->getRequest ()->isXmlHttpRequest ()) {
			$path = $this->_request->getParam ( 'path' );
			
			if(dirname($path)!="/upload/image/head"){
			
			$ab_path = $_SERVER ['DOCUMENT_ROOT'].'/'.substr($path,1);
			$filename = end(explode('/',$ab_path));
			$dest = $_SERVER ['DOCUMENT_ROOT'].'/upload/image/head/'.$filename;
			if(copy($ab_path, $dest)){
				touch($dest, filemtime($ab_path));
				$this->delDir($_SERVER ['DOCUMENT_ROOT'].'/upload/temp/'.BLOGGER_NAME.'/');				
				//将头像插入数据库
				$account = new Application_Model_DbTable_Account();
				$result = $account->updatePhoto(BLOGGER_ID, '/upload/image/head/'.$filename);
				if($result){
					$response = '头像设置成功';
				}else{
					$response = "系统忙，请稍后再试！";
				}
							
			}else{
				$response = "系统出错，请稍后再试！";
			}
			
			}else{
				$response = "头像设置成功";
			}
			
			$this->_helper->viewRenderer->setNoRender ();
			$this->_response->appendBody ( $response );
		}
	}
	private function delDir($dir) {
		$handle = opendir($dir);
		while (false !== ($file = readdir($handle)) ) {
			if ($file != "." && $file != '..') {
				$fullpath = $dir . '/' . $file;
				if (! is_dir ( $fullpath )) {
					unlink ( $fullpath );
				} else {
					$this->delDir ( $fullpath );
				}
			}
			
		}
		closedir ( $handle );
		if(rmdir($dir)){
			return true;
		}else{
			return false;
		}
	}
	/*
	 * 更新缓存
	 */
	public function updatememAction()
	{
		$cache = Zend_Registry::get('cache');
		$cache->clean();
		$this->_helper->viewRenderer->setNoRender ();
		$this->_redirect('/');
	}
	
}