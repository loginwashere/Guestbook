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

    /**
     * Enter description here ...
     */
    public function _initRoutes()
    {
        $frontController = Zend_Controller_Front::getInstance();
        $router = $frontController->getRouter();
        $route = new Zend_Controller_Router_Route(
            'page/:page/',
            array(
                /*'page'       => 1,*/
                'action'     => 'index',
                'controller' => 'Index'
            ),
            array('page' => '\d+')
        );
        $router->addRoute('index', $route);
    }


}

