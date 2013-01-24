<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
        $text_fistname = new Zend_Form_Element_Text('firstname');
        $text_fistname->setLabel('First name')
                       ->addFilter('StringTrim')                                // Zend/Filter/StringTrim.php
                       ->addValidator('NotEmpty', true)                         // Zend/Validate/NotEmpty.php
        ;

        $text_lastname = new Zend_Form_Element_Text('lastname');
        $text_lastname->setLabel('Last name')
                        ->addFilter('StringTrim')                               // Zend/Filter/StringTrim.php
                        ->addValidator('NotEmpty', true)
        ;

        $text_mail = new Zend_Form_Element_Text('mail');
        $text_mail->setLabel('Email address')
                   ->addFilter('StringTrim')                                    // Zend/Filter/StringTrim.php
                   ->addValidator('EmailAddress', true)                         // Zend/Validate/EmailAddress.php
                   ->addValidator('NotEmpty', true)
        ;

        $text_username = new Zend_Form_Element_Text('username');
        $text_username->setLabel('User name')
                      ->setRequired()
                      ->addFilter('StringTrim')                                 // Zend/Filter/StringTrim.php
                      ->addValidator('NotEmpty', true)
        ;

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password')
                     ->setRequired()
                     ->addValidator('NotEmpty', true)
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Registreren')
               ->setOptions(array('class' => 'btn btn-primary'))
               ->setDecorators(array('ViewHelper',
                   array(
                      array('inner'     => 'HtmlTag'),
                      array('tag'       => 'div',
                            'openOnly'  => true,
                            'class'     => 'controls'),
                   ),
                   array(
                       array('outer'    => 'HtmlTag'),
                       array('tag'      => 'div',
                             'openOnly' => true,
                             'class'    => 'control-group'),
                   ),
               ))
        ;

        //$view = Zend_Layout::getMvcInstance()->getView();

        $this->setOptions(array('class' => 'form-vertical'))
             ->setDecorators(array('FormElements', 'Form'))
             ->setMethod('post')
             ->setAction('')
             ->addElement($text_fistname )
             ->addElement($text_lastname)
             ->addElement($text_mail     )
             ->addElement($text_username  )
             ->addElement($password   )
             ->addElement($submit         )
        ;
    }


}

