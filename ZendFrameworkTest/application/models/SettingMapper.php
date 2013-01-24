<?php

class Application_Model_SettingMapper
{
    protected $_dbTable;
    
    public function __construct()
    {
        $this->_dbTable = new Application_Model_DbTable_Settings();
    }
    
    public function update(Application_Model_Dierenarts $dierenarts){
        $data = array('id'       => $dierenarts->getLong(),
                      'type'     => $dierenarts->getLat(),
                      'url'      => $dierenarts->getDistance(),
                      'version'  => $dierenarts->getId(),
        );
             
        $where = 'dierenarts_id='.$dierenarts->getDierenarts_id();
        $this->_dbTable->update($data, $where);
        
    }
    
    public function fetchAll()
    {
        $rowset = $this->_dbTable->fetchAll();
        return $rowset->toArray();;
    }
    
    public function getAllVersions($type){
        switch ($type) {
            case "apotheken":
                $table = new Application_Model_DbTable_Settings();
                break;
            case "ziekenhuizen":
                $table = new Application_Model_DbTable_Settings();
                break;
            case "dierenartsen":
                $table = new Application_Model_DbTable_Settings();
                break;
            case "huisartsen":
                $table = new Application_Model_DbTable_Settings();
                break;
            case "huisarsenwachtposten":
                $table = new Application_Model_DbTable_Settings();
                break;
       }
       

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

