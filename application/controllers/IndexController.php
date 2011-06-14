<?php

class IndexController extends Zend_Controller_Action
{
    private $_form;
    private $_guestbook;
    private $_maxCommentssPerPage;

    public function init()
    {
        $this->_helper->ajaxContext->addActionContext('index', 'html')
                                   ->initContext();
        // Set max pages per page in guestbook
        $this->_maxCommentsPerPage = Zend_Registry::get('config')->guestbook
                                                                 ->global
                                                                 ->maxcommentsperpage;
        /* Initialize action controller here */
        $this->_guestbook = new Application_Model_GuestbookMapper();
        $field = $this->_getParam('field');
        $order = $this->_getParam('order');
        $sort = $this->_getParam('sort');
        if (!empty($sort)) {
            list($field, $order) = explode('_', $sort);
            // Get all posts and give them to paginator
            $paginator = Zend_Paginator::factory(
                $this->_guestbook->fetchAll($field, $order)
            );
        } else {
            // Get all posts and give them to paginator
            $paginator = Zend_Paginator::factory(
                $this->_guestbook->fetchAll()
            );
        }
        $paginator->setItemCountPerPage($this->_maxCommentsPerPage);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $this->view->paginator = $paginator;
        $this->_form = new Application_Form_Guestbook();
        $this->view->orderForm = new Application_Form_Order();
    }

    public function indexAction()
    {
        $this->view->form = $this->_form;
    }

    public function signAction()
    {
        if ($this->getRequest()->isPost()) {
            $request = $this->getRequest()->getPost();
            if ($this->_form->isValid($request)) {
                $commentData['username'] = $this->_form->getValue('username');
                $commentData['email']    = $this->_form->getValue('email');
                $commentData['url']      = $this->_form->getValue('url');
                $bbcode = Zend_Markup::factory('Bbcode', 'Html');
                $commentData['comment']  = $bbcode->render($this->_form->getValue('comment'));
                $comment = new Application_Model_Guestbook($commentData);
                $imageData['commentid'] = $this->_guestbook->save($comment);

                if ($this->_form->image->isUploaded()) {
                    $image = new Application_Model_Images($imageData);
                    $imageMapper = new Application_Model_ImagesMapper();
                    $imageMapper->save($image);
                }
                $csrf = $this->_form->getElement("csrf");
                $csrf->initCsrfToken();
                $this->view->csrf = $csrf->getSession()->hash;

                $this->_helper->redirector('index', 'index');
            } else {
                $this->_form->populate($request);
            }
            $this->view->form = $this->_form;
            $this->render('index');
        }
    }



}



