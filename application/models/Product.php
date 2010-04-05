<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Product
 *
 * @author kenn
 */
class Model_Product extends Model_Base_Products
{

    public function edit($data)
    {
        $this->fromArray($data);
        $this->save();
    }

    public function newProduct($product)
    {
        $this->fromArray($product);
        $this->save();
    }

    public function fetchProduct($id)
    {
        $q = Doctrine_Query::create()
                ->from ('Model_Product p')
                ->where('p.id = ?', $id);
        $ret = $q->fetchArray();
        return $ret[0];
    }

    public function fetchCategoryMembers($id)
    {
        $q = Doctrine_Query::create()
                ->from ('Model_Product p')
                ->where('p.category_id = ?', $id);
        return $q->fetchArray();
    }

    public function addCategoryMember($category_id)
    {
        $this->category_id = $category_id;
        $this->save();
    }


    public function fetchNonMembers()
    {
        /*
         * Product unassigned to category has default category_id to zero.
         */
        $category_id = 0;
        $q = Doctrine_Query::create()
                ->from ('Model_Product p')
                ->where('p.category_id = ?', $category_id);
        return $q->fetchArray();
    }

    static function findbyId($id)
    {
        $q = Doctrine_Query::create()
             ->from('Model_Product p')
             ->where('p.id = ?', $id);
        return $q->fetchOne();
    }

    static function find($product_code)
    {
        $q = Doctrine_Query::create()
             ->from('Model_Product p')
             ->where('p.product_code = ?', $product_code);
        return $q->fetchOne();
    }

    public function listProducts()
    {
        $q = Doctrine_Query::CREATE()
            ->from('Model_Product p');
        return $q->fetchArray();
    }
}
