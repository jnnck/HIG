<?php

class Application_Model_ZiekenhuisMapper
{
    protected $_dbTable;
    
    public function __construct()
    {
        $this->_dbTable = new Application_Model_DbTable_Ziekenhuizen();
    }
    
    public function save(Application_Model_Ziekenhuis $ziekenhuis){
        $data = array('long'        => $ziekenhuis->getLong(),
                      'lat'         => $ziekenhuis->getLat(),
                      'distance'    => $ziekenhuis->getDistance(),
                      'id'          => $ziekenhuis->getId(),
                      'fid'         => $ziekenhuis->getFid(),
                      'naam'        => $ziekenhuis->getNaam(),
                      'straat'      => $ziekenhuis->getStraat(),
                      'nr'          => $ziekenhuis->getNr(),
                      'postcode'    => $ziekenhuis->getPostcode(),
                      'gemeente'    => $ziekenhuis->getGemeente(),
                      'objectid'    => $ziekenhuis->getObjectid(),
                      'area'        => $ziekenhuis->getArea(),
                      'len'         => $ziekenhuis->getLen(),
                      'addeddate'   => $ziekenhuis->getAddeddate(),
        );
        
        if (null === $ziekenhuis->getZiekenhuis_id()) {
            $this->_dbTable->insert($data);
        } else {     
            Zend_Debug::dump($data);
            $where = 'ziekenhuis_id='.$ziekenhuis->getZiekenhuis_id();
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

