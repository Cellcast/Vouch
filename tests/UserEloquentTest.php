<?php namespace Cellcast\Vouch\Test;

use Mockery as m;
use Cellcast\Vouch\Users\Eloquent\User;
use PHPUnit_Framework_TestCase;

class UserEloquentTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        m::close();
    }

    public function testInstance()
    {
        new User;
    }

    public function testDefaultIdentifier()
    {
        $user = new User;

        $this->assertEquals('email', $user->getIdentifier());
    }

    public function testSetIndenitifer()
    {
        $user = new User;
        $user->setIdentifier('username');

        $this->assertEquals('username', $user->getIdentifier());
    }

}
