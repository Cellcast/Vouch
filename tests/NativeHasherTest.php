<?php namespace Cellcast\Vouch\Test;

use Mockery as m;
use Cellcast\Vouch\Hashing\NativeHasher as Hasher;
use PHPUnit_Framework_TestCase;

class NativeHasherTest extends PHPUnit_Framework_TestCase {
    
    /**
     * Close mockery
     *
     * @return  void
     */
    public function tearDown()
    {
        m::close();
    }
    
    public function testHashingIsAlwaysCorrect()
    {
        $hasher = new Hasher;
        $password = 'f00b@rB@zb@T';
        $hashedPassword = $hasher->hash($password);
        
        $this->assertTrue($hasher->checkHash($password, $hashedPassword));
		$this->assertFalse($hasher->checkHash($password.'$', $hashedPassword));
    }

}