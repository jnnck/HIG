<?php

class Application_Model_Setting
{
    public function __construct(array $values = null) {
        foreach($values as $key => $value) {
            $setter = 'set' . ucfirst($key);
            $this->{$setter}($value);
        }
    }
    
    protected $_id;   
    protected $_type;   
    protected $_url;    
    protected $_version;   

    public function getid() { return $this->_id; }
    public function setid($id) { $this->_id = $id; }
    
    public function gettype() { return $this->_type; }
    public function settype($type) { $this->_type = $type; }
    
    public function geturl() { return $this->_url; }
    public function seturl($lat) { $this->_url = $url; }
    
    public function getversion() { return $this->_version; }
    public function setversion($version) { $this->_version = $version; }
}

