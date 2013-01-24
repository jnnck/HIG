<?php

class PlacesController extends Zend_Controller_Action
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
    
    public function apotheekAction()
    {
        $model = new Application_Model_ApotheekMapper();
        $commentmapper = new Application_Model_CommentMapper();
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'id' );
        $name = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'name' );
        if($id != null){
            $apotheek = $model->getById($id);
        } elseif ($name !=null) {
            
            $apotheek = $model->getByName($name);
        }
        
        
        $this->view->apotheek = $apotheek;
        
        $this->view->role = Zend_Auth::getInstance()->getIdentity()["role"];
        
        $form = new Application_Form_Comment();
        
        $request = $this->getRequest();

        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();

                $comment = new Application_Model_Comment($values);
                $comment->setData_id($id);
                $comment->setData_type("apotheek");
                $comment->setAddeddate(date("Y-m-d H:i:s"));   
                $comment->setUsers_id(Zend_Auth::getInstance()->getIdentity()["id"]);
                $commentmapper->save($comment);
                $this->view->message = "<div class='alert alert-success'>Bedankt! Uw recentie werd aan de apotheek toegevoegd!<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
            }
        }
        if($this->view->role == 'user' || $this->view->role == 'admin'){
            $form = new Application_Form_Comment();
            $this->view->form = $form;
        }
        $this->view->comments = $commentmapper->getByTypeAndId('apotheek', $id);
        
    }
    
    public function ziekenhuisAction()
    {
        $model = new Application_Model_ZiekenhuisMapper();
        $commentmapper = new Application_Model_CommentMapper();
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'id' );
        $ziekenhuis = $model->getById($id);
        
        $this->view->ziekenhuis = $ziekenhuis;
        
        $this->view->role = Zend_Auth::getInstance()->getIdentity()["role"];
        
        $form = new Application_Form_Comment();
        
        $request = $this->getRequest();

        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();

                $comment = new Application_Model_Comment($values);
                $comment->setData_id($id);
                $comment->setData_type("ziekenhuis");
                $comment->setAddeddate(date("Y-m-d H:i:s"));   
                $comment->setUsers_id(Zend_Auth::getInstance()->getIdentity()["id"]);
                $commentmapper->save($comment);
                $this->view->message = "<div class='alert alert-success'>Bedankt! Uw recentie werd aan het ziekenhuis toegevoegd!<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
            }
        }
        if($this->view->role == 'user' || $this->view->role == 'admin'){
            $form = new Application_Form_Comment();
            $this->view->form = $form;
        }
        $this->view->comments = $commentmapper->getByTypeAndId('ziekenhuis', $id);
        
    }
    
    public function dierenartsAction()
    {
        $model = new Application_Model_DierenartsMapper();
        $commentmapper = new Application_Model_CommentMapper();
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'id' );
        $dierenarts = $model->getById($id);
        
        $this->view->dierenarts = $dierenarts;
        
        $this->view->role = Zend_Auth::getInstance()->getIdentity()["role"];
        
        $form = new Application_Form_Comment();
        
        $request = $this->getRequest();

        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();

                $comment = new Application_Model_Comment($values);
                $comment->setData_id($id);
                $comment->setData_type("dierenarts");
                $comment->setAddeddate(date("Y-m-d H:i:s"));   
                $comment->setUsers_id(Zend_Auth::getInstance()->getIdentity()["id"]);
                $commentmapper->save($comment);
                $this->view->message = "<div class='alert alert-success'>Bedankt! Uw recentie werd aan de dierenarts toegevoegd!<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
            }
        }
        if($this->view->role == 'user' || $this->view->role == 'admin'){
            $form = new Application_Form_Comment();
            $this->view->form = $form;
        }
        $this->view->comments = $commentmapper->getByTypeAndId('dierenarts', $id);
        
    }
    
    public function huisartsenwachtpostAction()
    {
        $model = new Application_Model_HuisartsenwachtpostMapper();
        $commentmapper = new Application_Model_CommentMapper();
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'id' );
        $name = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'name' );
        $huisartsenwachtpost = $model->getById($id);
        
        $this->view->huisartsenwachtpost = $huisartsenwachtpost;
        
        $this->view->role = Zend_Auth::getInstance()->getIdentity()["role"];
        
        $form = new Application_Form_Comment();
        
        $request = $this->getRequest();

        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();

                $comment = new Application_Model_Comment($values);
                $comment->setData_id($id);
                $comment->setData_type("huisartsenwachtpost");
                $comment->setAddeddate(date("Y-m-d H:i:s"));   
                $comment->setUsers_id(Zend_Auth::getInstance()->getIdentity()["id"]);
                $commentmapper->save($comment);
                $this->view->message = "<div class='alert alert-success'>Bedankt! Uw recentie werd aan de huisartsenwachtpost toegevoegd!<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
            }
        }
        if($this->view->role == 'user' || $this->view->role == 'admin'){
            $form = new Application_Form_Comment();
            $this->view->form = $form;
        }
        $this->view->comments = $commentmapper->getByTypeAndId('huisartsenwachtpost', $id);
        
    }
    
    public function huisartsAction()
    {
        $model = new Application_Model_HuisartsMapper();
        $commentmapper = new Application_Model_CommentMapper();
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'id' );
        $huisarts = $model->getById($id);
        
        $this->view->huisarts = $huisarts;
        
        $this->view->role = Zend_Auth::getInstance()->getIdentity()["role"];
        
        $form = new Application_Form_Comment();
        
        $request = $this->getRequest();

        if ($request->isPost() ) {
            if ($form->isValid( $request->getPost() )) {
                $values = $form->getValues();

                $comment = new Application_Model_Comment($values);
                $comment->setData_id($id);
                $comment->setData_type("huisarts");
                $comment->setAddeddate(date("Y-m-d H:i:s"));   
                $comment->setUsers_id(Zend_Auth::getInstance()->getIdentity()["id"]);
                $commentmapper->save($comment);
                $this->view->message = "<div class='alert alert-success'>Bedankt! Uw recentie werd aan de huisarts toegevoegd!<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
            }
        }
        if($this->view->role == 'user' || $this->view->role == 'admin'){
            $form = new Application_Form_Comment();
            $this->view->form = $form;
        }
        $this->view->comments = $commentmapper->getByTypeAndId('huisarts', $id);
        
    }
    
    public function closeAction()
    {
        
    }

}

