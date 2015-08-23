<?php
class Application_Model_CommentMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
         if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        } 
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Comment');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Comment $comment)
    {
        $data = array(
            'password'   => $comment->getPassword(),
            'username' => $comment->getUserName(),
        );

        if (null === ($id = $comment->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    public function find($id)
    {
    	//获取某个文章下的所有评论
        $db = $this->getDbTable()->getAdapter();
        $select = $db->select();
        $select->from('comment', '*');
        $select->join('account','account.id = comment.account_id', 'account.photo');
        $select->where('comment.article_id = ?', $id);
     	
        $result = $db->fetchAll($select);
     	
     	//$result = $db->query($sql);
        return $result;
    }
    public function findBloggerComment($blogger_id)
    {
    	$db = $this->getDbTable()->getAdapter();
    	$select = $db->select();
    	$select->from('comment',array('id','post_time','replywho','content'));
    	$select->join('article','article.id=comment.article_id',array('title'));
    	$select->join('account','article.account_id=account.id','nickname');
    	$select->where('comment.account_id = ?',$blogger_id);
    	
    	//按文章和评论发表时间排序
    	$select->order(array('comment.article_id desc','comment.post_time desc'));
    	
    	$result = $db->fetchAll($select);
  
    	return $result;
    }
    public function findBloggerAritcleComment($blogger_id)
    {
    	$db = $this->getDbTable()->getAdapter();
    	$select = $db->select();
    	$select->from('comment',array('id','replywho','content','post_time','nickname as commenter'));
    	$select->join('article','article.id=comment.article_id','title');
    	$select->join('account','account.id=article.account_id','nickname');
    	$select->where('article.account_id = ?',$blogger_id);
    	$select->where('comment.article_id = article.id');
    	$select->order(array('comment.article_id desc','comment.post_time desc'));
    	
    	$result = $db->fetchAll($select);
    	return $result;
    }
    public function findBloggerNewComment($blogger_id)
    {
    	$db = $this->getDbTable()->getAdapter();
    	$select = $db->select();
    	$select->from('comment',array('content','nickname as commenter'));
    	$select->join('article','article.id=comment.article_id',array('title','id'));
    	$select->join('account','account.id=comment.account_id','photo');
    	$select->where('article.account_id = ?',$blogger_id);
    	$select->where('comment.article_id = article.id');
    	$select->order('comment.post_time desc');
    	$select->limit(8);
    
    	$result = $db->fetchAll($select);
    	
    	return $result;
    }
    public function delete($id)
    {
    	$db = $this->getDbTable()->getAdapter();
    	$where = $db->quoteInto('id = ?', $id);
    	$row_affected = $db->delete('comment', $where);
    
    	return $row_affected;
    }
    public function fetchAll()
    {
    	$resultSet = $this->getDbTable()->fetchAll();
    	$entries   = array();
    	foreach ($resultSet as $row) {
    		$entry = new Application_Model_Comment();
    		$entry->setId($row->id)
             	  ->setAccountId($row->account_id)
              	  ->setNickname($row->nickname)
              	  ->setPostTime($row->post_time)
              	  ->setCommentId($row->comment_id)
              	  ->setArticleId($row->article_id)
              	  ->setContent($row->content);
    		$entries[] = $entry;
    	}
    	return $entries;
    } 
}
