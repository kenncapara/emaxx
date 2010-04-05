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
class FeaturesController extends Teleserv_Controller_Action_Secure
{
    protected $_allowedRoles = array();

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function newAction()
    {
        $form = new Form_Features();
        $f = new Model_Features();
        $badge_file = $_FILES['badge_file'];
        $temp_file = $badge_file['name'];
        $destination = '../public/images/features';
        
         if ($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $valid = $form->isValid($formData);
            if ($valid) {
                move_uploaded_file($temp_file, $destination);
                
                $data = $form->getValues();
                $f->newFeatures($data);
                
                echo json_encode(array(
                    'success' => true
                ));
            } else {
                echo json_encode(array(
                    'msg' => "Submitted form not valid.",
                    'success' => false
                ));
            }
        }

    }

    public function getFeaturesAction()
    {
        $product_id = $this->_getParam('product_id');

        $f = new Model_Features();
        $res = $f->fetchProductFeatures($product_id);
        echo json_encode(array(
            'data' => $res
        ));
    }

    public function listAction()
    {
        $f = new Model_Features();
        $data = $f->findAll();
        echo json_encode(array(
           'data' => $data
        ));
        
    }

    public function AddMemberAction()
    {
        $f = new Model_Features();

        $res = $f->getFeatures($feature_id);
        echo json_encode(array(
            'data' => $res
        ));
    }

    
//    private function getFileExtension($str) {
//        $i = strrpos($str,".");
//        if (!$i) { return ""; }
//
//        $l = strlen($str) - $i;
//        $ext = substr($str,$i+1,$l);
//
//        return $ext;
//    }
}

