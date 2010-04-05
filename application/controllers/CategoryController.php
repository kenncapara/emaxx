<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author kenn
 */
class CategoryController extends Teleserv_Controller_Action_Secure
{
    protected $_allowedRoles = array();

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function editAction()
    {
        $category = $this->_getParam('category');
        $id = $this->_getParam('category_id');
        $p = Model_Category::findbyId($id);
        if (! $p) { throw new Exception("Category id '".$id."' not found."); }

        $app = Model_Category::find($category);
        if ($app) { throw new Exception("Category '".$param['category']."' already exist."); }

        $p->category = $category;
        $p->save();
        echo json_encode(array(
            'success' => true
        ));
    }

    public function newAction(){

        $param['category'] = $this->_getParam('category');
        
        $app = Model_Category::find($param['category']);
        if ($app) { throw new Exception("Category '".$param['category']."' already exist."); }
        $c = new Model_Category();
        $c->newCategory($param);

        echo json_encode(array(
            'success' => true
        ));
    }

    public function getCategoryListAction()
    {
        $p = new Model_Category();
        $res = $p->listCategory();

        echo json_encode(array(
            'data' => $res
        ));
    }

    public function deleteAction()
    {
        $id = $this->_getParam('id');
        $p = Model_Category::findbyId($id);
        if (! $p) { throw new Exception("Category id '".$id."' not found."); }
        $p->delete();
        echo json_encode(array(
            'success' => true
        ));
    }

    public function getMembersAction()
    {
        $id = $this->_getParam('category_id');
        $p = Model_Category::findbyId($id);
        if (! $p) { throw new Exception("Category id '".$id."' not found."); }

        $p = new Model_Product();
        $data = $p->fetchCategoryMembers($id);
        echo json_encode(array(
            'success' => true,
            'data' => (is_null($data)) ? $data = array() : $data
        ));
    }

    public function getNonmemberProductsAction()
    {
        $p = new Model_Product();
        $res = $p->fetchNonMembers();
        foreach ($res as $key => $value) {
            $res[$key]['description'] = nl2br($value['description']);
        }
        echo json_encode(array(
            'success' => true,
            'data' => (is_null($res)) ? $res = array() : $res
        ));
    }

    public function addMemberAction()
    {
        $product_id = $this->_getParam('product_id');
        $category_id = $this->_getParam('category_id');
        $c = Model_Category::findbyId($category_id);
        if (! $c) { throw new Exception("Category id '".$category_id."' not found."); }
        $p = Model_Product::findbyId($product_id);
        if (! $p) { throw new Exception("Product id '".$product_id."' not found."); }

        $p = Model_Product::findbyId($product_id);
        $p->category_id = $category_id;
        $p->save();
        
        $p = new Model_Product();
        $data = $p->fetchNonMembers();
        echo json_encode(array(
            'success' => true,
            'data' => (is_null($data)) ? $data = array() : $data
        ));

    }

    public function removeMemberAction()
    {
        $product_id = $this->_getParam('product_id');
        $p = Model_Product::findbyId($product_id);
        if (! $p) { throw new Exception("Product id '".$product_id."' not found."); }

        $p = Model_Product::findbyId($product_id);
        $p->category_id = 0;
        $p->save();

        echo json_encode(array(
            'success' => true
        ));
    }
}

