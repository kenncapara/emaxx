<?php

/**
 * Identity
 *
 * @package Teleserv
 * @author Bryan Zarzuela
 */
class Teleserv_Auth_Identity
{
    protected $_username;
    protected $_email;
    protected $_employeeCode;
    protected $_firstName;
    protected $_lastName;
    protected $_nickName;
    protected $_roles;
    protected $_position;
    
    protected $_testOverride;
    
    /**
     * Constructor
     *
     * @param array $data 
     * @author Bryan Zarzuela
     */
    public function __construct($data)
    {
        $this->_username = $data->username;
        $this->_email = $data->email;
        $this->_firstName = $data->first_name;
        $this->_lastName = $data->last_name;
        $this->_nickName = $data->nickname;
        $this->_position = $data->position;
        $this->_employeeCode = $data->employee_code;
        $this->_roles = $data->roles;
    }

    /**
     * Checks if the user belongs to one or more roles
     *
     * @param mixed $roles 
     * @return bool
     * @author Bryan Zarzuela
     */
    public function belongsTo($roles)
    {
        if ($this->_testOverride) {
            return true;
        }
        
        if (in_array('superuser', $this->_roles)) {
            return true;
        }
        
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if (in_array($role, $this->_roles)) {
                    return true;
                }
            }
            return false;
        } else {
            return in_array($roles, $this->_roles);
        }
    }
    
    public function getTestOverride()
    {
        return $this->_testOverride;
    }

    public function setTestOverride($val)
    {
        $this->_testOverride = $val;
        return $this;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function setId($val)
    {
        $this->_id = $val;
        return $this;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function setUsername($val)
    {
        $this->_username = $val;
        return $this;
    }
    
    public function getFullName()
    {
        return $this->_firstName . ' ' . $this->_lastName;
    }
    
    public function getEmployeeCode()
    {
        return $this->_employeeCode;
    }

    public function setEmployeeCode($val)
    {
        $this->_employeeCode = $val;
        return $this;
    }

    
    
    
    
}