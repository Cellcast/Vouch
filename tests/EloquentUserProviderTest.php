<?php namespace Cellcast\Vouch\Test;

use Mockery as m;
use Cellcast\Vouch\Users\Eloquent\Provider;
use Cellcast\Vouch\Users\Eloquent\User;
use Cellcast\Vouch\Users\UserNotFoundException;
use PHPUnit_Framework_TestCase;

class EloquentUserProviderTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        m::close();
    }

    public function testGettingEmptyUser()
    {
        $provider = m::mock('Cellcast\Vouch\Users\Eloquent\Provider[createModel]');

        $provider->shouldReceive('createModel')->once()->andReturn($user = m::mock('Cellcast\Vouch\Users\Eloquent\User'));

        $this->assertEquals($user, $provider->getEmptyUser());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindingByCredentialsFailsWithoutIdentifierColumn()
    {
        $credentials = array('email' => 'email@domain.com', 'password' => 'hashed_password');

        $user = m::mock('Cellcast\Vouch\Users\Eloquent\User');
        $user->shouldReceive('getIdentifier')->once()->andReturn('not_valid');

        $provider = m::mock('Cellcast\Vouch\Users\Eloquent\Provider[createModel]');
        $provider->shouldReceive('createModel')->once()->andReturn($user);

        $provider->findByCredentials($credentials);
    }

    /**
     * @expectedException Cellcast\Vouch\Users\UserNotFoundException
     */
    public function testFindingByCredentialsFailsWhenUserNotFound()
    {
        $credentials = array('email' => 'doesntexist@domain.com', 'password' => 'hashed_password');

        $query = m::mock('StdClass');
        $query->shouldReceive('where')->with('email', '=', 'doesntexist@domain.com')->once()->andReturn($query);
        $query->shouldReceive('first')->andReturn(null);

        $user = m::mock('Cellcast\Vouch\Users\Eloquent\User');
        $user->shouldReceive('getIdentifier')->once()->andReturn('email');
        $user->shouldReceive('newQuery')->andReturn($query);

        $provider = m::mock('Cellcast\Vouch\Users\Eloquent\Provider[createModel]');
        $provider->shouldReceive('createModel')->once()->andReturn($user);

        $provider->findByCredentials($credentials);
    }

    public function testFindingByCredentials()
    {
        $credentials = array('email' => 'email@domain.com', 'password' => 'hashed_password');
        
        $actualUser = m::mock('Cellcast\Vouch\Users\Eloquent\User');
        $actualUser->shouldReceive('getAttribute')->with('email')->andReturn('email@domain.com');
        $actualUser->shouldReceive('getAttribute')->with('password')->andReturn('hashed_password');

        $query = m::mock('StdClass');
        $query->shouldReceive('where')->with('email', '=', 'email@domain.com')->once()->andReturn($query);
        $query->shouldReceive('first')->andReturn($actualUser);

        $user = m::mock('Cellcast\Vouch\Users\Eloquent\User');
        $user->shouldReceive('getIdentifier')->once()->andReturn('email');
        $user->shouldReceive('newQuery')->andReturn($query);

        $provider = m::mock('Cellcast\Vouch\Users\Eloquent\Provider[createModel]');
        $provider->shouldReceive('createModel')->once()->andReturn($user);

        $result = $provider->findByCredentials($credentials);
        
        $this->assertEquals($actualUser, $result);
    }
}