<?php

class IndexController extends Zend_Controller_Action
{
    private $_form;
    private $_guestbook;

    public function init()
    {
        /* Initialize action controller here */
        $this->_guestbook = new Application_Model_GuestbookMapper();
        $field = $this->_getParam('field');
        $order = $this->_getParam('order');
        $sort = $this->_getParam('sort');
        if (!empty($sort)) {
            list($field, $order) = explode('_', $sort);
            //$this->view->entries = $this->_guestbook->fetchAll($field, $order);
                        // Get all posts and give them to paginator
            $paginator = Zend_Paginator::factory(
                $this->_guestbook->fetchAll($field, $order)
            );
        } else {
            //$this->view->entries = $this->_guestbook->fetchAll();
            // Get all posts and give them to paginator
            $paginator = Zend_Paginator::factory(
                $this->_guestbook->fetchAll()
            );
        }
        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $this->view->paginator = $paginator;
        $this->_form = new Application_Form_Guestbook();
    }

    public function indexAction()
    {
        // action body
        $this->view->form = $this->_form;
    }

    public function signAction()
    {
        // action body
        if ($this->getRequest()->isPost()) {
            $request = $this->getRequest()->getPost();
            if ($this->_form->isValid($request)) {
                $comment = new Application_Model_Guestbook($this->_form->getValues());
                $mapper  = new Application_Model_GuestbookMapper();
                $mapper->save($comment);
                $this->_helper->redirector('index', 'index');
            } else {
                $this->_form->populate($request);
            }
            $this->view->form = $this->_form;
            $this->render('index');
        }
    }


}



