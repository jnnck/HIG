<?php

class Application_Model_HuisartsMapper
{
    protected $_dbTable;
    
    public function __construct()
    {
        $this->_dbTable = new Application_Model_DbTable_Huisartsen();
    }
    
    public function save(Application_Model_Huisarts $huisarts){
        $data = array('long'        => $huisarts->getLong(),
                      'lat'         => $huisarts->getLat(),
                      'distance'    => $huisarts->getDistance(),
                      'id'          => $huisarts->getId(),
                      'fid'         => $huisarts->getFid(),
                      'idnr09'      => $huisarts->getIdnr09(),
                      'naam'        => $huisarts->getNaam(),
                      'voornaam'    => $huisarts->getVoornaam(),
                      'adres'       => $huisarts->getAdres(),
                      'postcode'    => $huisarts->getPostcode(),
                      'gemeente'    => $huisarts->getGemeente(),
                      'praktijk'    => $huisarts->getPraktijk(),
                      'geslacht'    => $huisarts->getGeslacht(),
                      'addeddate'   => $huisarts->getAddeddate(),
        );
        
        if (null === $huisarts->getHuisarts_id()) {
            $this->_dbTable->insert($data);
        } else {     
            Zend_Debug::dump($data);
            $where = 'huisarts_id='.$huisarts->getHuisarts_id();
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

