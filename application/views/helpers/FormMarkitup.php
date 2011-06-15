<?php
class Zend_View_Helper_FormMarkitup extends Zend_View_Helper_Abstract
{

    protected $_options = array();

    public function getOptions()
    {
        return $this->_options;
    }

    public function FormMarkitup($attribs, $options = null)
    {
        if ($options AND is_array($options)) {
            $this->setOptions($options);
        }

        $view = $this->view;

        //Подключаем нужные нам стили
        $view->headLink()->appendStylesheet($view->baseUrl() . '/markitup/skins/simple/style.css')
                         ->appendStylesheet($view->baseUrl() . '/markitup/sets/bbcode/style.css');

        $view->headScript()
             ->appendFile($view->baseUrl() . '/markitup/jquery.markitup.js')
             ->appendFile($view->baseUrl() . '/markitup/sets/bbcode/set.js');
         $id = $attribs['id'];
         $js = 'jQuery("#'.$id.'").markItUp(mySettings)';
         $this->view->jQuery()->addOnLoad($js);
    }
}
