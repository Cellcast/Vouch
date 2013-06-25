<?php namespace Cellcast\Vouch\Tests;

use Mockery as m;
use Cellcast\Vouch\Vouch;
use PHPUnit_Framework_TestCase;

class VouchTest extends PHPUnit_Framework_TestCase {
    
    protected $vouch;
    
    public function setUp()
    {
        $this->vouch = new Vouch;
    }
    
    public function tearDown()
    {
        m::close();
    }

    /**
     * @expectedException Cellcast\Vouch\Users\LoginRequiredException
     */
    public function testAuthenticateLoginIdentifierNotProvided()
    {
        $credentials = array();

        $this->vouch->authenticate($credentials);
    }

}