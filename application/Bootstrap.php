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

        $view->doctype('HTML5');

        $view->headMeta()->setCharset('UTF-8');

        // Set the initial title and separator:
        $view->headTitle("Don't panic")
             ->setSeparator(' :: ');

        // Set the initial stylesheet:
        $view->headLink()->prependStylesheet('/css/global.css');

        //set page title;
        $view->title = "Don't panic";
    }


}

