<?php

class Backoffice_CommentsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function deleteAction()
    {
        $mapper = new Application_Model_CommentMapper();
        $comment = new Application_Model_Comment($mapper->getById(Zend_Controller_Front::getInstance()->getRequest()->getParam( 'id' )));
        
        $comment->setDeleteddate(date("Y-m-d H:i:s"));
        $mapper->save($comment);
        
        $this->view->message = "<div class='alert alert-success'>De reactie is weg si!<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
                           
    }
}





