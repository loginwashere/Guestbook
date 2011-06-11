<?php

class Application_Model_Images extends Application_Model_GeustbookAbstract
{
    protected $_id;
    protected $_filename;
    protected $_width;
    protected $_height;
    protected $_resizedwidth;
    protected $_resizedheight;
    protected $_commentid;

    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setFilename($filename)
    {
        $this->_filename = (string) $filename;
        return $this;
    }

    public function getFilename()
    {
        return $this->_filename;
    }

    public function setWidth($width)
    {
        $this->_width = (int) $width;
        return $this;
    }

    public function getWidth()
    {
        return $this->_width;
    }

    public function setHeght($height)
    {
        $this->_height = (int) $height;
        return $this;
    }

    public function getHeight()
    {
        return $this->_height;
    }

    public function setResizedwidth($resizedwidth)
    {
        $this->_resizedwidth = (int) $resizedwidth;
        return $this;
    }

    public function getResizedwidth()
    {
        return $this->_resizedwidth;
    }

    public function setResizedheight($resizedheight)
    {
        $this->_resizedheight = (int) $resizedheight;
        return $this;
    }

    public function getResizedheight()
    {
        return $this->_resizedheight;
    }

    public function setCommentid($commentid)
    {
        $this->_commentid = (int) $commentid;
        return $this;
    }

    public function getCommentid()
    {
        return $this->_commentid;
    }
}

