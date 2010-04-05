<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Features
 *
 * @author kenn
 */
class Model_Features extends Model_Base_Features
{

    public function newFeatures($param)
    {
        $this->fromArray($param);
        $this->save();
    }

    public function fetchProductFeatures($product_id)
    {
         $q = Doctrine_Query::create()
                ->from ('Model_Features f')
                ->where('f.product_id = ?', $product_id);
        return $q->fetchArray();
    }

    public function findAll()
    {
        $q = Doctrine_Query::create()
                ->from('Model_Features f');
        return $q->fetchArray();
    }

    public function fetchFeature($feature_id)
    {
        $q = Doctrine_Query::create()
                ->from('Model_Features f');
    }
}
