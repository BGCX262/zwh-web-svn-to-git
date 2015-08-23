<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$author = $this->createElement('text', 'username');
    	$author->setLabel('Enter your name');
    	$this->addElement($author); 	
    	$this->addElement('password', 'password', array('label'=>'Enter your password'));  	
    	//$this->addElement('submit', 'login');
    	$this->addElement('submit', 'logout');
    	
    	$submit = $this->createElement('submit', 'login');
    	$this->addElement($submit);
    	$submit->setDecorators(array(
    			array('ViewHelper'),
    			array('Description'),
    			array('HtmlTag', array('tag' => 'li', 'class'=>'submit-group')),
    	));
    	
    	$this->addDecorator('FormElements')
    		 ->addDecorator('HtmlTag', array('tag' => 'ul'))
    		 ->addDecorator('Form');
    	
    	$this->setElementDecorators(array(
    			array('ViewHelper'),
    			array('Errors'),
    			array('Description'),
    			array('Label', array('separator'=>'')),
    			array('HtmlTag', array('tag' => 'li', 'class'=>'element-group')),
    	));
    }


}

