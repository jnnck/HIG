<?php

class Application_Form_Contact extends Zend_Form
{

    public function init()
    {
        $mail = new Zend_Form_Element_Text('title');

        $mail->setRequired()
             ->setLabel("Emailadres")
             ->addFilter('StringTrim')                                 // Zend/Filter/StringTrim.php
             ->addValidator('NotEmpty', true)                          // Zend/Validate/NotEmpty.php
             ->addValidator('EmailAddress', true)
                ->removeDecorator('HtmlTag')
         ;
        
        $content = new Zend_Form_Element_Textarea('content');
        $content->addFilter('StringTrim')                                // Zend/Filter/StringTrim.php
                ->addValidator('NotEmpty', true)                         // Zend/Validate/NotEmpty.php
                ->setAttrib('cols', '40')
                ->setAttrib('rows', '4')
                ->setLabel("Bericht")
                ->removeDecorator('HtmlTag')
        ;
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('verzend')
               ->setOptions(array('class' => 'btn btn-primary'))
              ->setDecorators(array('ViewHelper'))  
        ;
        
        $this->addElement($mail)
             ->addElement($content)
             ->addElement($submit)
             ->setOptions(array('class' => 'form-inline'))
             ->setDecorators(array('FormElements','Form'))
             ->setAction("")
             ->setMethod('post');            
    }
}
