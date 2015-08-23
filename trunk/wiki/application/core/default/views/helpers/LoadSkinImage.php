<?php 
/** 
 * this class loads the cblog skin 
 * 
 */ 
class Zend_View_Helper_LoadSkinImage extends Zend_View_Helper_Abstract 
{ 
    public function loadSkinImage ($skin)
    {
    	// load the skin config file
    	$skinData = new Zend_Config_Xml('../skins/' . $skin . '/skin.xml');
    	$image = $skinData->images->image;
    	return '/skins/'.$skin.'/images/'.$image;
    }
} 