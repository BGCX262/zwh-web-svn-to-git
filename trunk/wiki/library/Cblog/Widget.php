<?php
class Cblog_Widget extends Zend_View_Helper_Action{
	private $left_component = '';
	private $right_component = "";

	public function get_right_widgets()
	{
		$widget_config_path = APPLICATION_PATH.'/../data/init/widgets.config.xml';
		$widgetData = simplexml_load_file($widget_config_path);

		if(!empty($widgetData->rightside)){
			foreach($widgetData->rightside->component as $widget){
				if($widget->show == 'true'){
					//$this->component .= file_get_contents(SITE_URL.'/'.$widget->name.'box/'.$widget->name.'/index');
					$this->right_component .= $this->action('index',$widget->name,$widget->name.'box');
				}
			}
			return $this->right_component;
		}
		return ;
	}
	public function get_left_widgets()
	{
		$widget_config_path = APPLICATION_PATH.'/../data/init/widgets.config.xml';
		$widgetData = simplexml_load_file($widget_config_path);
	
		if(!empty($widgetData->leftside)){
			foreach($widgetData->leftside->component as $widget){
				if($widget->show == 'true'){
					//$this->component .= file_get_contents(SITE_URL.'/'.$widget->name.'box/'.$widget->name.'/index');
					$this->left_component .= $this->action('index',$widget->name,$widget->name.'box');
				}
			}
			return $this->left_component;
		}
		return ;
	}
}