<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $text_username = new Zend_Form_Element_Text('username');

        $text_username->setLabel('User name')
                      ->setRequired()
                      ->addFilter('StringTrim')                                 // Zend/Filter/StringTrim.php
                      ->addValidator('NotEmpty', true)                          // Zend/Validate/NotEmpty.php
        ;

        $password_raw = new Zend_Form_Element_Password('password');
        $password_raw->setLabel('Password')
                     ->setRequired()
                     ->addValidator('NotEmpty', true)                           // Zend/Validate/NotEmpty.php
        ;

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Login')
               ->setOptions(array('class' => 'btn btn-primary'))
        ;

        $view = Zend_Layout::getMvcInstance()->getView();

        $register = new Zend_Form_Element_Button('register');
        $register->setDescription('Register')
                 ->setDecorators( array (
                     array('Description', array('tag'  => 'a',
                                                'href'  => $view->baseUrl('backoffice/admin/register'),
                                                'class' => 'btn btn-link')),
                     array(
                         array('closeInner' =>'HtmlTag'),
                         array('tag'        => 'div',
                               'closeOnly'  => true)
                     ),
                     array(
                         array('closeOuter' =>'HtmlTag'),
                         array('tag'        => 'div',
                               'closeOnly'  => true)
                     ),
                 ))
        ;

        $this->setOptions(array('class' => 'form-horizontal'))
             ->setDecorators(array('FormElements', 'Form'))
             ->setMethod('post')
             ->setAction('')
             ->addElement($text_username)
             ->addElement($password_raw )
             ->addElement($submit       )
             ->addElement($register     )
        ;
    }
    
    public function isValid($data)
    {
        $valid = parent::isValid($data);

        foreach ($this->getElements() as $element) {
            if ($element->hasErrors()) {

                $decorator = $element->getDecorator('outer');

                $options = $decorator->getOptions();
                $options['class'] .= ' error';

                $decorator->setOptions($options);
            }
        }

        return $valid;
    }

}

