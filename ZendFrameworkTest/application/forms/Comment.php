<?php

class Application_Form_Comment extends Zend_Form
{

    public function init()
    {
        $stars = new Zend_Form_Element_Select('stars');
        $stars->addMultiOptions(array(
                                    0 => 'Geef een score',
                                    1 => '1/5',
                                    2 => '2/5',
                                    3 => '3/5',
                                    4 => '4/5',
                                    5 => '5/5',
                                     ))
               ->setDecorators(array('ViewHelper'));
        
        $content = new Zend_Form_Element_Textarea('content');
        $content
                       ->addFilter('StringTrim')                                // Zend/Filter/StringTrim.php
                       ->addValidator('NotEmpty', true)                         // Zend/Validate/NotEmpty.php
                       ->setAttrib('cols', '40')
                        ->setAttrib('rows', '4')
        ->setDecorators(array('ViewHelper'));
                ;
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('voeg review to')
               ->setOptions(array('class' => 'btn btn-primary'))
              ->setDecorators(array('ViewHelper'))  
        ;
        
        $this->addElement($content)
             ->addElement($stars)
             ->addElement($submit)
             ->setOptions(array('class' => 'form-inline'))
             ->setDecorators(array('FormElements','Form'))
             ->setAction("")
             ->setMethod('post');            
    }
}
