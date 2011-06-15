<?php

class IndexController extends Zend_Controller_Action
{
    private $_form;
    private $_guestbook;
    private $_maxCommentssPerPage;

    public function init()
    {
        $this->_form = new Application_Form_Guestbook();
        $this->view->orderForm = new Application_Form_Order();
        $this->_helper->ajaxContext->addActionContext('index', 'html')
                                   ->initContext();
        // Set max pages per page in guestbook
        $this->_maxCommentsPerPage = Zend_Registry::get('config')->guestbook
                                                                 ->global
                                                                 ->maxcommentsperpage;
        $this->_guestbook = new Application_Model_GuestbookMapper();
        $sort = $this->_getParam('sort');
        if (!empty($sort)) {
            list($field, $order) = explode('_', $sort);
            $allPosts = $this->_guestbook->fetchAll($field, $order);
        } else {
            $allPosts = $this->_guestbook->fetchAll();
        }
        // Get all posts and give them to paginator
        $paginator = Zend_Paginator::factory($allPosts);

        $paginator->setItemCountPerPage($this->_maxCommentsPerPage);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $this->view->paginator = $paginator;
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
                $bbcode->addMarkup(
                    'pre',
                    Zend_Markup_Renderer_RendererAbstract::TYPE_REPLACE,
                    array(
                        'start' => '<pre class="brush: php;">',
                        'end'   => '</pre>',
                        'group' => 'inline'
                    )
                );
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



