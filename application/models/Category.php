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
class Model_Category extends Model_Base_Categories
{

    public function edit($category)
    {
        $this->category = $category['category'];
        $this->save();
    }

    public function newCategory($category)
    {
        $this->category = $category['category'];
        $this->save();
    }

    public function fetchCategory($id)
    {
        $q = Doctrine_Query::create()
                ->from ('Model_Category c')
                ->where('c.id = ?', $id);
        $ret = $q->fetchArray();
        return $ret[0];
    }

    static function findbyId($id)
    {
        $q = Doctrine_Query::create()
             ->from('Model_Category c')
             ->where('c.id = ?', $id);
        return $q->fetchOne();
    }

    static function find($category)
    {
        $q = Doctrine_Query::create()
             ->from('Model_Category c')
             ->where('c.category = ?', $category);
        return $q->fetchOne();
    }

    public function listCategory()
    {
        $q = Doctrine_Query::CREATE()
            ->from('Model_Category c');
        return $q->fetchArray();
    }
}
