<?php

class Application_Form_BugReportForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$author = $this->createElement('text', 'author');
    	$author->setLabel('Enter your name:');
    	$author->setRequired(TRUE);
    	$author->setAttrib('size', 30);
    	$this->addElement($author);
    	
		$email = $this->createElement('text', 'email');
		$email->setLabel('Please input your email');
		$this->addElement($email);
		
		$this->addElement('password', 'password', array('label'=>'Please enter your password'));
		
		$this->addElement('submit', 'submit');
		
    }


}

