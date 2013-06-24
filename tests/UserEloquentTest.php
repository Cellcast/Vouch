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

    public function testCheckPassword()
    {
        $password = 'password';

        $user = m::mock('Cellcast\Vouch\Users\Eloquent\User[checkHash]');
        $user->password = 'hashed_password';
        $user->shouldReceive('checkHash')->with($password, 'hashed_password')->once()->andReturn(true);

        $this->assertTrue($user->checkPassword($password));
    }

    public function testCheckHash()
    {
        //$this->assertTrue(false);
    }

    public function testGenerateRandomStrings()
    {
        $user = new User;
        $last = '';

        for ($i = 0; $i < 500; $i++)
        {
            $now = $user->generateRandomString();

            if ($now === $last)
            {
                throw new \UnexpectedValueException('Two random strings are the same, [$now], [$last].');
            }

            $last = $now;
        }
    }
    
    public function testGenerateRandomStringLength()
    {
        $user = new User;
        
        $random_default = strlen($user->generateRandomString());
        $random_64 = strlen($user->generateRandomString(64));
        
        $this->assertEquals(42, $random_default);
        $this->assertEquals(64, $random_64);
    }

    public function testGeneratePersistCode()
    {
        $user = m::mock('Cellcast\Vouch\Users\Eloquent\User[generateRandomString,save]');

        $this->assertNull($user->persist_code);

        $user->shouldReceive('generateRandomString')->once()->andReturn('random_string');
        $user->shouldReceive('save')->once();

        $this->assertEquals('random_string', $user->generatePersistCode());
    }

    public function testCheckPersistCode()
    {
        $user = new User;
        $user->persist_code = 'persist_code';

        $this->assertTrue($user->checkPersistCode('persist_code'));
        $this->assertFalse($user->checkPersistCode('not_persist_code'));
    }

    public function testCheckPersistCodeEmpty()
    {
        $user = new User;

        $this->assertFalse($user->checkPersistCode('persist_code'));
        $this->assertFalse($user->checkPersistCode('not_persist_code'));
    }

    public function testCheckResetPasswordCode()
    {
        $user = new User;
        $user->reset_password_code = 'reset_code';

        $this->assertTrue($user->checkResetPasswordCode('reset_code'));
        $this->assertFalse($user->checkResetPasswordCode('not_reset_code'));
    }

    public function testCheckResetPasswordCodeEmpty()
    {
        $user = new User;

        $this->assertFalse($user->checkResetPasswordCode('reset_code'));
        $this->assertFalse($user->checkResetPasswordCode('not_reset_code'));
    }

}
