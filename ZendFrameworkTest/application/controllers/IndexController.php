<?php

class IndexController extends Zend_Controller_Action
{

    protected $_auth = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->_auth = Zend_Auth::getInstance();
    }

    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        $this->view->role = $auth->hasIdentity() ? $auth->getStorage()->read()['role'] : JannickV_Acl_Acl::GUEST; // PHP 5.4
        
        $newsmapper = new Application_Model_NewsMapper();
        $this->view->news = $newsmapper->fetchAllArrays();
        
        $commentmapper = new Application_Model_CommentMapper();
        $this->view->comments = $commentmapper->getCount(5);
       
    }

    public function loginAction()
    {
        $form = new Application_Form_Login();
        
        $view = $this->view;
        $view->title = 'Login';
        
        $request = $this->getRequest();
        
        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();

                $user = new Application_Model_User($values);

                $adapter = new JannickV_Auth_Adapter_User(  $user->getUsername(),
                                                            $user->getPassword());

                $this->_auth->authenticate($adapter);

                if ($this->_auth->hasIdentity() ) {
                    $admin_data = $adapter->getResultRowObject();

                    $this->_auth->getStorage()->write(array('role' => $admin_data->role,
                                                            'id'   => (int) $admin_data->id,
                                              ));
                    return $this->redirect('index/login/'.$admin_data->id);
                } else {
                    // Unable to authenticate
                    return $this->redirect('backoffice');
                }
            }
        }
        
        $view->form = $form;
    }

    public function registerAction()
    {
        $form = new Application_Form_Register();
        
        $view = $this->view;
        $view->title = 'Login';
        
        $request = $this->getRequest();
        
        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();

                $user = new Application_Model_User($values);
                
                $userMapper = new Application_Model_UserMapper();
                $userMapper->save($user);

                $adapter = new JannickV_Auth_Adapter_User(  $user->getUsername(),
                                                            $user->getPassword());

                $this->_auth->authenticate($adapter);

                if ($this->_auth->hasIdentity() ) {
                    $admin_data = $adapter->getResultRowObject();

                    $this->_auth->getStorage()->write(array('role' => 'USER',
                                                            'id'   => (int) $admin_data->id,
                                              ));
                    return $this->redirect('index/index/'.$auth->getStorage()->read()['id']);
                } else {
                    // Unable to authenticate
                    return $this->redirect('index/login');
                }
            }
        }
        
        $view->form = $form;
    }

    public function logoutAction()
    {
        $this->_auth->clearIdentity();

        return $this->redirect('index/login');
    }
    
    public function placesAction()
    {
       
    }
    
    public function getjsonAction()
    {
       $type = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'type' );
       switch ($type) {
            case "apotheken":
                $mapper = new Application_Model_ApotheekMapper();
                break;
            case "ziekenhuizen":
                $mapper = new Application_Model_ZiekenhuisMapper();
                break;
            case "dierenartsen":
                $mapper = new Application_Model_DierenartsMapper();
                break;
            case "huisartsen":
                $mapper = new Application_Model_HuisartsMapper();
                break;
            case "huisartsenwachtposten":
                $mapper = new Application_Model_HuisartsenwachtpostMapper();
                break;
       }
       
        echo Zend_Json::encode(array($type => $mapper->fetchAllArrays()));	
        exit();
    
    }
    
    public function contactAction()
    {
        $form = new Application_Form_Contact();
        
        $view = $this->view;
        
        $request = $this->getRequest();
        
        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();
 
                $mail = new Zend_Mail();
                $mail->setBodyHtml($values["content"]);
                $mail->setFrom($values['mail'], 'Hulp In Gent');
                $mail->addTo('info@jannickvandaele.be', 'Jannick Vandaele');
                $mail->setSubject('mailtje');
                //YOU NO WORK ON LOCALHOST?
                //$mail->send();
                
                    
                return $this->redirect("account/login/message/regsucces/username/".$user->getUsername()."/activationcode/".$activationcode);
                
            }
        }

        
        $view->form = $form;
          
    }


}







