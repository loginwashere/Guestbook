<?php

class Application_Form_Guestbook extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        // Set the method for the display form to POST
        $this->setMethod('post')
             ->setAction('/index/sign');

        // Add an email element
        $this->addElement(
            'text',
            'email',
            array(
                'label'      => 'Your email address:',
                'required'   => true,
                'filters'    => array('StringTrim'),
                'validators' => array('EmailAddress')
            )
        );

        // Add the comment element
        $this->addElement(
            'textarea',
            'comment',
            array(
                'label'      => 'Please Comment:',
                'required'   => true,
                'validators' => array(
                    array(
                        'validator' => 'StringLength',
                        'options' => array(0, 20)
                    )
                )
            )
        );

        // Add ReCaptcha
        $recaptchaService = new Zend_Service_ReCaptcha(
            '6LcFIMUSAAAAAJqyQ_H7N496MFEdeDTQJ_iR_U8u',
            '6LcFIMUSAAAAAI5bl7APIPmzLarkf7HGJQMJkE4R'
        );
        // then set the Recaptcha adapter
        $adapter = new Zend_Captcha_ReCaptcha();
        $adapter->setService($recaptchaService);

        // then set  the captcha element to use the ReCaptcha Adapter
        $recaptcha = new Zend_Form_Element_Captcha(
            'recaptcha',
            array(
                'label' => "Are you a human?",
                'captcha' => $adapter
            )
        );
        //Then only add the element to the form:
        $this->addElement($recaptcha);

        // Add the submit button
        $this->addElement(
            'submit',
            'submit',
            array(
                'ignore'   => true,
                'label'    => 'Sign Guestbook',
            )
        );

        // And finally add some CSRF protection
        $this->addElement(
            'hash',
            'csrf',
            array('ignore' => true)
        );
    }


}

