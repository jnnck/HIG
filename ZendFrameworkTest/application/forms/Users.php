<?php

class Application_Form_Users extends Zend_Form
{

    public function init()
    {
        
        $user = new Application_Model_UserMapper();
        $users = new Zend_Form_Element_Select('id');
        
        $users->addMultiOption(0, 'Select User...')
                ->setDecorators(array('ViewHelper'));
        
        foreach ($user->getAll('user') as $user) {
            $users->addMultiOption( $user['id'], $user['username']);
        }
        
        $actions = new Zend_Form_Element_Select('actions');
        $actions->addMultiOptions(array(
                                   0   => 'Select Action...',
                                   'makeuser'     => 'Geef Role: User',
                                   'makeadmin'    => 'Geef Role: Admin',
                                   'deleteuser'   => 'Delete user',
                                   'activateuser' => 'Activate user',
                                       ))
               ->setDecorators(array('ViewHelper'));
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('update user')
               ->setOptions(array('class' => 'btn btn-primary'))
              ->setDecorators(array('ViewHelper'))  
        ;
        
        $this->addElement($users)
             ->addElement($actions)
             ->addElement($submit)
             ->setOptions(array('class' => 'form-inline'))
             ->setDecorators(array('FormElements','Form'))
             ->setAction("users/")
             ->setMethod('post')
             ->setAttrib('id', 'usersform');
          
        
        
        
    }


}

//class Application_Form_Element_UserSelect extends Zend_Form_Element_Select {
//    //put your code here
//    public function _init(){
////        $users = new Application_Model_User();
////        $this->addMultiOption(0, 'Please select...');
//        $this->addMultiOption('he', 'he');
//        
////        foreach ($users->getAll('user') as $user) {
////            $this->addMultiOption($user['id'], $user['username']);
////        }
//    }
//}
