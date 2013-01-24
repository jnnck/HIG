<?php

class DataController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    public function allAction()
    {
       $type = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'type' );
       switch ($type) {
            case "apotheken":
                $mapper = new Application_Model_ApotheekMapper();
                break;
            case "ziekenhuizen":
                $mapper = new Application_Model_ZiekenhuisMapper();
                break;
            case "dierenartsen":
                $mapper = new Application_Model_DierenartsMapper();
                break;
            case "huisartsen":
                $mapper = new Application_Model_HuisartsMapper();
                break;
            case "huisartsenwachtposten":
                $mapper = new Application_Model_HuisartsenwachtpostMapper();
                break;
       }
       
        echo Zend_Json::encode(array($type => $mapper->fetchAllArrays()));	
        exit();
    
    }
    
    public function closeAction()
    {
       $type = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'type' );
       $max = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'max' );
       $lat = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'lat' );
       $long = Zend_Controller_Front::getInstance()->getRequest()->getParam( 'long' );
       $max = ($max == null)? 3 : $max;
       $lat = ($lat == null)? 51.054398 : $lat;
       $long = ($long == null)? 3.725224 : $long;
       
       
       switch ($type) {
            case "apotheken":
                $mapper = new Application_Model_ApotheekMapper();
                break;
            case "ziekenhuizen":
                $mapper = new Application_Model_ZiekenhuisMapper();
                break;
            case "dierenartsen":
                $mapper = new Application_Model_DierenartsMapper();
                break;
            case "huisartsen":
                $mapper = new Application_Model_HuisartsMapper();
                break;
            case "huisartsenwachtposten":
                $mapper = new Application_Model_HuisartsenwachtpostMapper();
                break;
       }
       $items = array(); 
       $all = $mapper->fetchAllArrays();
       foreach ($all as $item) {
         
        $itemlong = $item["long"];
        $itemlat = $item["lat"];
           
        $pi80 = M_PI / 180;
	$lat1 = $itemlat*$pi80;
	$lng1 = $itemlong*$pi80;
	$lat2 = $lat*$pi80;
	$lng2 = $long*$pi80;
 
	$r = 6372.797; // mean radius of Earth in km
	$dlat = $lat2 - $lat1;
	$dlng = $lng2 - $lng1;
	$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
	$km = $r * $c;
        
        $item["afstand"] = $km;
        $items[] = $item; 
       }
       foreach ($items as $key => $row) {
           $afstand[$key]  = $row['afstand'];
       }
       array_multisort($afstand, SORT_ASC, $items);
   
        echo Zend_Json::encode(array($type => array_slice($items, 0, $max)));	
        exit();
    
    }


}

