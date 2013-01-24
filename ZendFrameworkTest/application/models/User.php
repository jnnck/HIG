<?php

class Application_Model_User
{
    /**
     * ID
     *
     * @var integer
     */
    protected $_id;

    /**
     * First name
     *
     * @var string
     */
    protected $_firstname;

    /**
     * Last name
     *
     * @var string
     */
    protected $_lastname;

    /**
     * Email address
     *
     * @var string
     */
    protected $_mail;

    /**
     * User name
     *
     * @var string
     */
    protected $_username;

    /**
     * Password
     *
     * @var string
     */
    protected $_password;
    
    /**
     * Role
     *
     * @var string
     */
    protected $_role;
    
    /**
     * Role
     *
     * @var string
     */
    protected $_activationcode;
    
    /**
     * Role
     *
     * @var date
     */
    protected $_registerdate;
    
    /**
     * Role
     *
     * @var date
     */
    protected $_activationdate;
    
    /**
     * Role
     *
     * @var date
     */
    protected $_modificationdate;
    
    /**
     * Role
     *
     * @var date
     */
    protected $_deleteddate;

    /**
     * @param array $values
     */
    public function __construct(array $values = null) {
        foreach($values as $key => $value) {
            $setter = 'set' . ucfirst($key);
            $this->{$setter}($value);
        }
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->_firstname;
    }

    /**
     * @param string $givenname
     */
    public function setFirstname($firstname)
    {
        $this->_firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->_lastname;
    }

    /**
     * @param string $familyname
     */
    public function setLastname($lastname)
    {
        $this->_lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->_mail;
    }

    /**
     * @param string $email
     */
    public function setMail($mail)
    {
        $this->_mail = $mail;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }


    public function setPassword($password)
    {
        $this->_password = $password;
    }

    public function getRole()
    {
        return $this->_role;
    }
    
    public function setRole($role)
    {
        $this->_role = $role;
    }

    /**
     * @param string $password
     */
    public function setActivationcode($activationcode)
    {
        $this->_activationcode = $activationcode;
    }
    
    public function getActivationcode()
    {
        return $this->_activationcode;
    }

    /**
     * @param string $password
     */
    public function setRegisterdate($registerdate)
    {
        $this->_registerdate = $registerdate;
    }
    
    public function getRegisterdate()
    {
        return $this->_registerdate;
    }

    /**
     * @param string $password
     */
    public function setActivationdate($activationdate)
    {
        $this->_activationdate = $activationdate;
    }
    
    public function getActivationdate()
    {
        return $this->_activationdate;
    }

    /**
     * @param string $password
     */
    public function setModificationdate($modificationdate)
    {
        $this->_modificationdate = $modificationdate;
    }
    
    public function getModificationdate()
    {
        return $this->_modificationdate;
    }

    /**
     * @param string $password
     */
    public function setDeleteddate($deleteddate)
    {
        $this->_deleteddate = $deleteddate;
    }
    
    public function getDeleteddate()
    {
        return $this->_deleteddate;
    }

    
}

