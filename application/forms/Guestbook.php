<?php

class Application_Form_Guestbook extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        // Set the method for the display form to POST
        $this->setMethod('post')
             ->setAction('/index/sign');

        // Add an username element
        $this->addElement(
            'text',
            'username',
            array(
                'label'      => 'Your name:',
                'required'   => true,
                'filters'    => array('StringTrim'),
                'validators' => array('NotEmpty')
            )
        );

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

        // Add an url element
        $this->addElement(
            'text',
            'url',
            array(
                'label'      => 'Your url:',
                'required'   => false,
                'filters'    => array(
                    'StripTags',
                    'StringTrim'
                ),
                'validators' => array('NotEmpty')
            )
        );

        $this->addElement(
            'button',
            'link',
            array(
                'label' => '[link]',
                'decorators' => array(
                    'ViewHelper',
                ),
            )
        );
        $this->addElement(
            'button',
            'code',
            array(
                'label' => '[code]',
                'decorators' => array(
                    'ViewHelper',
                ),
            )
        );
        $this->addElement(
            'button',
            'italic',
            array(
                'label' => '[italic]',
                'decorators' => array(
                    'ViewHelper',
                ),
            )
        );
        $this->addElement(
            'button',
            'strike',
            array(
                'label' => '[strike]',
                'decorators' => array(
                    'ViewHelper',
                ),
            )
        );
        $this->addElement(
            'button',
            'strong',
            array(
                'label' => '[strong]',
                'decorators' => array(
                    'ViewHelper',
                ),
            )
        );

        $this->addDisplayGroup(
            array(
                'link',
                'code',
                'italic',
                'strike',
                'strong',
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

        // Add the comment element
        $this->addElement(
            'textarea',
            'comment',
            array(
                'label'      => 'Please Comment:',
                'required'   => true,
                'filters'    => array('StringTrim'),
                'validators' => array(
                    array(
                        'validator' => 'StringLength',
                        'options' => array(0, 1000)
                    )
                )
            )
        );

        // Image upload
        // Add a image uploading field
        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Upload an image:')
              ->setRequired(false)
              /*->addValidator('IsImage', false)*/
              ->addValidator('Count', false, 1)
              ->addValidator('Size', false, 1024000)
              ->addValidator('Extension', false, 'jpeg,jpg,png,gif')
              ->addValidator(
                  'ImageSize',
                  false,
                  array(
                     'minwidth'  => 10,
                     'maxwidth'  => 4000,
                     'minheight' => 10,
                     'maxheight' => 3000
                  )
              )
              ->addFilter('Rename', '../public/images/');
        $this->addElement($image);

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

