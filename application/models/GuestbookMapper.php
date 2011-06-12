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

        if (null === ($id = $guestbook->getGid())) {
            unset($data['gid']);
            return $this->getDbTable()->insert($data);
        } else {
            return $this->getDbTable()->update($data, array('gid = ?' => $id));
        }
    }

    public function find($id, Application_Model_Guestbook $guestbook)
    {
        $result = $this->getDbTable()->find($gid);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $guestbook->setId($row->gid)
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
        $select = $table->select(Zend_Db_Table::SELECT_WITH_FROM_PART)
                        ->setIntegrityCheck(false)
                        ->joinLeft('images', 'images.commentid = guestbook.gid')
                        ->order($param);
        $resultSet = $table->fetchAll($select);
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Guestbook();
            if ('' !== $row->iid) {
                $image = new Application_Model_Images();
                $image->setIid($row->iid)
                      ->setFilename($row->filename)
                      ->setWidth($row->width)
                      ->setHeght($row->height)
                      ->setResizedwidth($row->resizedwidth)
                      ->setResizedheight($row->resizedheight);
                $comment['image'] = $image;
            }
            $entry->setGid($row->gid)
                  ->setUsername($row->username)
                  ->setEmail($row->email)
                  ->setUrl($row->url)
                  ->setComment($row->comment)
                  ->setCreated($row->created);
            $comment['entry'] = $entry;
            $entries[] = $comment;
        }
        return $entries;
    }
}
