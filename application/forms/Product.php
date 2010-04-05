<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Product1
 *
 * @author kenn
 */
class Form_Product extends Zend_Form
{
    public function init()
    {
        $this->addElement('text', 'product_code', array(
                            'filters' => array('StringToUpper'),
                            'validators' => array('NotEmpty')
                        ))
                 ->addElement('text', 'product_name', array(
                            'filters' => array('StringToUpper'),
                            'validators' => array('NotEmpty')
                        ))
                 ->addElement('text', 'short_description')
                 ->addElement('text', 'description')
                 ->addElement('text', 'status', array(
                            'validators' => array('NotEmpty')
                        ));
    }
}