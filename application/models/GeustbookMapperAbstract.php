<?php
/**
 * @author Savchenko Dmitry <login.was.here@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php
 * @package guestbook
 */
/**
 * @author Savchenko Dmitry <login.was.here@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php
 * @package guestbook
 */
class Application_Model_GeustbookMapperAbstract
{
    protected $_dbTable;
    protected $_dbTableClass;

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
            $this->setDbTable($this->_dbTableClass);
        }
        return $this->_dbTable;
    }

}

