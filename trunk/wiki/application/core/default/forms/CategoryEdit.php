<?php
class Application_Form_CategoryEdit extends Zend_Form{
	public function init()
	{
		$this->setMethod('post');
	
		// create new element
		$id = $this->createElement('hidden', 'id');
		// add the element to the form
		$this->addElement($id);
	
		// create new element
		$name = $this->createElement('text', 'cate_name');
		// element options
		$name->setLabel('更改分类名称 ');
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