<?php

class Application_Model_HuisartsenwachtpostMapper
{
    protected $_dbTable;
    
    public function __construct()
    {
        $this->_dbTable = new Application_Model_DbTable_Huisartsenwachtposten();
    }
    
    public function save(Application_Model_Huisartsenwachtpost $huisartsenwachtpost){
        $data = array('long'        => $huisartsenwachtpost->getLong(),
                      'lat'         => $huisartsenwachtpost->getLat(),
                      'distance'    => $huisartsenwachtpost->getDistance(),
                      'id'          => $huisartsenwachtpost->getId(),
                      'fid'         => $huisartsenwachtpost->getFid(),
                      'naam_wacht'  => $huisartsenwachtpost->getNaam_wacht(),
                      'adres'       => $huisartsenwachtpost->getAdres(),
                      'postcode'    => $huisartsenwachtpost->getPostcode(),
                      'gemeente'    => $huisartsenwachtpost->getGemeente(),
                      'open_op'     => $huisartsenwachtpost->getOpen_op(),
                      'addeddate'   => $huisartsenwachtpost->getAddeddate(),
        );
        
        if (null === $huisartsenwachtpost->getHuisartsenwachtpost_id()) {
            $this->_dbTable->insert($data);
        } else {     
            Zend_Debug::dump($data);
            $where = 'huisartsenwachtpost_id='.$huisartsenwachtpost->getHuisartsenwachtpost_id();
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

