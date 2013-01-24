<?php

class Backoffice_NewsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $newsmapper = new Application_Model_NewsMapper();
        
        $newsform = new Application_Form_News();
        
        $request = $this->getRequest();

        if ($request->isPost() ) {
            if ($newsform->isValid( $request->getPost() )) {
                $values = $newsform->getValues();
                $news = new Application_Model_News($values);
                $news->setAddeddate(date("Y-m-d H:i:s"));   
                $news->setUsers_id(Zend_Auth::getInstance()->getIdentity()["id"]);
                $newsmapper->save($news);
                $this->view->message = "<div class='alert alert-success'>Het nieuws is toegevoegd!<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
            }
        }
        $newsform = new Application_Form_News();
        $this->view->form = $newsform;
        
        $this->view->news = $newsmapper->fetchAllArrays();
    }
    
    public function deleteAction()
    {
        $mapper = new Application_Model_NewsMapper();
        $comment = new Application_Model_News($mapper->getById(Zend_Controller_Front::getInstance()->getRequest()->getParam( 'id' )));
        
        $comment->setDeleteddate(date("Y-m-d H:i:s"));
        $mapper->save($comment);
        
        return $this->redirect('backoffice/news/');
    }


}

