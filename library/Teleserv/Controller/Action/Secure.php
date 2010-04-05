<?php

/**
 * Secure Controllers
 *
 * @package Teleserv
 * @author Bryan Zarzuela
 */
class Teleserv_Controller_Action_Secure extends Zend_Controller_Action
{
    protected $_allowedRoles = array();
    protected $_user;
    
    public function preDispatch()
    {
        $sess = new Zend_Session_Namespace('auth');
        
        if (is_null($sess->user)) {
            throw new Exception("Login Required");
        }
        
        $user = $sess->user;
//        if ( ! $user->belongsTo($this->_allowedRoles)) {
//            throw new Exception("Access Denied");
//        }
        
        $this->_user = $user;
    }
}