<?php
class Application_Model_DbTable_ViewStatistic extends Zend_Db_Table_Abstract {
	protected $_name = 'view_statistic';
	
	public function addViewIp($account_id, $ip)
	{
		$row = $this->createRow();
		$row->account_id = $account_id;
		$row->ip = $ip;
	
		return $row->save();
	}
}