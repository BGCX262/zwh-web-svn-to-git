<?php
class Application_Form_Category extends Zend_Form{
	public function init()
	{
		$this->setMethod('post');
	
		// create new element
		$idElem = $this->createElement('hidden', 'id');
		// add the element to the form
		$this->addElement($idElem);
	
		// create new element
		$name = $this->createElement('text', 'cate_name');
		// element options
		$name->setLabel('新建一个分类 ');
		$name->setRequired(TRUE);
		$name->setAttrib('size',40);
		// strip all tags from the menu name for security purposes
		$name->addFilter('StripTags');
		// add the element to the form
		
		$this->addElement($name);
		
		$submit = $this->createElement('submit', '提交');
		
		$this->addElement($submit);

	}
	
	
}