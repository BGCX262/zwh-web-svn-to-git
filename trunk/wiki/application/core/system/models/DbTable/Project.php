<?php

class Application_Model_DbTable_Project extends Zend_Db_Table_Abstract
{
    protected $_name = 'ui_project';
    public function getProject($id)
    {
    	$select = $this->select();
    	$select->where("id = ?", $id);
    	$items = $this->fetchRow($select);
    	
    	return $items;
    }
    public function addProject($name,  $password, $email, $issue_time)
    {
    	$row = $this->createRow();
    	$row->name = $name;
    	$row->password = $password;
    	$row->email = $email;
    	$row->issue_time = $issue_time;
    	
    	return $row->save();
    }
    public function updateInfo($id, $username, $site, $introduce, $qq, $msn){
    	$row = $this->find ( $id )->current ();
    	if ($row) {
    		$row->username = $username;
    		$row->site = $site;
    		$row->introduce =  $introduce;
    		$row->qq = $qq;
    		$row->msn = $msn;
    		return $row->save ();
    	} else {
    		throw new Zend_Exception ( "Error loading menu item" );
    	}
    }
    public function updateMail($id, $mail){
    	$row = $this->find ( $id )->current ();
    	if ($row) {
    		$row->email = $mail;
    		return $row->save ();
    	} else {
    		throw new Zend_Exception ( "Error loading menu item" );
    	}
    }
    public function updatePwd($id, $pwd){
    	$row = $this->find ( $id )->current ();
    	if ($row) {
    		$row->password = $pwd;
    		return $row->save ();
    	} else {
    		throw new Zend_Exception ( "Error loading menu item" );
    	}
    }
}
