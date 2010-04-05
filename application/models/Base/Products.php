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
abstract class Model_Base_Products extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('products');

        $this->hasColumn('product_code', 'string', 30);
        $this->hasColumn('product_name', 'string', 50);
        $this->hasColumn('short_description', 'string', 150);
        $this->hasColumn('description', 'string', 255);
        $this->hasColumn('active', 'integer', 1);
        $this->hasColumn('category_id', 'integer', 11 ,array(
            'type' => 'integer',
            'default' => 0,
            'notnull' => true,
            'length' => 11
        ));

        $this->index('product_code', array('fields' => array('product_code')));
        $this->index('product_name', array('fields' => array('product_name')));
        $this->index('category_id', array('fields' => array('category_id')));
        $this->index('active', array('fields' => array('active')));
    }

    public function setUp()
    {
        $this->actAs("Timestampable");

        $this->hasOne('Model_Product as product', array(
            'local' => 'id',
            'foreign' => 'product_code'
        ));
    }

}
