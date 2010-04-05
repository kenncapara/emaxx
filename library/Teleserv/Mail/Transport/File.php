<?php

/**
 * File Transport for debugging Zend Mail
 *
 * @package Teleserv
 * @author Bryan Zarzuela
 */
class Teleserv_Mail_Transport_File extends Zend_Mail_Transport_Abstract
{
    protected $_log;
    
    public function __construct($log)
    {
        $this->_log = $log;
    }
    
    public function _sendMail()
    {
        $mail = $this->_mail;
        // Open log for appending
        $fh = fopen($this->_log, "a");
        fwrite($fh, date('Y-m-d H:is') . "\n");
        fwrite($fh, $mail->getFrom() . "\n");
        fwrite($fh, print_r($mail->getRecipients(), true) . "\n");
        fwrite($fh, $mail->getSubject() . "\n");
        
        $body = $mail->getBodyText();
        if ($body instanceof Zend_Mime_Part) {
            $body = $body->getContent();
        }
        fwrite($fh, $body . "\n");
        fclose($fh);
    }
}