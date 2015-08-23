<?php

class Application_Model_DbTable_Account extends Zend_Db_Table_Abstract
{
    protected $_name = 'account';
    public function getAccount($id)
    {
    	$select = $this->select();
    	$select->where("id = ?", $id);
    	$items = $this->fetchRow($select);
    	
    	return $items;
    }
    public function addAccount($username, $nickname, $password, $role="member", $email)
    {
    	$row = $this->createRow();
    	$row->username = $username;
    	$row->nickname = $nickname;
    	$row->password = $password;
    	$row->role = $role;
    	$row->email = $email;

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
    public function updateDescription($id, $des)
    {
    	$row = $this->find ( $id )->current ();
    	if ($row) {
    		$row->description = $des;
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
    public function updatePhoto($id, $hd_img)
    {
    	$row = $this->find ( $id )->current ();
    	if ($row) {
    		$row->photo = $hd_img;
    		return $row->save ();
    	} else {
    		throw new Zend_Exception ( "Error loading menu item" );
    	}
    }
}
