<?php
/**
 * @author Savchenko Dmitry <login.was.here@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php
 * @package guestbook
 */
class Application_Form_Order extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('get')
             ->setAction('/index/index');

        $interestArray = array(
            'username_asc'  => 'Username ASC',
            'username_desc' => 'Username DESC',
            'email_asc'     => 'Email ASC',
            'email_desc'    => 'Email DESC',
            'created_asc'   => 'Date ASC',
            'created_desc'  => 'Date DESC',
        );

        $firstInterest = new Zend_Form_Element_Select(
            'sort',
            array(
                'required' => 'true',
                'value' => 'created_desc',
                'multiOptions' => $interestArray,
                'decorators' => array(
                    'ViewHelper',
                ),
            )
        );
        $this->addElement($firstInterest);

        // Add the submit button
        $this->addElement(
            'submit',
            'orderSubmit',
            array(
                'ignore'   => true,
                'label'    => 'Sort',
                'decorators' => array(
                    'ViewHelper',
                ),
            )
        );
        $this->addDisplayGroup(
            array(
                'sort',
                'orderSubmit',
            ),
            'submitButtons',
            array(
                'decorators' => array(
                    'FormElements',
                    array(
                        'HtmlTag',
                        array(
                            'tag' => 'div',
                            'class' => 'element'
                        )
                    ),
                ),
            )
        );

        // And finally add some CSRF protection
        $this->addElement(
            'hash',
            'orderCsrf',
            array('ignore' => true)
        );
    }


}

