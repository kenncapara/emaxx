<?php

/**
 * Implementation of Zend_Auth_Adapter for authenticating against Teleserv's API.
 *
 * @package Teleserv
 * @author Bryan Zarzuela
 */
class Teleserv_Auth_Adapter implements Zend_Auth_Adapter_Interface
{
    protected $_username;
    protected $_password;
    protected $_url;
    
    /**
     * Constructor
     *
     * @param string $username 
     * @param string $password 
     * @param string $url This is the URL of the endpoint in Teleserv to authenticate against.
     * @author Bryan Zarzuela
     */
    public function __construct($username, $password, $url)
    {
        $this->_username = $username;
        $this->_password = $password;
        $this->_url = $url;
    }

    /**
     * Connects to the AUTH API in Teleserv to authenticate an agent against his HOME credentials.
     *
     * @return Zend_Auth_Result
     * @author Bryan Zarzuela
     * @throws Zend_Auth_Adapter_Exception
     */
    public function authenticate()
    {
        // This is not a real salt. I have to fix this one of these days.
        // Encrypt the password before sending over the wire.
        $password = sha1($this->_password . 'andpepper');
        
        $client = new Zend_Rest_Client($this->_url);
        $response = $client->authenticate($this->_username, $password)->post();
        if ( ! $response->isSuccess()) {
            throw new Zend_Auth_Adapter_Exception("Cannot authenticate");
        }
        
        if ( ! $response->success()) {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null);
        }
        $data = unserialize($response->data());
        // var_dump($data);
        $identity = new Teleserv_Auth_Identity($data);
        
        return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $identity);
    }
}