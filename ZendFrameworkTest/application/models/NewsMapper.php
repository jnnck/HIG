<?php

class Application_Model_NewsMapper
{
    protected $_dbTable;
    
    public function __construct()
    {
        $this->_dbTable = new Application_Model_DbTable_News();
    }
    
    public function save(Application_Model_News $comment){
        $data = array('content'      => $comment->getContent(),
                      'title'        => $comment->getTitle(),
                      'addeddate'    => $comment->getAddeddate(),
                      'deleteddate'   => $comment->getDeleteddate(),
                      'modifieddate' => $comment->getModifieddate(),
                      'users_id'     => $comment->getUsers_id(),
                      
                      
        );
        
        if (null === $comment->getId()) {
            $this->_dbTable->insert($data);
        } else {     
            Zend_Debug::dump($data);
            $where = 'id='.$comment->getId();
            $this->_dbTable->update($data, $where);
        }
    }
    
    public function fetchAllArrays()
    {
        $table = $this->_dbTable;
        $db = $table->getAdapter();

//        'SELECT adm_id AS id FROM Admins'
        $select = $db
                    ->select()
                    ->from('news')
                    ->joinInner('users','news.users_id = users.id', 'users.username')
                    ->where('news.deleteddate IS NULL')
                    ->order('news.addeddate DESC');
       if ($row = $db->query($select)) {
          return $row->fetchAll();
          
       }

       throw new Exception('Record could not be found');
    }
    
    
    public function getById($id = null)
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

}

