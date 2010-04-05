<?php

class AuthController extends Zend_Controller_Action
{
    
	public function loginAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);

//		if ($this->_request->isPost()) {
//			$username = $this->_request->getPost('username');
//			$password = $this->_request->getPost('password');
//
//			if ($user = Model_User::authenticate($username, $password)) {
				
//				$user = new Teleserv_Auth_Identity($user);
                                $user = 'kenn';
				$auth = new Zend_Session_Namespace('auth');
				$auth->user = $user;

				echo json_encode(array(
					'success' => true,
					'msg' => 'ok',
					));
//			} else {
//				echo json_encode(array(
//					'success' => false,
//					'msg' => 'Invalid Credentials',
//					));
//			}
//		}
	}

	public function logoffAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);

		Zend_Session::destroy(true);
		$this->_redirect("/");
	}
}