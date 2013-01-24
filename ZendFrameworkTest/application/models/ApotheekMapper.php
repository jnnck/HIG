<?php

class Application_Model_ApotheekMapper
{
    protected $_dbTable;
    
    public function __construct()
    {
        $this->_dbTable = new Application_Model_DbTable_Apotheken();
    }
    
    public function save(Application_Model_Apotheek $apotheek){
        $data = array('long'        => $apotheek->getLong(),
                      'lat'         => $apotheek->getLat(),
                      'distance'    => $apotheek->getDistance(),
                      'id'          => $apotheek->getId(),
                      'fid'         => $apotheek->getFid(),
                      'naam'        => $apotheek->getNaam(),
                      'adres'       => $apotheek->getAdres(),
                      'postcode'    => $apotheek->getPostcode(),
                      'gemeente'    => $apotheek->getGemeente(),
                      'addeddate'   => $apotheek->getAddeddate(),
        );
        
        if (null === $apotheek->getApotheek_id()) {
            $this->_dbTable->insert($data);
        } else {     
            Zend_Debug::dump($data);
            $where = 'apotheek_id='.$apotheek->getApotheek_id();
            $this->_dbTable->update($data, $where);
        }
    }
    
    public function fetchAllArrays()
    {
        $rowset = $this->_dbTable->fetchAll();
        return $rowset->toArray();;
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
    
    public function getByName($name)
    {
        if(empty($name)){
            throw new Exception("No name specified");
        }
        
        $table = $this->_dbTable;

//        'SELECT adm_id AS id FROM Admins'
        $select = $table->select()
                        ->from($table)
                        ->where('naam = ?', $name);
       ;
       if ($row = $table->fetchRow($select)) {
           return $row->toArray();
       }

       throw new Exception('Record could not be found');
    }
    
    public function getAllVersions(){
        $table = $this->_dbTable;
        $select = $table->select()
                        ->from($table, 'addeddate')
                        ->group('addeddate');
        if ($row = $table->fetchRow($select)) {
           return $row->toArray();
        }
        
    }
    
    public function truncate(){
        $table = $this->_dbTable;
        if ($this->_dbTable->getAdapter()->query('TRUNCATE TABLE '.$this->_dbTable->info(Zend_Db_Table::NAME))) {
           return true;
        }
        
    }

}

