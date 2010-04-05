<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Products
 *
 * @author kenn
 */
abstract class Model_Base_Categories extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('categories');
        $this->hasColumn('category_id', 'int', 11);
        $this->hasColumn('category', 'string', 50);

        $this->index('category_id', array('fields' => array('category_id')));
        $this->index('category', array('fields' => array('category')));
    }

    public function setUp()
    {
        $this->actAs("Timestampable");

        $this->hasOne('Model_Category as category', array(
            'local' => 'id',
            'foreign' => 'category_id'
        ));

    }

}
