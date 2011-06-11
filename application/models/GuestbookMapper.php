<?php

class Application_Model_GuestbookMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Guestbook');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_Guestbook $guestbook)
    {
        $data = array(
            'username' => $guestbook->getUsername(),
            'email'    => $guestbook->getEmail(),
            'url'      => $guestbook->getUrl(),
            'comment'  => $guestbook->getComment(),
            'created'  => date('Y-m-d H:i:s'),
        );

        if (null === ($id = $guestbook->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function find($id, Application_Model_Guestbook $guestbook)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $guestbook->setId($row->id)
                  ->setUsername($row->username)
                  ->setEmail($row->email)
                  ->setUrl($row->url)
                  ->setComment($row->comment)
                  ->setCreated($row->created);
    }

    public function fetchAll($field = 'created', $order = 'desc')
    {
        $param = trim("$field $order");
        $table = $this->getDbTable();
        $resultSet = $table->fetchAll($table->select()->order($param));
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Guestbook();
            $entry->setId($row->id)
                  ->setUsername($row->username)
                  ->setEmail($row->email)
                  ->setUrl($row->url)
                  ->setComment($row->comment)
                  ->setCreated($row->created);
            $entries[] = $entry;
        }
        return $entries;
    }
}
