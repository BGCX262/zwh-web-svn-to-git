<?php
class ArticleController extends Zend_Controller_Action
{

	private $_numPerPage = 15;  
	private $_pageRange = 10;
    public function init()
    {
        /* Initialize action controller here */  
    	
    	$widget = new Cblog_Widget();
    	//$widget->get_widgets();
    	Zend_Layout::startMvc(APPLICATION_PATH.'/layouts/scripts');
    	$response = $this->getResponse();
    	$sideone = $widget->get_left_widgets();
    	$response->insert('sideone', $sideone);
    	$sidetwo = $widget->get_right_widgets();
    	$response->insert('sidetwo', $sidetwo);
  	
    	$project = new Application_Model_DbTable_Project();
    	$db = $project->getAdapter();
    	$select = $db->select();
    	$select->from('ui_project','title');
    	$select->where('id = ?',BLOGGER_ID);
    	$data = $db->fetchOne($select);
    	
    	if($data){
    		$response->insert('title', $data);
    	}else{
    		$response->insert('title','');
    	}
    	
    
    	$this->_helper->layout->setLayout('layout');
    }

    public function indexAction()
    {
    	//显示文章列表和摘要 
    	$project = new Application_Model_DbTable_Project();
    	$db = $project->getAdapter();
    	$select = $db->select();
    	$select->from('ui_project','main_page');
    	$select->where('id = ?',BLOGGER_ID);
    	$data = $db->fetchOne($select);
    	if($data){
    		$this->view->main_page = $data;
    	}else{
    		$this->view->main_page = '';
    	}	
    }
    /*
     * 查看具体文章
     */
    public function detailAction()
    {
    	//获取文章id
    	if($this->getRequest()->isGet()){
    		$article_id = $this->_request->get('id');
    		$article = new Application_Model_DbTable_Article();
    		$db = $article->getAdapter();
    		$select = $db->select();
    		$select->from('ui_article',array('id','content','issue_time'));
    		$select->where('ui_article.parent_id = ?', $article_id);
    		$select->order('id');
    		$result = $db->fetchAll($select);
    		
    		$this->view->headScript()->appendFile('/lib/kindeditor/kindeditor.js')
    								->appendFile('/lib/kindeditor/lang/zh_CN.js');
    		$this->view->headLink()->appendStylesheet("/lib/syntaxhighlighter/styles/shCore.css")
    							   ->appendStylesheet("/lib/syntaxhighlighter/styles/shThemeDefault.css");
	    	 		
    		
    		$user = new Zend_Session_Namespace('user');
    		//print_r($user->name);
    		if($user->nickname){
    			$this->view->account_id = $user->id;
    			$this->view->nickname = $user->nickname;
    		}
    		$this->view->pid = $article_id;
    		$this->view->data = $result;
    	}
    }
    /*
     * 删除文章
     */
    public function deleteAction()
    {
    	$user = new Zend_Session_Namespace('user');
    	if(!isset($user->nickname)&&$user->nickname!=BLOGGER_NAME){
    		$this->_redirect('/');
    	}
    	//获取文章id
    	if($this->getRequest()->isGet()){
    		$section_id = $this->_request->get('id');
    		$article_id = $this->_request->get('pid');
    		$article = new Application_Model_DbTable_Article();
    		$db = $article->getAdapter();
    		//删除文章
    		$where = $db->quoteInto('id = ?',$section_id);    		
    		$affected = $db->delete('ui_article', $where);
    	}
    	$cache = Zend_Registry::get('cache');
    	$cache->clean(
    		Zend_Cache::CLEANING_MODE_MATCHING_TAG,
    			array('article_index')
    	);
    	$cache->clean(
    			Zend_Cache::CLEANING_MODE_MATCHING_TAG,
    			array('article_list')
    	);
    	//判断是否是ajax传值
    	if($this->getRequest ()->isXmlHttpRequest () || $this->_getParam('ajax')==1){
    		$this->_helper->layout->setLayout('empty_layout');
    		$this->_helper->viewRenderer->setNoRender();
    		$this->_response->appendBody($affected);
    	}else{
    		$this->_helper->viewRenderer->setNoRender();
    		$this->_redirect('/article/detail/id/'.$article_id);
    	}	
    }
    /*
     * 功能： 文章搜索， 多关键字搜索
     */
    public function searchAction(){
    	if ($this->getRequest ()->isPost ()) {
    		$keywords = trim($this->_request->getParam('keywords'));
			$result = preg_split("/\s+/",$keywords);
			
			$article = new Application_Model_DbTable_Article();
			$db = $article->getAdapter();
			$len = count($result);
			
			$this->view->keywords = join('--', $result);
			/* $select->from('article', array('id','title','summary' => 'LEFT(article.content,200)','view_counter','add_time'));
			$select->join('atype', 'article.atype_id = atype.id', 'atype');
			$select->where('article.account_id = ?', BLOGGER_ID);
			$select->Where('title LIKE ?' ,'%'.$result[0].'%');
			$select->orWhere('content LIKE ?','%'.$result[0].'%'); */
			$select_arr = array();
			for($i=0;$i<$len;$i++) //根据每个搜索关键词构建SQL语句
			{
				if($i==0){
					$temp = 'select'.$i;
					$$temp = $db->select();
					$$temp->from('article', array('id','title','summary' => 'LEFT(article.content,200)','view_counter','add_time'));
					$$temp->join('atype', 'article.atype_id = atype.id', 'atype');
					$$temp->where('article.account_id = ?', BLOGGER_ID);
					$$temp->Where('title LIKE ?' ,'%'.$result[$i].'%');
					$$temp->orWhere('content LIKE ?','%'.$result[$i].'%');
					$select_arr[]=$$temp;
				}else{
					$temp = 'select'.$i;
					$$temp = $db->select();
					$$temp->from('article', array('id','title','summary' => 'LEFT(article.content,200)','view_counter','add_time'));
					$$temp->join('atype', 'article.atype_id = atype.id', 'atype');
					$$temp->where('article.account_id = ?', BLOGGER_ID);
					$$temp->Where('title LIKE ?' ,'%'.$result[$i].'%');
					$$temp->orWhere('content LIKE ?','%'.$result[$i].'%');
					$select_arr[]=$$temp;
				}
				$select = $db->select();
				$select->union($select_arr);
				$select->group('article.id');
			} 
			$data = $db->fetchAll($select);
		
			//分页
			$numPerPage = $this->_numPerPage;
			$pageRange = $this->_pageRange;
			$page = $this->_request->getParam('page', 1);
			$offset = $numPerPage * $page;
			
			$paginator = Zend_Paginator::factory($data);
			$paginator->setCurrentPageNumber($page)
			->setItemCountPerPage($numPerPage)
			->setPageRange($pageRange);
			$this->view->paginator = $paginator;
			
			$comment = new Application_Model_DbTable_Comment();
			$db = $comment->getAdapter();
			$select = $db->select();
			$select->from('comment',array('article_id','total'=>'count(*)'));
			$select->group('article_id');
			$comment = $db->fetchAll($select);
			$ca = array();
			foreach($comment as $arr){
				$ca[$arr['article_id']] = $arr['total'];
			}
			$this->view->comment = $ca;
			$user = new Zend_Session_Namespace('user');
			if(isset($user->nickname)&&$user->nickname==BLOGGER_NAME){
				$this->view->show = true;
			}else{
				$this->view->show = false;
			}			
    	}
    }
    
}

