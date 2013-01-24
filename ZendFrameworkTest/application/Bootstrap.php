<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initViewHelpers()
    {
        $this->bootstrap('layout'); // Make a _initLayout()
        $view = $this->getResource('layout')->getView();

        // To make $view->baseUrl() available in this bootstrap
        $front = $this->getResource('frontController');
        $front->setRequest(new Zend_Controller_Request_Http());

        $view->doctype('HTML5'); // http://framework.zend.com/manual/en/zend.view.helpers.html#zend.view.helpers.initial.doctype
        $view->headMeta()
             ->setCharset('utf-8')
             ->appendName('viewport', 'width=device-width, initial-scale=1')
        ;

        $view->headTitle($view->title, 'PREPEND') // Zend_View_Helper_HeadTitle
             ->setDefaultAttachOrder('PREPEND')
             ->setSeparator(' ← ')
        ;

        $view->headLink() // Zend_View_Helper_HeadLink
             ->appendStylesheet($view->baseUrl('css/dcsns_light.css'))
             ->appendStylesheet($view->baseUrl('css/bootstrap.min.css'))
             ->appendStylesheet($view->baseUrl('css/bootstrap-responsive.min.css'))
             ->appendStylesheet($view->baseUrl('css/main.css'))
        ;
        
        $view->headScript() // Zend_View_Helper_HeadLink
             ->appendFile($view->baseUrl('js/vendor/modernizr-2.6.2.min.js'))
             ->appendFile('http://maps.googleapis.com/maps/api/js?key=AIzaSyCBrey8ryXEytozQb_zYU-SWpe6A25F2FA&sensor=true')
             ->appendFile('http://code.jquery.com/jquery-latest.js')
        ;

        $view->inlineScript()
             
             
             ->appendFile($view->baseUrl('js/vendor/bootstrap.min.js')) 
             ->appendFile($view->baseUrl('js/vendor/jquery.social.stream.1.4.3.min.js'))
             ->appendFile($view->baseUrl('js/main.js'))
             
             
        ;
    }
    
    protected function _initViewHelperNavigation()
    {
        $yaml = APPLICATION_PATH . '/configs/navigation.yml';
        $pages = new Zend_Config_Yaml($yaml);
        $navigation = new Zend_Navigation($pages);

        $auth = Zend_Auth::getInstance();
        
        //RESET AUTH
//        $auth->getStorage()->write(array('role' => 'admin',
//                                                            'id'   => 1,
//                                              ));
        $role = $auth->hasIdentity() ? $auth->getStorage()->read()['role'] : JannickV_Acl_Acl::GUEST; // PHP 5.4!

        $this->bootstrap('layout'); // Make a _initLayout()
        $view = $this->getResource('layout')->getView();
        $view->navigation($navigation)
             ->setAcl(new Jannickv_Acl_Acl())
             ->setRole($role)
        ;
    
        $view->navigation()->menu()
                           ->setPartial('partials/menu.phtml')

                           ->setUlClass('nav')
        ;
        
    }


}



