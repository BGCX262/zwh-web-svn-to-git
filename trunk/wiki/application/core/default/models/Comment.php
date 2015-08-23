<?php

class Application_Model_Comment
{
    protected $_id;
    protected $_account_id;
    protected $_nickname;
    protected $_post_time;
    protected $_comment_id;
    protected $_article_id;
    protected $_content;
    
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
            throw new Exception('Invalid comment property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid comment property');
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
    public function setCommentId($id)
    {
    	$this->_comment_id = (int) $id;
    	return $this;
    }
    
    public function getCommentId()
    {
    	return $this->_comment_id;
    }
    public function setArticleId($id)
    {
    	$this->_article_id = (int) $id;
    	return $this;
    }
    
    public function getArticleId()
    {
    	return $this->_article_id;
    }
    public function setNickname($name)
    {
    	$this->_nickname = $name;
    	return $this;
    }
    
    public function getNickname()
    {
    	return $this->_nickname;
    }
    public function setPostTime($time)
    {
    	$this->_post_time = $time;
    	return $this;
    }
    
    public function getPostTime()
    {
    	return $this->_post_time;
    }
    public function setContent($content)
    {
    	$this->_content = $content;
    	return $this;
    }
    
    public function getContent()
    {
    	return $this->_content;
    }
}
