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
class Form_Features extends Zend_Form
{
    public function init()
    {
        $file = new Zend_Form_Element_File('badge_file');
        $file->setDestination('../public/images/features')
            ->addValidator('Extension', false, 'jpeg,png,gif')
            ->setRequired(true);

        $this->addElement('text', 'name', array(
                            'validators' => array('NotEmpty')
                        ))
                 ->addElement('text', 'description', array(
                            'validators' => array('NotEmpty')
                        ))
                ->addElement('text', 'active', array(
                            'validators' => array('NotEmpty')
                        ))
                ->addElement($file);

    }
}