<?php

class Application_Model_News
{
    public function __construct(array $values = null) {
        foreach($values as $key => $value) {
            $setter = 'set' . ucfirst($key);
            $this->{$setter}($value);
        }
    }
    
    protected $_id;   
    protected $_content;   
    protected $_title;    
    protected $_addeddate;   
    protected $_deleteddate;   
    protected $_modifieddate;   
    protected $_users_id;  
    
    public function getId() { return $this->_id; }
    public function setId($id) { $this->_id = $id; }
    
    public function getContent() { return $this->_content; }
    public function setContent($content) { $this->_content = $content; }
    
    public function getTitle() { return $this->_title; }
    public function setTitle($title) { $this->_title = $title; }
    
    public function getAddeddate() { return $this->_addeddate; }
    public function setAddeddate($addeddate) { $this->_addeddate = $addeddate; }
    
    public function getDeleteddate() { return $this->_deleteddate; }
    public function setDeleteddate($deleteddate) { $this->_deleteddate = $deleteddate; }
    
    public function getModifieddate() { return $this->_modifieddate; }
    public function setModifieddate($modifieddate) { $this->_modifieddate = $modifieddate; }
   
    public function getUsers_id() { return $this->_users_id; }
    public function setUsers_id($users_id) { $this->_users_id = $users_id; }

}

