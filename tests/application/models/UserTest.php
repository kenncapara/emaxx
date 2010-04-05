<?php

class UserTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        TestHelper::setUp();
    }
    
    /**
     * @expectedException Exception
     */
    public function testCannotHaveTwoUsersWithSameUsername()
    {
        $u1 = new Model_User;
        $u1->username = 'bryan';
        $u1->save();
        
        $u2 = new Model_User;
        $u2->username = 'bryan';
        $u2->save();
    }
    
    /**
     * @expectedException Exception
     */
    public function testEditingUsernameWhichResultsInDuplicateWillNotWork()
    {
        $u1 = new Model_User;
        $u1->username = 'bryan';
        $u1->save();
        
        $u2 = new Model_User;
        $u2->username = 'vincent';
        $u2->save();
        
        $u2->username = 'bryan';
        $u2->save();
    }

	public function testUserSetup()
	{
		$u = new Model_User;
		$u->username = 'counter1';
		$u->password = 'c1pass';
		$u->roles = array('user');
		$u->save();
		
		$u = new Model_User;
		$u->username = 'counter2';
		$u->password = 'c2pass';
		$u->roles = array('user');
		$u->save();
		
		$u = new Model_User;
		$u->username = 'counter3';
		$u->password = 'c3pass';
		$u->roles = array('user');
		$u->save();
		
		$u = new Model_User;
		$u->username = 'counter4';
		$u->password = 'c4pass';
		$u->roles = array('user');
		$u->save();
		
		$u = new Model_User;
		$u->username = 'counter5';
		$u->password = 'c5pass';
		$u->roles = array('user');
		$u->save();
		
		$u = new Model_User;
		$u->username = 'admin';
		$u->password = 'ping96;pong';
		$u->roles = array('admin');
		$u->save();
	}
}
