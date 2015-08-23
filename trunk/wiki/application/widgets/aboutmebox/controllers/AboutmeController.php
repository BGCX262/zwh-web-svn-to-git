<?php

class Aboutmebox_aboutmeController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->layout->disableLayout();
	}
	public function indexAction()
	{
		
		$cache = Zend_Registry::get('cache');
		$id = md5("aboutmeControllerIndex");
		if(($result = $cache->load($id)) === false) {
			//$data = $db->fetchAll($select);
			$account = new Application_Model_DbTable_Account();
			$db = $account->getAdapter();
			//获取用户信息
			$select = $db->select();
			$select->from('account', array('nickname','photo'));
			$select->where('id = ?', BLOGGER_ID);
			$result = $db->fetchRow($select);
			
			//获取博主 原创 翻译 转载各自篇数，和评论数
			
			$select = $db->select();
			$select->from('article',array('count(*) totalori'));
			$select->where('atype_id = 1');
			$select->where('account_id = ?', BLOGGER_ID);
			$arr = $db->fetchRow($select);;
			$result['totalori'] = $arr['totalori'];
			
			$select = $db->select();
			$select->from('article',array('count(*) totaltrans'));
			$select->where('atype_id = 2');
			$select->where('account_id = ?', BLOGGER_ID);
			$arr = $db->fetchRow($select);;
			$result['totaltrans'] = $arr['totaltrans'];
			
			$select = $db->select();
			$select->from('article',array('count(*) totalresp'));
			$select->where('atype_id = 3');
			$select->where('account_id = ?', BLOGGER_ID);
			$arr = $db->fetchRow($select);;
			$result['totalresp'] = $arr['totalresp'];
			
			$comment = new Application_Model_CommentMapper();
			$comment_info = $comment->findBloggerAritcleComment(BLOGGER_ID);
			$totalComment = count($comment_info);
			$result['totalcom'] = $totalComment;
			
			//获取博客访问量
			//获取博主已访问过的ip
			
			$select = $db->select();
			$select->from('view_statistic','ip');
			$select->where('account_id = ?',BLOGGER_ID);
			$ips = $db->fetchAll($select);
			//获取当前访问ip
			include_once APPLICATION_PATH . '/../library/Cblog/RealIp.php';
			$ipObj = new Cblog_RealIp();
			$ip = $ipObj->getIp();
			foreach($ips as $arr){
				if($ip==$arr['ip']){
					$status = "yes";
					break;
				}
			}
			$select = $db->select();
			$select->from('view_statistic','count(id) as totalview');
			$select->where('account_id = ?',BLOGGER_ID);
			$totalViews = $db->fetchOne($select);
			//print_r($status);
			if(!isset($status)){
				$viewstastic = new Application_Model_DbTable_ViewStatistic();
				$viewstastic->addViewIp(BLOGGER_ID, $ip);
				$result['totalview'] = $totalViews+1;
			}else{
				$result['totalview'] = $totalViews;
			}
			$cache->save($result, $id, array('aboutmebox'));
		}
		
		//print_r($result);
		$this->view->data = $result;
	}
}