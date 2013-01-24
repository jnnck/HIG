<?php

class Application_Model_DierenartsMapper
{
    protected $_dbTable;
    
    public function __construct()
    {
        $this->_dbTable = new Application_Model_DbTable_Dierenartsen();
    }
    
    public function save(Application_Model_Dierenarts $dierenarts){
        $data = array('long'        => $dierenarts->getLong(),
                      'lat'         => $dierenarts->getLat(),
                      'distance'    => $dierenarts->getDistance(),
                      'id'          => $dierenarts->getId(),
                      'fid'         => $dierenarts->getFid(),
                      'naam'        => $dierenarts->getNaam(),
                      'huisnr'      => $dierenarts->getHuisnr(),
                      'adres'       => $dierenarts->getAdres(),
                      'postcode'    => $dierenarts->getPostcode(),
                      'gemeente'    => $dierenarts->getGemeente(),
                      'addeddate'   => $dierenarts->getAddeddate(),
        );
        
        if (null === $dierenarts->getDierenarts_id()) {
            $this->_dbTable->insert($data);
        } else {     
            Zend_Debug::dump($data);
            $where = 'dierenarts_id='.$dierenarts->getDierenarts_id();
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

