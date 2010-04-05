<?php 
class MainTest extends Zend_Test_PHPUnit_ControllerTestCase
{
	public function setUp()
	{
		TestHelper::setUp();
		$this->bootstrap = new Zend_Application(
			'testing',
			APPLICATION_PATH . '/configs/application.ini'
			);
	}

	public function testLoggedInUserButNotValidRolesWillNotGetIn()
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
		$this->assertEquals('{"success":true,"msg":"ok"}', $this->getResponse()->getBody());
		
		
		$this->resetRequest()
			 ->resetResponse();
		
		$this->dispatch('/main');
		$this->assertController('error');
	}
	
	public function testLoggedInUserWithValidRoleWillGetIn()
	{
		$u = new Model_User;
		$u->username = 'foo';
		$u->password = 'bar';
		$u->roles = array('user');
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
		$this->assertEquals('{"success":true,"msg":"ok"}', $this->getResponse()->getBody());
		
		
		$this->resetRequest()
			 ->resetResponse();
		
		$this->dispatch('/main');
		$this->assertController('main');
		$this->assertAction('index');
	}
}