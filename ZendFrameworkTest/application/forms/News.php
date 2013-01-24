<?php

class Application_Form_News extends Zend_Form
{

    public function init()
    {
        $title = new Zend_Form_Element_Text('title');

        $title
                      ->setRequired()
                      ->addFilter('StringTrim')                                 // Zend/Filter/StringTrim.php
                      ->addValidator('NotEmpty', true)                          // Zend/Validate/NotEmpty.php
        ;
        $content = new Zend_Form_Element_Textarea('content');
        $content->setLabel('Nieuws')
                ->addFilter('StringTrim')                                // Zend/Filter/StringTrim.php
                ->addValidator('NotEmpty', true)                         // Zend/Validate/NotEmpty.php
                ->setAttrib('cols', '40')
                ->setAttrib('rows', '4')
                ->setDecorators(array('ViewHelper'));
                ;
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('voeg nieuws toe')
               ->setOptions(array('class' => 'btn btn-primary'))
              ->setDecorators(array('ViewHelper'))  
        ;
        
        $this->addElement($title)
                ->addElement($content)
             
             ->addElement($submit)
             ->setOptions(array('class' => 'form-inline'))
             ->setDecorators(array('FormElements','Form'))
             ->setAction("")
             ->setMethod('post');            
    }
}
