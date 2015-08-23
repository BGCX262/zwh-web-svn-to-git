<?php

class Calendarbox_calendarController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->layout->disableLayout();
	}
	public function indexAction()
	{		
				
		$cache = Zend_Registry::get('cache');
		$id = md5("calendarboxControllerIndex");
		if(($result = $cache->load($id)) === false) {
			$dateComponents = getdate();
			$today = $dateComponents['mday'];
			$month = $dateComponents['mon'];
			$year = $dateComponents['year'];
			$mapCate = new Application_Model_CategoryMapper();
			$result = $this->build_calendar($month,$year,$today);
		
			$cache->save($result, $id, array('calendarbox'));
		}
		
		//print_r($dateComponents);
		$this->view->calendar_table = $result;
	}
	private function build_calendar($month,$year,$today) {
		// 日历表头，星期天开始一直到星期六
		$daysOfWeek = array('日','一','二','三','四','五','六');
	
		// 本月第一天的位置
		$firstDayOfMonth = mktime(0,0,0,$month,1,$year);
	
		// 获取本月天数
		$numberDays = date('t',$firstDayOfMonth);
	
		// 获取本月第一天
		$dateComponents = getdate($firstDayOfMonth);
	
		// 获取月份的英文单词
		$monthName = $dateComponents['month'];
		
		//获取这个月发表的文章
		$mdlArt = new Application_Model_DbTable_Article();
		$db = $mdlArt->getAdapter();
		$select = $db->select();
		$select->from('article',array('title','day(add_time) as day'));
		$select->where('account_id = ?', BLOGGER_ID);
		$select->where('month(add_time)= ?', $month);
		$select->where('year(add_time)= ?', $year);
		$result = $db->fetchAll($select);
		
		//echo "<pre>";
		//echo $select->__toString();
		//print_r($result);
		//echo "</pre>";
		
		
		$dayOfWeek = $dateComponents['wday'];
	
		// 月历表头
	
		$calendar = "<table>";
		$calendar .= "<caption>$year-$month-$today</caption>";
		$calendar .= "<tr>";
	
		// 星期表头
	
		foreach($daysOfWeek as $day) {
			$calendar .= "<th class='header'>$day</th>";
		}
	
		// 开始输出日历
	
		// 初始化天数计数器，从1号开始
	
		$currentDay = 1;
	
		$calendar .= "</tr><tr>";
	
		// 使用变量 $dayOfWeek 可以保证一周七天精确输出
	
		if ($dayOfWeek > 0) {
			$calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
		}
	
		$month = str_pad($month, 2, "0", STR_PAD_LEFT);
	
		while ($currentDay <= $numberDays) {
	
			// 7天一行，7天一到新增一行
	
			if ($dayOfWeek == 7) {
	
				$dayOfWeek = 0;
				$calendar .= "</tr><tr>";
	
			}
	
			$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
	
			$date = "$year-$month-$currentDayRel";
			
			$len = count($result);
			$title = "";
			for($i=0; $i<$len;$i++){
				if($result[$i]['day'] == $currentDay){
					$title .= '『'.$result[$i]['title'].'』';
				}
			}
			
			if(empty($title)){
				$str = $currentDay;
			}else{
				$str = "<a class='post_day' href='/".BLOGGER_NAME."/article/index/date/".$year."-".$month."-".$currentDay."' title='发表了： ".$title."'>".$currentDay."</a>";
			}
			
			if($currentDay != $today){
				$calendar .= "<td class='day' rel='$date'>$str</td>";
			}else{
				$calendar .= "<td class='day today' rel='$date'>$str</td>";
			}
	
			// 计数器
	
			$currentDay++;
			$dayOfWeek++;
	
		}
	
		// 最后一行表格的处理，往往最后一行不可能全部填满，需要要空格填充。
	
		if ($dayOfWeek != 7) {
	
			$remainingDays = 7 - $dayOfWeek;
			$calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
	
		}
	
		$calendar .= "</tr>";
	
		$calendar .= "</table>";
	
		//echo sprintf("%s - %s - %s",$year, $month, $today);
		//print_r($year.'-'.$monthNum.'-'.$today);
		return $calendar;
	}
}