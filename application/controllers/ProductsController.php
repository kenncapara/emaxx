<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductController
 *
 * @author kenn
 */
class ProductsController extends Teleserv_Controller_Action_Secure
{
    protected $_allowedRoles = array();
    
    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function newAction(){

        $param['product_code'] = $this->_getParam('product_code');
        $param['product_name'] = $this->_getParam('product_name');
        $param['short_description'] = $this->_getParam('short_description');
        $param['description'] = $this->_getParam('description');
        $param['active'] = $this->_getParam('active');

        $app = Model_Product::find($param['product_code']);
        if ($app) { throw new Exception("Product Code '".$param['product_code']."' already exist."); }

        $p = new Model_Product();
        $p->newProduct($param);
        
        echo json_encode(array(
            'success' => true
        ));
    }
    
    public function editAction(){

        $param['product_code'] = $this->_getParam('product_code');
        $param['product_name'] = $this->_getParam('product_name');
        $param['short_description'] = $this->_getParam('short_description');
        $param['description'] = $this->_getParam('description');
        $param['active'] = $this->_getParam('active');

        $id = $this->_getParam('id');
        $p = Model_Product::findbyId($id);
        if (! $p) { throw new Exception("Product id '".$id."' not found."); }
        
        $p->edit($param);
        
        echo json_encode(array(
            'success' => true
        ));
    }

    public function getProductListAction()
    {
        $p = new Model_Product();
        $res = $p->listProducts();
        foreach ($res as $key => $value) {
            $res[$key]['description'] = nl2br($value['description']);
        }
        echo json_encode(array(
            'data' => $res
        ));
    }

    public function getProductAction()
    {
        $id = $this->_getParam('id');
        $p = new Model_Product();
        $res = $p->fetchProduct($id);
        
        echo json_encode(array(
            'data' => $res,
            'success' => true
        ));
    }

    public function deleteAction()
    {
        $id = $this->_getParam('id');
        $p = Model_Product::findbyId($id);
        if (! $p) { throw new Exception("Product id '".$id."' not found."); }
        $p->delete();
        echo json_encode(array(
            'success' => true
        ));
    }
}

