<?php

/**
 * Transaction Form 
 *
 * @package dfadelivery
 * @author Bryan Zarzuela
 */
class Form_Transaction extends Zend_Form
{
	public function init()
	{
		$officialReceiptNumber = new Zend_Form_Element_Text('officialReceiptNumber');
		$officialReceiptNumber->setRequired(true);
		
		$this->addElement('text', 'referenceNumber')
			 ->addElement('text', 'status')
			 ->addElement('text', 'deliveryStatus')
			 ->addElement('text', 'appointmentDate')
			 ->addElement('text', 'firstName', array(
				'filters' => array('StringToUpper'),
				))
			 ->addElement('text', 'middleName', array(
				'filters' => array('StringToUpper'),
				))
			 ->addElement('text', 'lastName', array(
				'filters' => array('StringToUpper'),
				))
			 ->addElement('text', 'phoneNumber')
			 ->addElement('text', 'mobileNumber')
			 ->addElement('text', 'courier', array(
				'filters' => array('StringToUpper'),
				))
			 ->addElement('text', 'releaseDate', array(
				'validators' => array('NotEmpty'),
				))
			 ->addElement('text', 'courierControlNumber', array(
				'validators' => array('NotEmpty'),
				))
			->addElement($officialReceiptNumber)
			 ->addElement('text', 'deliveryAddress', array(
				'filters' => array('StringToUpper'),
				));
	}
}