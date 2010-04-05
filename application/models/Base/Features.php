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
abstract class Model_Base_Features extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('features');

//        $this->hasColumn('feature_id', 'int', 11);
        $this->hasColumn('name', 'string', 30);
        $this->hasColumn('badge_file', 'string', 50);
        $this->hasColumn('description', 'string', 255);
        $this->hasColumn('active', 'int', 1);
        $this->hasColumn('product_id', 'int', 11 ,array(
            'type' => 'int',
            'default' => 0,
            'length' => 11
        ));

        $this->index('product_id', array('fields' => array('product_id')));
    }

    public function setUp()
    {
        $this->actAs("Timestampable");

        $this->hasOne('Model_Product as product', array(
            'local' => 'id',
            'foreign' => 'id'
        ));
    }

}
