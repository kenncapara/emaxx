<?php 
class AuthTest extends Zend_Test_PHPUnit_ControllerTestCase
{
	public function setUp()
	{
		TestHelper::setUp();
		$this->bootstrap = new Zend_Application(
			'testing',
			APPLICATION_PATH . '/configs/application.ini'
			);
	}

	public function testAuthWithValidCredentials()
	{
		$u = new Model_User;
		$u->username = 'foo';
		$u->password = 'bar';
		$u->save();
		
		$this->request
			->setMethod('POST')
			->setPost(array(
				'username' => 'foo',
				'password' => 'bar',
			));
			
		$this->dispatch('/auth/login');
		$this->assertController('auth');
		$this->assertAction('login');
		
		$res = json_decode($this->getResponse()->getBody(), true);
		
		$this->assertTrue($res['success']);
	}
	
	public function testAuthWithInvalidCredentialsWillError()
	{
		$this->request
			->setMethod('POST')
			->setPost(array(
				'username' => 'foo',
				'password' => 'bar',
			));
			
		$this->dispatch('/auth/login');
		$this->assertController('auth');
		$this->assertAction('login');
		
		$res = json_decode($this->getResponse()->getBody(), true);
		
		$this->assertFalse($res['success']);
		
	}
}