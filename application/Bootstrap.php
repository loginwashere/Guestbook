<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
     * Enter description here ...
     */
    protected function _initPlaceholders()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');

        $view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
        $view->jQuery()
             ->enable()
             ->setVersion('1');

        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

        $view->doctype('HTML5');

        $view->headMeta()->setCharset('UTF-8');

        // Set the initial title and separator:
        $view->headTitle("Don't panic")
             ->setSeparator(' :: ');

        // Set the initial stylesheet:
        $view->headLink()->prependStylesheet($view->baseUrl() . '/css/global.css');

        //set page title;
        $view->title = "Don't panic";
    }

    protected function _initConfig()
    {
        $config = new Zend_Config($this->getOptions());
        Zend_Registry::set('config', $config);
        return $config;
    }



}

