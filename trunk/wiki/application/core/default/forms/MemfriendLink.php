<?php
class Application_Form_MemfriendLink extends Zend_Form
{
	public function init() {
	$this->setMethod ( 'post' );
	
	// create new element
	$id = $this->createElement ( 'hidden', 'id' );
	// element options
	$id->setDecorators ( array ('ViewHelper' ) );
	// add the element to the form
	$this->addElement ( $id );
	
	// create new element
	$menuId = $this->createElement ( 'hidden', 'account_id' );
	// element options
	$menuId->setDecorators ( array ('ViewHelper' ) );
	// add the element to the form
	$this->addElement ( $menuId );
	
	// create new element
	$label = $this->createElement ( 'text', 'label' );
	// element options
	$label->setLabel ( '名称: ' );
	$label->setRequired ( TRUE );
	$label->addFilter ( 'StripTags' );
	$label->setAttrib ( 'size', 40 );
	// add the element to the form
	$this->addElement ( $label );
	// create new element
	
	// create new element
	$link = $this->createElement ( 'text', 'link' );
	// element options
	$link->setLabel ( '链接地址: ' );
	$link->setRequired ( false );
	$link->setAttrib ( 'size', 50 );
	// add the element to the form
	$this->addElement ( $link );
	
	$submit = $this->addElement ( 'submit', 'submit', array ('label' => '提交' ) );
  }
}
?>