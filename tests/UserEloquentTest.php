<?php namespace Cellcast\Vouch\Test;

use Mockery as m;
use Cellcast\Vouch\Users\Eloquent\User;
use PHPUnit_Framework_TestCase;

class UserEloquentTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        m::close();
    }

    public function testDefaultGetIdentifierSetting()
    {        
        $user = new User;
        $email = $user->loginIdentifier;
        
        $this->assertEquals('email@email.com', $email);
    }

    
}
