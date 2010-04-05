<?php

class TransactionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        TestHelper::setUp();
    }
    
    public function testCourierReferenceNumbers()
    {
		$data = array(
			'firstName' => 'Bryan',
			'lastName' => 'Zarzuela',
			'phoneNumber' => '7371131',
			'mobileNumber' => '09178604736',
			'deliveryAddress' => '462 C. Palanca',
			'courier' => '',
		);
	
		$data['courier'] = '';
    	
		$t = new Model_Transaction;
		$t->fromArray($data);
		
		$expected = 2 . date('ymdHis') . 0;
		$t->save();
		
		$this->assertEquals($expected, $t->referenceNumber);
		
		$data['courier'] = '2GO';
    	
		$t = new Model_Transaction;
		$t->fromArray($data);
		
		$expected = 2 . date('ymdHis') . 1;
		$t->save();
		
		$this->assertEquals($expected, $t->referenceNumber);
		
		$data['courier'] = 'AIR21';
    	
		$t = new Model_Transaction;
		$t->fromArray($data);
		
		$expected = 2 . date('ymdHis') . 2;
		$t->save();
		
		$this->assertEquals($expected, $t->referenceNumber);
		
		$data['courier'] = 'DFAMCILBC';
    	
		$t = new Model_Transaction;
		$t->fromArray($data);
		
		$expected = 2 . date('ymdHis') . 3;
		$t->save();
		
		$this->assertEquals($expected, $t->referenceNumber);
		
		$data['courier'] = 'TELPPTLBC';
    	
		$t = new Model_Transaction;
		$t->fromArray($data);
		
		$expected = 2 . date('ymdHis') . 4;
		$t->save();
		
		$this->assertEquals($expected, $t->referenceNumber);
		
		$data['courier'] = 'WWW';
    	
		$t = new Model_Transaction;
		$t->fromArray($data);
		
		$expected = 2 . date('ymdHis') . 5;
		$t->save();
		
		$this->assertEquals($expected, $t->referenceNumber);
    }

	public function testTeleservImport()
	{
		$import = file_get_contents(dirname(__FILE__) . '/deliveryExport - 2010-03-16.dat');
		$output = Model_Transaction::teleservImport($import);
		
		$q = Doctrine_Query::create()
			->from('Model_Transaction t');
		
		$data = json_decode($import, true);
		$this->assertEquals(count($data), $q->count());
		
		$this->assertEquals(count($data), $output['total']);
		$this->assertEquals(count($data), $output['created']);
		$this->assertEquals(0, $output['updated']);
		
		$t = Model_Transaction::findByRef($data[0]['referenceNumber']);
		$this->assertEquals(strtoupper($data[0]['firstName']), $t->firstName);
	}
}
