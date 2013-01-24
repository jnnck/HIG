<?php

class Backoffice_DataController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
//        $settingsmapper = new Application_Model_SettingMapper();
//        $settings = $settingsmapper->fetchAll();
//        $newsettings = array(); 
//        $apotheek = array(); 
//        $ziekenhuis = array(); 
//        $dierenarts = array(); 
//        $huisarts = array(); 
//        $huisartswp = array(); 
//        
//        foreach ($settings as $setting) {
//            
//            switch ($setting["type"]) {
//                case "apotheken":
//                    $mapper = new Application_Model_ApotheekMapper();
//                    $posibleversionsapotheek = $mapper->getAllVersions();
//                    $apotheek["type"]=$setting["type"];
//                    $apotheek["options"]=$posibleversionsapotheek;
//                    break;
//                case "ziekenhuizen":
//                    $mapper = new Application_Model_ZiekenhuisMapper();
//                    $posibleversionsziekenhuis = $mapper->getAllVersions();  
//                    $ziekenhuis["type"]=$setting["type"];
//                    $ziekenhuis["options"]=$posibleversionsziekenhuis;
//                    break;
//                case "dierenartsen":
//                    $mapper = new Application_Model_DierenartsMapper();
//                    $posibleversionsdierenarts = $mapper->getAllVersions();
//                    $dierenarts["type"]=$setting["type"];
//                    $dierenarts["options"]=$posibleversionsdierenarts;
//                    break;
//                case "huisartsen":
//                    $mapper = new Application_Model_HuisartsenwachtpostMapper();
//                    $posibleversionshuisarts = $mapper->getAllVersions();  
//                    $huisarts["type"]=$setting["type"];
//                    $huisarts["options"]=$posibleversionshuisarts;
//                    break;
//                case "huisartsenwachtposten":
//                    $mapper = new Application_Model_HuisartsenwachtpostMapper();
//                    $posibleversionshuisartswp = $mapper->getAllVersions();
//                    $huisartswp["type"]=$setting["type"];
//                    $huisartswp["options"]=$posibleversionshuisartswp;
//                    break;               
//            }
//            array_push($newsettings, $apotheek, $ziekenhuis, $dierenarts, $huisarts, $huisartswp);
//            var_dump($newsettings);
//        }
//        
//        die();
        $apmapper = new Application_Model_ApotheekMapper();
        $apversion = $apmapper->getAllVersions()["addeddate"];
        $this->view->apotheek = $apversion;
        
        $hamapper = new Application_Model_HuisartsMapper();
        $haversion = $hamapper->getAllVersions()["addeddate"];
        $this->view->huisarts = $haversion;
        
        $damapper = new Application_Model_DierenartsMapper();
        $daversion = $damapper->getAllVersions()["addeddate"];
        $this->view->dierenarts = $daversion;
        
        $hawpmapper = new Application_Model_HuisartsenwachtpostMapper();
        $hawpversion = $hawpmapper->getAllVersions()["addeddate"];
        $this->view->huisartsenwachtpost = $hawpversion;
        
        $zhmapper = new Application_Model_ZiekenhuisMapper();
        $zhversion = $zhmapper->getAllVersions()["addeddate"];
        $this->view->ziekenhuis = $zhversion;
    }

    public function updateapothekenAction()
    {
        $myJsonInput = file_get_contents('http://data.appsforghent.be/poi/apotheken.json');
        $result = Zend_Json::decode( $myJsonInput);
        $currentDateTime = date("Y-m-d H:i:s");
        $mapper = new Application_Model_ApotheekMapper();
        if($mapper->truncate()){
        foreach ($result['apotheken'] as $apotheekData) {
            $apotheek = new Application_Model_Apotheek($apotheekData);
            $apotheek->setAddeddate($currentDateTime);
            $mapper = new Application_Model_ApotheekMapper();
            $mapper->save($apotheek);
        }}
        return $this->redirect('backoffice/data/');
    }

    public function updatehuisartsenAction()
    {
        $myJsonInput = file_get_contents('http://data.appsforghent.be/poi/huisartsen.json');
        $result = Zend_Json::decode( $myJsonInput);
        $currentDateTime = date("Y-m-d H:i:s");
        $mapper = new Application_Model_HuisartsMapper();
        foreach ($result['huisartsen'] as $huisartsData) {
            $huisarts = new Application_Model_Huisarts($huisartsData);
            $huisarts->setAddeddate($currentDateTime);
            $mapper = new Application_Model_HuisartsMapper();
            $mapper->save($huisarts);
        }
        return $this->redirect('backoffice/data/');
    }
    
    public function updatedierenartsenAction()
    {
        $myJsonInput = file_get_contents('http://data.appsforghent.be/poi/dierenartsen.json');
        $result = Zend_Json::decode( $myJsonInput);
        $currentDateTime = date("Y-m-d H:i:s");
        $mapper = new Application_Model_DierenartsMapper();
        if($mapper->truncate()){
        foreach ($result['dierenartsen'] as $dierenartsData) {
            $dierenarts = new Application_Model_Dierenarts($dierenartsData);
            $dierenarts->setAddeddate($currentDateTime);
            $mapper = new Application_Model_DierenartsMapper();
            $mapper->save($dierenarts);
        }}
        return $this->redirect('backoffice/data/');
    }
    
    public function updatehuisartsenwachtpostenAction()
    {
        $myJsonInput = file_get_contents('http://data.appsforghent.be/poi/huisartsenwachtposten.json');
        $result = Zend_Json::decode( $myJsonInput);
        $currentDateTime = date("Y-m-d H:i:s");
        $mapper = new Application_Model_HuisartsenwachtpostMapper();
        if($mapper->truncate()){
        foreach ($result['huisartsenwachtposten'] as $ziekenhuisData) {
            $ziekenhuis = new Application_Model_Huisartsenwachtpost($ziekenhuisData);
            $ziekenhuis->setAddeddate($currentDateTime);
            $mapper = new Application_Model_HuisartsenwachtpostMapper();
            $mapper->save($ziekenhuis);
        }}
        return $this->redirect('backoffice/data/');
    }
    
    public function updateziekenhuizenAction()
    {
        $myJsonInput = file_get_contents('http://data.appsforghent.be/poi/ziekenhuizen.json');
        $result = Zend_Json::decode( $myJsonInput);
        $currentDateTime = date("Y-m-d H:i:s");
        $mapper = new Application_Model_ZiekenhuisMapper();
        if($mapper->truncate()){
        foreach ($result['ziekenhuizen'] as $ziekenhuisData) {
            $ziekenhuis = new Application_Model_Ziekenhuis($ziekenhuisData);
            $ziekenhuis->setAddeddate($currentDateTime);
            $mapper = new Application_Model_ZiekenhuisMapper();
            $mapper->save($ziekenhuis);
        }}
        return $this->redirect('backoffice/data/');
    }


}





