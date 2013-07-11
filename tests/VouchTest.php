<?php namespace Cellcast\Vouch\Tests;

use Mockery as m;
use Cellcast\Vouch\Vouch;
use Cellcast\Vouch\Users\UserNotFoundException;
use PHPUnit_Framework_TestCase;

class VouchTest extends PHPUnit_Framework_TestCase {

    protected $userProvider;

    protected $vouch;

    /**
     * Setup resources and dependencies
     *
     * @return  void
     */
    public function setUp()
    {
        $this->vouch = new Vouch(
            $this->userProvider = m::mock('Cellcast\Vouch\Users\ProviderInterface')
        );
    }

    /**
     * Close Mockery
     *
     * @return  void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * @expectedException Cellcast\Vouch\Users\LoginRequiredException
     */
    public function testAuthenticateEmptyLoginIdentifier()
    {
        $credentials = array('password' => 'password');

        $this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn($user = m::mock('Cellcast\Vouch\Users\UserInterface'));
        $user->shouldReceive('getIdentifier')->once()->andReturn('email');

        $this->vouch->authenticate($credentials);
    }

    /**
     * @expectedException Cellcast\Vouch\Users\PasswordRequiredException
     */
    public function testAuthenticateEmptyPassword()
    {
        $credentials = array('email' => 'email@domain.com');

        $this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn($user = m::mock('Cellcast\Vouch\Users\UserInterface'));
        $user->shouldReceive('getIdentifier')->once()->andReturn('email');

        $this->vouch->authenticate($credentials);
    }

    /**
     * @expectedException Cellcast\Vouch\Users\UserNotFoundException
     */
    public function testAuthenticateNotFoundByCredentials()
    {
        $credentials = array('email' => 'doesntexist@domain.com', 'password' => 'password');

        $this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn($user = m::mock('Cellcast\Vouch\Users\UserInterface'));
        $user->shouldReceive('getIdentifier')->once()->andReturn('email');
        $this->userProvider->shouldReceive('findByCredentials')->once()->with($credentials)->andThrow(new UserNotFoundException);

        $this->vouch->authenticate($credentials);
    }

    public function testAuthenticate()
    {
        $credentials = array('email' => 'email@domain.com', 'password' => 'password');

        $this->userProvider->shouldReceive('getEmptyUser')->once()->andReturn($user = m::mock('Cellcast\Vouch\Users\UserInterface'));
        $user->shouldReceive('getIdentifier')->once()->andReturn('email');
        $this->userProvider->shouldReceive('findByCredentials')->once()->with($credentials)->andReturn($user = m::mock('Cellcast\Vouch\Users\UserInterface'));

        $this->assertTrue($this->vouch->authenticate($credentials));
    }

}
