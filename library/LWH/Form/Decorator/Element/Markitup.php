<?php
/**
 * @author Savchenko Dmitry <login.was.here@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php
 * @package guestbook
 */
class LWH_Form_Decorator_Element_Markitup extends Zend_Form_Decorator_Abstract
{
    public $helper = 'FormMarkitup';

    public function render($content)
    {
        $element = $this->getElement();
        $attribs = $element->getAttribs();
        $options = $this->getOptions();
        $view = $element->getView();
        $helper = $this->helper;
        $view->$helper($attribs, $options);
        return $content;
    }
}