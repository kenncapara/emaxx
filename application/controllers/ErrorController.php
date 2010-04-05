<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        if ($this->_request->isXmlHttpRequest() || (APPLICATION_ENV == 'testing')) {
            $this->_helper->viewRenderer->setNoRender(true);
            
            // application error
            $this->getResponse()->setHttpResponseCode(500);
            $json = array(
                'success' => false,
                'msg' => $errors->exception->getMessage(),
                'line' => $errors->exception->getLine(),
                'file' => $errors->exception->getFile(),
                'trace' => $errors->exception->getTrace(),
            );

            echo json_encode($json);
            
        } else {
        
            switch ($errors->type) {
                case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
                case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                    // 404 error -- controller or action not found
                    $this->getResponse()->setHttpResponseCode(404);
                    $this->view->message = 'Page not found';
                    break;
                default:
                    // application error
                    $this->getResponse()->setHttpResponseCode(500);
                    $this->view->message = 'Application error';
                    break;
            }
        
            $this->view->exception = $errors->exception;
            $this->view->request   = $errors->request;
        }
    }

}

