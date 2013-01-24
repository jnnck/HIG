<?php

class Backoffice_UsersController extends Zend_Controller_Action
{

    protected $_auth = null;

    public function init()
    {
        $this->_auth = Zend_Auth::getInstance();
    }

    public function indexAction()
    {
        $form = new Application_Form_Users();
        $view = $this->view;
        $view->form = $form;
        
        $result = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'result' );
        switch ($result) {
            case "succes":
                $view->message = "<span class='label label-success'>De user is succesvol geupdate</span><br />";
                break;
            case "error":
                $view->message = "<span class='label label-important'>Er ging iets mis bij het updaten... Gelieve het nog eens opnieuw te proberen</span><br />";
                break;
        }
        
        
    }

    public function makeuserAction()
    {
        $request = $this->getRequest();
        $form = new Application_Form_Users();
        
        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();
                $userMapper = new Application_Model_UserMapper();
                
                $data = $userMapper->getById($values["id"]);
                
                $user = new Application_Model_User($data);
                $user->setRole('user');
                
                $userMapper->save($user);
                
                                          
                    return $this->redirect('backoffice/users/index/result/succes');
                } else {
                    // Unable to authenticate
                    return $this->redirect('backoffice/users/index/result/error');
                }
            
        }
    }

    public function makeadminAction()
    {
        $request = $this->getRequest();
        $form = new Application_Form_Users();
        
        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();
                $userMapper = new Application_Model_UserMapper();
                
                $data = $userMapper->getById($values["id"]);
                
                $user = new Application_Model_User($data);
                $user->setRole('admin');
                
                $userMapper->save($user);
                                          
                    return $this->redirect('backoffice/users/index/succes');
                } else {
                    // Unable to authenticate
                    return $this->redirect('backoffice/users/index/failed');
                }
            
        }
    }

    public function deleteuserAction()
    {
        $request = $this->getRequest();
        $form = new Application_Form_Users();
        
        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();
                $userMapper = new Application_Model_UserMapper();
                
                $data = $userMapper->getById($values["id"]);
                
                $user = new Application_Model_User($data);
                $user->setDeleteddate(date("Y-m-d"));
                
                $userMapper->save($user);
                
                                          
                    return $this->redirect('backoffice/users/index/result/succes');
                } else {
                    // Unable to authenticate
                    return $this->redirect('backoffice/users/index/result/error');
                }
            
        }
    }

    public function activateuserAction()
    {
        $request = $this->getRequest();
        $form = new Application_Form_Users();
        
        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();
                $userMapper = new Application_Model_UserMapper();
                
                $data = $userMapper->getById($values["id"]);
                
                $user = new Application_Model_User($data);
                $user->setActivationdate(date("Y-m-d"));
                
                $userMapper->save($user);
                
                                          
                    return $this->redirect('backoffice/users/index/result/succes');
                } else {
                    // Unable to authenticate
                    return $this->redirect('backoffice/users/index/result/error');
                }
            
        }
    }


}















