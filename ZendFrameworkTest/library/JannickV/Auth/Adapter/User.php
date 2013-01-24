<?php

class JannickV_Auth_Adapter_User extends Zend_Auth_Adapter_DbTable
{
    /**
     * @param string $username User name.
     * @param string $password Password.
     */
    public function __construct($username, $password)
    {
        parent::__construct();
        $this->setTableName('users') // WARNING: case sensitive!
             ->setIdentityColumn(  'username')
             ->setCredentialColumn('password')
             ->setIdentity(  $username)
             ->setCredential($password)
        ;
    }
}

?>
