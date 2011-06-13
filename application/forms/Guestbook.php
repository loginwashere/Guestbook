<?php

class Application_Form_Guestbook extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        // Set the method for the display form to POST
        $this->setMethod('post')
             ->setAction('/index/sign')
             ->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        // Add an username element
        $this->addElement(
            'text',
            'username',
            array(
                'label'      => 'Your name:',
                'class'      => 'required',
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
                'class'      => 'required',
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

        // Add [link] button element
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
        // Add [code] button element
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
        // Add [italic] button element
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
        // Add [strike] button element
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
        // Add [strong] button element
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
        // Add [sup] button element
        $this->addElement(
            'button',
            'sup',
            array(
                'label' => '[sup]',
                'decorators' => array(
                    'ViewHelper',
                ),
            )
        );
        // Add [sub] button element
        $this->addElement(
            'button',
            'sub',
            array(
                'label' => '[sub]',
                'decorators' => array(
                    'ViewHelper',
                ),
            )
        );
        // Add [h1] button element
        $this->addElement(
            'button',
            'h1',
            array(
                'label' => '[h1]',
                'decorators' => array(
                    'ViewHelper',
                ),
            )
        );
        // Add [img] button element
        $this->addElement(
            'button',
            'img',
            array(
                'label' => '[img]',
                'decorators' => array(
                    'ViewHelper',
                ),
            )
        );
        // Add all buttons to group to display them in one row
        $this->addDisplayGroup(
            array(
                'link',
                'code',
                'italic',
                'strike',
                'strong',
                'sup',
                'sub',
                'h1',
                'img',
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
                'class'      => 'required',
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

