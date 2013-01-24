<?php

class AccountController extends Zend_Controller_Action
{

    protected $_auth = null;

    public function init()
    {
        /* Initialize action controller here */
        $this->_auth = Zend_Auth::getInstance();
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        if ($this->_auth->hasIdentity() ) {
            return $this->redirect('index/index/');
        }
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
                    
                    //check als gedelete of niet actief
                    if($admin_data->activationdate == null){
                        $this->_auth->clearIdentity();
                        return $this->redirect('account/login/message/accountinactive');  
                    }
                    if($admin_data->deleteddate != null){
                        $this->_auth->clearIdentity();
                        return $this->redirect('account/login/message/accountdeleted');  
                    }

                    $this->_auth->getStorage()->write(array('role' => $admin_data->role,
                                                            'id'   => (int) $admin_data->id,
                                              ));
                    return $this->redirect('index/index/'.$admin_data->id);
                } else {
                    // Unable to authenticate
                    return $this->redirect('account/login/failed');
                }
            }
        }
        
        $message = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'message' );
        switch ($message) {
            case "accountdeleted":
                $view->message = "<span class='label label-important'>Uw account lijkt gedeletet, contacteerd de beheerder</span><br />";
                break;
            case "accountinactive":
                $view->message = "<span class='label label-important'>Gelieve u account te activeren, indien dit niet lukt contacteer de beheerder</span><br />";
                break;
            case "regsucces":
                $view->message = "<span class='label label-success'>U bent succesvol geregistreert, gelieve uw mail te checken om u account te activeren</span><br />";
                break;
            case "activationsucces":
                $view->message = "<span class='label label-success'>U account is nu geactiveerd, u kan inloggen</span><br />";
                break;
            case "wrongactivationcode":
                $view->message = "<span class='label label-important'>u gebruikte een ongeldige activatiecode</span><br />";
                break;
            case "alreadyactivated":
                $view->message = "<span class='label label-important'>dit account lijkt al geactiveerd, probeer in te loggen</span><br />";
                break;
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
                
                $registerdate = date("Y-m-d");
                $activationcode = sha1(mt_rand(10000,99999).time().$values["mail"]);

                $user = new Application_Model_User($values);
                $user->setRole('user');
                $user->setRegisterdate($registerdate);
                $user->setActivationcode($activationcode);
                
                $userMapper = new Application_Model_UserMapper();
                $userMapper->save($user);
                
                $html = "please activate your account. <br />
                         <br />
                         <a href='http://localhost:8888/ZendFrameworkTest/public/account/activate/username/".$user->getUsername()."/activationcode/".$activationcode."'>http://localhost:8888/ZendFrameworkTest/public/account/activate/username/".$user->getUsername()."/activationcode/".$activationcode."</a>";
                
                $mail = new Zend_Mail();
                $mail->setBodyHtml($html);
                $mail->setFrom('noreply@hulpingent.be', 'Hulp In Gent');
                $mail->addTo($user->getMail(), $user->getFirstname().' '.$user->getLastname());
                $mail->setSubject('please activate your account at Hulp in Gent');
                //YOU NO WORK ON LOCALHOST?
                //$mail->send();
                
                    
                return $this->redirect("account/login/message/regsucces/username/".$user->getUsername()."/activationcode/".$activationcode);
                
            }
        }

        
        $view->form = $form;
    }

    public function logoutAction()
    {
        $this->_auth->clearIdentity();

        return $this->redirect('account/login');
    }
    
    public function activateAction()
    {
        $username = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'username' );
        $activationcode = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'activationcode' );
        
        if($username != null && $activationcode != null){
            $userMapper = new Application_Model_UserMapper();
            $userData = $userMapper->getByUsername($username);
            $user = new Application_Model_User($userData);
            
            if($user->getActivationdate() == null){
                if($user->getActivationcode() == $activationcode){
                    //activate user
                    $activationdate = date("Y-m-d");
                    $user->setActivationdate($activationdate);
                    $userMapper->save($user);     
                    return $this->redirect('account/login/message/activationsucces');
                }// user not yet activated but wrong code
                return $this->redirect('account/login/message/wrongactivationcode');
            }//user already activated
            return $this->redirect('account/login/message/alreadyactivated');
        }

       
    }
    
    public function editAction()
    {
        $form = new Application_Form_Register();

        $view = $this->view;
        $view->title = 'Edit Profile';


        $auth = Zend_Auth::getInstance();
        $id = $auth->getStorage()->read()['id']; // PHP 5.4 feature

        $userMapper = new Application_Model_UserMapper();
        $userdata = $userMapper->getById($id);

        $form->populate($userdata);

        $request = $this->getRequest();

        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();
                $user = new Application_Model_User($userdata);
                $user->setFirstname($values["firstname"]);
                $user->setLastname($values["lastname"]);
                $user->setMail($values["mail"]);
                $user->setUsername($values["username"]);
                $user->setPassword($values["password"]);
                $userMapper->save($user);
                $view->message = "<span class='label label-success'>U profiel werd geupdatet</span><br />";
            }
        }
        $view->form = $form;
    }
    


}









