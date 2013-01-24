<?php

class Application_Model_Comment
{
    public function __construct(array $values = null) {
        foreach($values as $key => $value) {
            $setter = 'set' . ucfirst($key);
            $this->{$setter}($value);
        }
    }
    
    protected $_id;   
    protected $_content;   
    protected $_stars;    
    protected $_addeddate;   
    protected $_deleteddate;   
    protected $_modifieddate;   
    protected $_users_id;  
    protected $_data_id;
    protected $_data_type;  
    
    public function getId() { return $this->_id; }
    public function setId($id) { $this->_id = $id; }
    
    public function getContent() { return $this->_content; }
    public function setContent($content) { $this->_content = $content; }
    
    public function getStars() { return $this->_stars; }
    public function setStars($stars) { $this->_stars = $stars; }
    
    public function getAddeddate() { return $this->_addeddate; }
    public function setAddeddate($addeddate) { $this->_addeddate = $addeddate; }
    
    public function getDeleteddate() { return $this->_deleteddate; }
    public function setDeleteddate($deleteddate) { $this->_deleteddate = $deleteddate; }
    
    public function getModifieddate() { return $this->_modifieddate; }
    public function setModifieddate($modifieddate) { $this->_modifieddate = $modifieddate; }
   
    public function getUsers_id() { return $this->_users_id; }
    public function setUsers_id($users_id) { $this->_users_id = $users_id; }
    
    public function getData_id() { return $this->_data_id; }
    public function setData_id($data_id) { $this->_data_id = $data_id; }
    
    public function getData_type() { return $this->_data_type; }
    public function setData_type($data_type) { $this->_data_type = $data_type; }
   
}

