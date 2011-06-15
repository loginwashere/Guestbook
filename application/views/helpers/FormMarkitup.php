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

        //Включаем jQuery хелпер, для этого
        //должно быть активирована библиотека ZendX
        /*$view->jQuery()
             ->enable()
             ->setVersion('1.5');*/

        //Подключаем нужные нам стили
        $view->jQuery()
             ->addJavascriptFile($view->baseUrl('/markitup/jquery.markitup.js'))
             ->addJavascriptFile($view->baseUrl('/markitup/sets/bbcode/set.js'))
             ->addStylesheet($view->baseUrl('/markitup/skins/simple/style.css'))
             ->addStylesheet($view->baseUrl('/markitup/sets/bbcode/style.css'));

         $id = $attribs['id'];
         $js = 'jQuery("#'.$id.'").markItUp(mySettings)';
         $this->view->jQuery()->addOnLoad($js);
    }
}
