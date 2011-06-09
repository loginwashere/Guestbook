<?php

class IndexController extends Zend_Controller_Action
{
    private $_form;

    public function init()
    {
        /* Initialize action controller here */
        $this->_form = new Application_Form_Guestbook();
    }

    public function indexAction()
    {
        // action body
        $guestbook = new Application_Model_GuestbookMapper();
        $this->view->entries = $guestbook->fetchAll();
        $this->view->form = $this->_form;
    }

    public function signAction()
    {
        // action body
        $request = $this->getRequest();
        if ($this->getRequest()->isPost()) {
            if ($this->_form->isValid($request->getPost())) {
                $comment = new Application_Model_Guestbook($this->_form->getValues());
                $mapper  = new Application_Model_GuestbookMapper();
                $mapper->save($comment);
                return $this->_helper->redirector('index');
            }
        }

        $this->view->form = $this->_form;
    }


}



