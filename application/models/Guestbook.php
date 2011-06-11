<?php

class Application_Model_Guestbook extends Application_Model_GeustbookAbstract
{
    protected $_comment;
    protected $_created;
    protected $_url;
    protected $_email;
    protected $_username;
    protected $_id;

    public function setComment($text)
    {
        $this->_comment = (string) $text;
        return $this;
    }

    public function getComment()
    {
        return $this->_comment;
    }

    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setCreated($ts)
    {
        $this->_created = $ts;
        return $this;
    }

    public function getCreated()
    {
        return $this->_created;
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

    public function setUsername($username)
    {
        $this->_username = (string) $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function setUrl($url)
    {
        $this->_url = (string) $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->_url;
    }


}

