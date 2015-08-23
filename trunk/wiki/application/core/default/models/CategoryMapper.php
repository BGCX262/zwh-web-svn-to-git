<?php
class Application_Model_CategoryMapper
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
            $this->setDbTable('Application_Model_DbTable_ArticleCategory');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Category $category)
    {
        $data = array(
            'account_id'   => $category->getAccountId(),
            'cate' => $category->getCategory(),
        );

        if (null === ($id = $category->getId())) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
    public function find($id)
    {
    	//获取博主的所有文章分类
        $db = $this->getDbTable()->getAdapter();
        $select = $db->select();
        $select->from('category', '*');
        $select->where('category.account_id = ?', $id);
     	
        $result = $db->fetchAll($select);
     	
     	//$result = $db->query($sql);
        if (0 == count($result)) {
            return;
        }
        return $result;
    }
    /*
     * 功能： 获取文章分类，及每个分类下的文章数目
     */
    public function getCateAritcle($id)
    {	
    	$db = $this->getDbTable()->getDefaultAdapter();
    	$select = $db->select();
    	$select->from('ui_category', array('id','name'));
    	$select->where('project_id = ?',BLOGGER_ID);
    	$select->order('position');
    	$cates = $db->fetchAll($select);
    	
    	$select = $db->select();
    	$select->from('ui_article_category', array('id','cate_id','subcate_name'));
    	$select->where('project_id = ?',BLOGGER_ID);
    	$select->order('position');
    	$subcates = $db->fetchAll($select);
    	
    	$data = array();
    	foreach($cates as $cates_data){
    		$data[$cates_data['id']]['name'] = $cates_data['name'];
    		$data[$cates_data['id']]['id'] = $cates_data['id'];
    	}
    	foreach($subcates as $subcates_data){
    		$data[$subcates_data['cate_id']]['cates'][] = array('sub_id'=>$subcates_data['id'],'sub_name'=>$subcates_data['subcate_name']);
    	}
    	//print_r($cates);
    	//print_r($subcates);
    	$result = $data;
    	//print_r($result);
    	if (0 == count($result)) {
    		return;
    	}
    	return $result;   	
    }
    /*
     * 功能： 查看特定分类下的文章
     */
    public function getCateDetail($id, $cate_id)
    {
    	//显示文章列表和摘要
    	$db = $this->getDbTable()->getDefaultAdapter();
    	$select = $db->select();
    	$select->from('category');
    	$select->joinLeft('article', 'article.cate_id=category.id and article.account_id=category.account_id',array('id','title','summary' => 'LEFT(article.content,200)','view_counter','add_time'));
    	$select->join('atype', 'article.atype_id = atype.id', 'atype');
    	$select->where('category.account_id = ?', $id);
    	$select->where('category.id = ?', $cate_id);
    	$result = $db->fetchAll($select);
    	
    	if (0 == count($result)) {
    		return;
    	}
    	return $result;   	
    }
    public function delete($id)
    {
    	$db = $this->getDbTable()->getAdapter();
    	$where = $db->quoteInto('id = ?', $id);
    	$row_affected = $db->delete('category', $where);
    
    	return $row_affected;
    }
    public function fetchAll()
    {
    	$resultSet = $this->getDbTable()->fetchAll();
    	$entries   = array();
    	foreach ($resultSet as $row) {
    		$entry = new Application_Model_Category();
    		$entry->setId($row->id)
             	  ->setAccountId($row->account_id)
              	  ->setNickname($row->cate);
    		$entries[] = $entry;
    	}
    	return $entries;
    } 
}
