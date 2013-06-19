<?php namespace Cellcast\Vouch\Test;

use Mockery as m;
use Cellcast\Vouch\Vouch;
use PHPUnit_Framework_TestCase;

class VouchTest extends PHPUnit_Framework_TestCase {

    protected $vouch;

    public function setUp()
    {
        $this->vouch = new Vouch();
    }

    public function tearDown()
    {
        m::close();
    }

    public function testExampleTest()
    {
        $this->assertTrue(true);
    }

}