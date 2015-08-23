<?php

class Application_Model_Category
{
	protected $_id;
	protected $_cate;
	protected $_account_id;

	public function __construct(array $options = null)
	{
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}

	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid category property');
		}
		$this->$method($value);
	}

	public function __get($name)
	{
		$method = 'get' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid category property');
		}
		return $this->$method();
	}

	public function setOptions(array $options)
	{
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)) {
				$this->$method($value);
			}
		}
		return $this;
	}

	public function setId($id)
	{
		$this->_id = (int) $id;
		return $this;
	}

	public function getId()
	{
		return $this->_id;
	}
	public function setAccountId($id)
	{
		$this->_account_id = (int) $id;
		return $this;
	}
	public function getAccountId()
	{
		return $this->_account_id;
	}
	public function setCategory($name)
	{
		$this->_cate = $name;
		return $this;
	}

	public function getCategory()
	{
		return $this->_cate;
	}
}
