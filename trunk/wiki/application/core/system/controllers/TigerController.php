<?php

class TigerController extends Zend_Controller_Action
{

	private $_numPerPage = 50;
	private $_pageRange = 10;
	public function init(){
		Zend_Layout::startMvc(APPLICATION_PATH.'/layouts/scripts/tiger');
		$this->_helper->layout->setLayout('layout');
		$user = new Zend_Session_Namespace ( 'user' );
		
		if($user->nickname!="admin"){
			$this->_redirect('/');
		}
	}

   public function indexAction()
   {
   		$accMapper = new Application_Model_AccountMapper();
   		
   		$this->view->totals = $accMapper->fetchTotals();
   		
   		$result = $accMapper->fetchAccountList();
   		
   		//分页
   		$numPerPage = $this->_numPerPage;
   		$pageRange = $this->_pageRange;
   		$page = $this->_request->getParam('page', 1);
   		$offset = $numPerPage * $page;
   		
   		$paginator = Zend_Paginator::factory($result);
   		$paginator->setCurrentPageNumber($page)
   		->setItemCountPerPage($numPerPage)
   		->setPageRange($pageRange);
   		$this->view->paginator = $paginator;
   }
   public function delAction()
   {
	   	//获取文章id
	   	if($this->getRequest()->isGet()){
	   		$account_id = $this->_request->get('id');
	   		$nickname = $this->_request->get('nickname');
	   		
	   		$article = new Application_Model_DbTable_Account();
	   		$db = $article->getAdapter();
	   		//删除用户
	   		$where0 = $db->quoteInto('id = ?',$account_id);
	   		$db->delete('account', $where0);
	   		//删除文章
	   		$where1 = $db->quoteInto('account_id = ?',$account_id);
	   		$db->delete('article', $where1);
	   		//删除文章对应的评论
	   		$where2 = $db->quoteInto('account_id = ?', $account_id);
	   		$db->delete('comment', $where2);
	   		
	   		//删除用户目录
	   		$dir = BLOG_ROOT.'/public/'.$nickname;
	   		$this->delDirAndFile($dir);
	   		
	   	}
	   	//判断是否是ajax传值
	   	if($this->getRequest ()->isXmlHttpRequest () || $this->_getParam('ajax')==1){
	   		$this->_helper->layout->setLayout('empty_layout');
	   		$this->_helper->viewRenderer->setNoRender();
	   		$this->_response->appendBody(2);
	   	}else{
	   		$this->_helper->viewRenderer->setNoRender();
	   		$this->_forward('index');
	   	}
   }
	public function delDirAndFile( $dirName )
	{
		if ( $handle = opendir( $dirName ) ) {
		   while ( false !== ( $item = readdir( $handle ) ) ) {
			   if ( $item != "." && $item != ".." ) {
				   if ( is_dir( "$dirName/$item" ) ) {
				   		$this->delDirAndFile( "$dirName/$item" );
				   } else {
				   		unlink( "$dirName/$item" );
				   }
			   }
		   }
		   closedir( $handle );
		   rmdir( $dirName );
		}
	}
	public function websetAction(){
		if($this->getRequest()->isPost()){
			$cache = $this->_request->getParam('cache');
			$lifetime = $this->_request->getParam('cache_time');
			$config = array ();
			$config ['type'] = array ("img" ); //上传允许type值
			$type = "img";
			$config ['img'] = array ("jpg", "bmp", "gif", 'png' ); //img允许后缀
			$config ['img_size'] = 500; //上传img大小上限 单位：KB
			$config ['message'] = "上传成功"; //上传成功后显示的消息，若为空则不显示
			$config ['name'] = mktime (); //上传后的文件命名规则 这里以unix时间戳来命名
			$config ['img_dir'] = "/global/images/logo"; //上传img文件地址 采用绝对地址 采用绝对地址 方便upload.php文件放在站内的任何位置 后面不加"/"
			$config ['site_url'] = ""; //网站的网址 这与图片上传后的地址有关 最后不加"/" 可留空

			if($_FILES['blog_logo']){
				$filearr = pathinfo ( $_FILES ['blog_logo'] ['name'] );
				$filetype = $filearr ["extension"];
				if (! in_array ( $filetype, $config [$type] )) {
					//mkhtml($fn,"","错误的文件类型！");
					$error = "错误的文件类型！";
				}
				//判断文件大小是否符合要求
				if ($_FILES ['blog_logo'] ['size'] > $config [$type . "_size"] * 1024) {
					//mkhtml($fn,"","上传的文件不能超过".$config[$type."_size"]."KB！");
					$error = "上传的文件不能超过".$config[$type."_size"]."KB！";
				}
				if(isset($error)){
					$this->alert($error);
					return ;
				}
				if (! file_exists ( $_SERVER ['DOCUMENT_ROOT'] .'/'. $config [$type . "_dir"] )) {
					mkdir ( $_SERVER ['DOCUMENT_ROOT'].'/'. $config [$type . "_dir"], 0777 );
				}
				
				$file_abso = $config [$type . "_dir"] .'/'. $config ['name'] . "." . $filetype;
				$file_host = $_SERVER ['DOCUMENT_ROOT'] .'/'. $file_abso;								
				if (move_uploaded_file ( $_FILES ['blog_logo'] ['tmp_name'], $file_host )) {
					//mkhtml($fn,$config['site_url'].$file_abso,$config['message']);
					@chmod ( $file_host, 0777 );
					$response = $file_abso;
					$logo = '/global/images/logo/'. $config ['name'] . "." . $filetype;
				} 
				
			}else{
				$logo = '/global/images/logo.jpg';
			}
$data=<<<EOD
<?php
	return array(
		'LOGO'     => '$logo',
		'CACHE'    => '$cache',
		'LIFETIME' => $lifetime,
	);
?>
EOD;
			file_put_contents(APPLICATION_PATH.'/../data/config.inc.php', $data);
		}
	}
	public function logoutAction() {
		Zend_Session::destroy();
		$this->_helper->viewRenderer->setNoRender ();
		$this->_redirect('/');
	}
	public function alert($msg){
		echo "<script type='text/javascript'>alert('$msg')</script>";
	}
   
}

