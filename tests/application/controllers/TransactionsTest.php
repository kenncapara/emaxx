<?php 
class TransactionsTest extends Zend_Test_PHPUnit_ControllerTestCase
{
	public function setUp()
	{
		TestHelper::setUp();
		$this->bootstrap = new Zend_Application(
			'testing',
			APPLICATION_PATH . '/configs/application.ini'
			);
	}
	
	protected function _login()
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
		
		$res = json_decode($this->getResponse()->getBody(), true);
		
		$this->assertTrue($res['success']);
		
		$this->resetRequest()
			 ->resetResponse();
	}

	public function testCreatingNewRecord()
	{
		$this->_login();
		
		$this->request
			->setMethod('POST')
			->setPost(array(
				'firstName' => 'Bryan',
				'lastName' => 'Zarzuela',
				'phoneNumber' => '7371131',
				'mobileNumber' => '09178604736',
				'deliveryAddress' => '462 C. Palanca St. Quiapo Manila',
				'courier' => '2GO',
				'releaseDate' => date('Y-m-d', strtotime('today +7 day')),
				'officialReceiptNumber' => 123,
			));
			
		$this->dispatch('/transactions/new');
		$created = date('Y-m-d H:i:s');
		$this->assertController('transactions');
		$this->assertAction('new');
		$res = json_decode($this->getResponse()->getBody(), true);
		$this->assertTrue($res['success']);
		$this->assertEquals(1, $res['id']);
		
		$t = Model_Transaction::find(1);
		$this->assertEquals('BRYAN', $t->firstName);
		$this->assertEquals('ZARZUELA', $t->lastName);
		$this->assertEquals('7371131', $t->phoneNumber);
		$this->assertEquals('09178604736', $t->mobileNumber);
		$this->assertEquals('462 C. PALANCA ST. QUIAPO MANILA', $t->deliveryAddress);
		$this->assertEquals('2GO', $t->courier);
		$this->assertEquals(date('Y-m-d', strtotime('today +7 day')), $t->releaseDate);
		$this->assertEquals('foo', $t->acceptingUser);
		$this->assertEquals('123', $t->officialReceiptNumber);
		
		$this->assertEquals('foo', $t->logs[0]->username);
		$this->assertEquals($created, $t->logs[0]->created_at);
		$this->assertEquals('Created Transaction', $t->logs[0]->message);
	}
	
	public function testEditingRecordIsLogged()
	{
		$this->_login();
		
		$this->request
			->setMethod('POST')
			->setPost(array(
				'firstName' => 'Bryan',
				'lastName' => 'Zarzuela',
				'phoneNumber' => '7371131',
				'mobileNumber' => '09178604736',
				'deliveryAddress' => '462 C. Palanca St. Quiapo Manila',
				'courier' => '2GO',
				'releaseDate' => date('Y-m-d', strtotime('today +7 day')),
				'officialReceiptNumber' => 123,
			));
			
		$this->dispatch('/transactions/new');
		$this->assertController('transactions');
		$this->assertAction('new');
		$res = json_decode($this->getResponse()->getBody(), true);
		$this->assertTrue($res['success']);
		$this->assertEquals(1, $res['id']);
		
		$this->resetRequest()
			 ->resetResponse();
		
		$t = Model_Transaction::find(1);
		
		$this->request
			->setMethod('POST')
			->setPost(array(
				'referenceNumber' => $t->referenceNumber,
				'firstName' => 'Dyan',
				'lastName' => 'Zarzuela',
				'phoneNumber' => '7371131',
				'mobileNumber' => '09178604736',
				'deliveryAddress' => '462 C. Palanca St. Quiapo Manila',
				'courier' => '2GO',
				'releaseDate' => date('Y-m-d', strtotime('today +7 day')),
				'officialReceiptNumber' => 123,
			));
		
		$this->dispatch('/transactions/edit');
		$this->assertController('transactions');
		$this->assertAction('edit');
		$res = json_decode($this->getResponse()->getBody(), true);
		$this->assertTrue($res['success']);
		
		$t = Model_Transaction::find(1);
		
		$this->assertEquals('DYAN', $t->firstName);
		$this->assertEquals('ZARZUELA', $t->lastName);
		$this->assertEquals('7371131', $t->phoneNumber);
		$this->assertEquals('09178604736', $t->mobileNumber);
		$this->assertEquals('462 C. PALANCA ST. QUIAPO MANILA', $t->deliveryAddress);
		$this->assertEquals('2GO', $t->courier);
		$this->assertEquals(date('Y-m-d', strtotime('today +7 day')), $t->releaseDate);
		$this->assertEquals('foo', $t->acceptingUser);
		$this->assertEquals('123', $t->officialReceiptNumber);
		
		$this->assertEquals('foo', $t->logs[0]->username);
		$this->assertEquals('Created Transaction', $t->logs[0]->message);
		
		$this->assertEquals('foo', $t->logs[1]->username);
		$this->assertEquals('Edited:', substr($t->logs[1]->message, 0, 7));
	}
	
}