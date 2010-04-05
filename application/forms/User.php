<?php

/**
 * User Form 
 *
 * @package dfadelivery
 * @author Bryan Zarzuela
 */
class Form_User extends Zend_Form
{
	public function _init()
	{
		$this->addElement('text', 'username')
			 ->addElement('text', 'password');
	}
}