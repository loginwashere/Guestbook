<?php

class Application_Model_GuestbookMapper extends Application_Model_GeustbookMapperAbstract
{
    protected $_dbTableClass = 'Application_Model_DbTable_Guestbook';

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
            return $this->getDbTable()->insert($data);
        } else {
            return $this->getDbTable()->update($data, array('id = ?' => $id));
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
