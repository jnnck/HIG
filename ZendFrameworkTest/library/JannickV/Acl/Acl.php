<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acl
 *
 * @author jannickvandaele
 */
class JannickV_Acl_Acl extends Zend_Acl {
    
    //ROLES
    const ADMIN = 'admin';
    const USER  = 'user';
    const GUEST = 'guest';
    
    
    public function __construct()
    {
        $this->addRole( self::GUEST                 )
             ->addRole( self::USER , self::GUEST    )
             ->addRole( self::ADMIN, self::USER     )
             ->allow  ( self::ADMIN                 )
             ->_addResources()
        ;
    }
    
    
    //RESOURCES
    protected function _addResources()
    {
        //Array met resources (controllers)
        $r = array();
        $r['error']     = self::getResource('error');
        $r['index']     = self::getResource('index');
        $r['account']   = self::getResource('account');
        $r['places']    = self::getResource('places');
        $r['data']      = self::getResource('data');
        //resources uit de backoffice module
        $r['indexBO']   = self::getResource('index', 'backoffice');
        $r['dataBO' ]   = self::getResource('data' , 'backoffice');
        $r['usersBO']   = self::getResource('users', 'backoffice');
        $r['commentBO'] = self::getResource('comment', 'backoffice');
        $r['newsBO']    = self::getResource('news', 'backoffice');

        //Array met Privileges (actions)
        $p = array();
        $p['index'   ] = self::getPrivilege('index'   );
        $p['login'   ] = self::getPrivilege('login'   );
        $p['places'   ] = self::getPrivilege('places'   );
        $p['logout'  ] = self::getPrivilege('logout'  );
        $p['register'] = self::getPrivilege('register');
        $p['edit'    ] = self::getPrivilege('edit'    );
        $p['activate'] = self::getPrivilege('activate');
        $p['contact'] = self::getPrivilege('contact');
        
        $this->addResources($r)
             ->allow(self::GUEST, $r['index'], array(
                 $p['index'   ],
                 $p['places'   ],
                 $p['contact'   ],
             ))
             ->allow(self::GUEST, $r['error'])
             ->allow(self::GUEST, $r['places'])
             ->allow(self::GUEST, $r['account'])
             ->allow(self::GUEST, $r['data'])
             ->allow(self::USER, $r['account'], array(
                 $p['edit'    ],
                 $p['logout'  ],
             ))
             ->deny(self::GUEST, $r['account'], array(
                 $p['edit'    ],
                 $p['logout'  ],
             ))
             ->deny( self::USER, $r['account'], array(
                 $p['login'   ],
                 $p['register'],
             ))
                //BACKOFFICE RESOURCES TOEVOEGEN
             ->allow(self::ADMIN, $r['indexBO']) //geen privileges nodig
             ->allow(self::ADMIN, $r['dataBO'])
             ->allow(self::ADMIN, $r['usersBO'])
             ->allow(self::ADMIN, $r['commentBO'])
             ->allow(self::ADMIN, $r['newsBO'])
                
        ;
    }

    /**
     * @param array $resources
     * @return Jannickv_Acl_Acl
     */
    public function addResources($resources = array()) {
        foreach ($resources as $resource) {
            $this->addResource($resource);
        }

        return $this;
    }

    /**
     * @param string $controller Controller name.
     * @param string $module Module name.
     * @return string Class name of Controller.
     */
    public static function getResource($controller = 'index', $module = 'default')
    {
        $class_name = ucfirst($controller) . 'Controller';

        if ($module != 'default') {
            $class_name = ucfirst($module) . "_{$class_name}";
        }

        return $class_name;
    }

    /**
     * @param string $action Action method name.
     * @return string Method name of Action method.
     */
    public static function getPrivilege($action = 'index')
    {
        $method_name = lcfirst($action) . 'Action';

        return $method_name;
    }
}

?>
