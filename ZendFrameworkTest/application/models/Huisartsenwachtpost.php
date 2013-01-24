<?php

class Application_Model_Huisartsenwachtpost
{
    public function __construct(array $values = null) {
        foreach($values as $key => $value) {
            $setter = 'set' . ucfirst($key);
            $this->{$setter}($value);
        }
    }
    
    protected $_huisartsenwachtpost_id;   
    protected $_long;   
    protected $_lat;    
    protected $_distance;   
    protected $_id;   
    protected $_fid;   
    protected $_naam_wacht; 
    protected $_adres;
    protected $_postcode;
    protected $_gemeente;
    protected $_open_op;
    protected $_addeddate;
    
    public function getHuisartsenwachtpost_id() { return $this->_huisartsenwachtpost_id; }
    public function setHuisartsenwachtpost_id($huisartsenwachtpost_id) { $this->_huisartsenwachtpost_id = $huisartsenwachtpost_id; }
    
    public function getLong() { return $this->_long; }
    public function setLong($long) { $this->_long = $long; }
    
    public function getLat() { return $this->_lat; }
    public function setLat($lat) { $this->_lat = $lat; }
    
    public function getDistance() { return $this->_distance; }
    public function setDistance($distance) { $this->_distance = $distance; }
    
    public function getFid() { return $this->_fid; }
    public function setFid($fid) { $this->_fid = $fid; }
    
    public function getNaam_wacht() { return $this->_naam_wacht; }
    public function setNaam_wacht($naam_wacht) { $this->_naam_wacht = $naam_wacht; }
    
    public function getAdres() { return $this->_adres; }
    public function setAdres($adres) { $this->_adres = $adres; }
    
    public function getPostcode() { return $this->_postcode; }
    public function setPostcode($postcode) { $this->_postcode = $postcode; }
    
    public function getGemeente() { return $this->_gemeente; }
    public function setGemeente($gemeente) { $this->_gemeente = $gemeente; }
    
    public function getOpen_op() { return $this->_open_op; }
    public function setOpen_op($open_op) { $this->_open_op = $open_op; }

    public function getAddeddate() { return $this->_addeddate; }
    public function setAddeddate($addeddate) { $this->_addeddate = $addeddate; }
    
    public function getId() { return $this->_id; }
    public function setId($id) { $this->_id = $id; }


}

