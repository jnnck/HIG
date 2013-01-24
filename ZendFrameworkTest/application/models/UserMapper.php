<?php

class Application_Model_UserMapper
{
    protected $_dbTable;
    
    public function __construct()
    {
        $this->_dbTable = new Application_Model_DbTable_Users();
    }
    
    public function save(Application_Model_User $user){
        $data = array('firstname'        => $user->getFirstname(),
                      'lastname'         => $user->getLastname(),
                      'username'         => $user->getUsername(),
                      'mail'             => $user->getMail(),
                      'password'         => $user->getPassword(),
                      'role'             => $user->getRole(),
                      'activationcode'   => $user->getActivationcode(),
                      'registerdate'     => $user->getRegisterdate(),
                      'activationdate'   => $user->getActivationdate(),
                      'modificationdate' => $user->getModificationdate(),
                      'deleteddate'      => $user->getDeleteddate(),
        );
        
        if (null === $user->getId()) {
            $this->_dbTable->insert($data);
        } else {     
            Zend_Debug::dump($data);
            $where = 'id='.$user->getId();
            $this->_dbTable->update($data, $where);
        }
    }
    
    public function getAll()
    {
        $rowset = $this->_dbTable->fetchAll();
        return $rowset;
    }
    
    public function getById($id)
    {
        $table = $this->_dbTable;

//        'SELECT adm_id AS id FROM Admins'
        $select = $table->select()
                        ->from($table)
                        ->where('id = :id')
                        ->bind(array(':id' => $id))
       ;
       if ($row = $table->fetchRow($select)) {
           return $row->toArray();
       }

       throw new Exception('Record could not be found');
    }
    
    public function getByUsername($username)
    {
        $table = $this->_dbTable;

//        'SELECT adm_id AS id FROM Admins'
        $select = $table->select()
                        ->from($table)
                        ->where('username = :username')
                        ->bind(array(':username' => $username))
       ;
       if ($row = $table->fetchRow($select)) {
           return $row->toArray();
       }

       throw new Exception('Record could not be found');
    }

}

