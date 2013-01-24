<?php

class Application_Model_CommentMapper
{
    protected $_dbTable;
    
    public function __construct()
    {
        $this->_dbTable = new Application_Model_DbTable_Comments();
    }
    
    public function save(Application_Model_Comment $comment){
        $data = array('content'      => $comment->getContent(),
                      'stars'        => $comment->getStars(),
                      'addeddate'    => $comment->getAddeddate(),
                      'deleteddate'   => $comment->getDeleteddate(),
                      'modifieddate' => $comment->getModifieddate(),
                      'users_id'     => $comment->getUsers_id(),
                      'data_id'      => $comment->getData_id(),
                      'data_type'    => $comment->getData_type(),
                      
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
        $rowset = $this->_dbTable->fetchAll();
        return $rowset->toArray();
    }
    
    public function getByTypeAndId($type, $id, $count = 30, $offset = 0)
    {
        $table = $this->_dbTable;
        $db = $table->getAdapter();

//        'SELECT adm_id AS id FROM Admins'
        $select = $db
                    ->select()
                    ->from('comments')
                    ->joinInner('users','comments.users_id = users.id', 'users.username')
                    ->where('comments.data_type = ?',$type)
                    ->where('comments.data_id = ?',$id)
                    ->where('comments.deleteddate IS NULL')
                    ->order('comments.addeddate DESC');
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
    
    public function getCount($count = 30, $offset = 0)
    {
        $table = $this->_dbTable;
        $db = $table->getAdapter();

//        'SELECT adm_id AS id FROM Admins'
        $select = $db
                    ->select()
                    ->from('comments')
                    ->joinInner('users','comments.users_id = users.id', 'users.username')
                    ->where('comments.deleteddate IS NULL')
                    ->order('comments.addeddate DESC');
       if ($row = $db->query($select)) {
          return array_slice($row->fetchAll(), $offset, $count);
          
       }

       throw new Exception('Record could not be found');
    }

}

