<?php namespace Cellcast\Vouch;

use Cellcast\Vouch\Users\Eloquent\Provider as UserProvider;
use Cellcast\Vouch\Users\ProviderInterface as UserProviderInterface;
use Cellcast\Vouch\Users\UserInterface;
use Cellcast\Vouch\Users\LoginRequiredException;
use Cellcast\Vouch\Users\PasswordRequiredException;
use Cellcast\Vouch\Users\UserNotFoundException;

class Vouch {

    /**
	 * The user that's been retrieved and is used
	 * for authentication
	 *
	 * @var Cellcast\Vouch\Users\UserInterface
	 */
	protected $user;

    /**
	 * The user provider, used for retrieving
	 * objects which implement the user interface
	 *
	 * @var Cellcast\Vouch\Users\ProviderInterface
	 */
    protected $userProvider;

    public function __construct(UserProviderInterface $userProvider = null)
    {
        $this->userProvider = $userProvider ?: new UserProvider;
    }

    /**
	 * Attempts to authenticate the given user
	 * according to the passed credentials
	 *
	 * @param  array  $credentials
	 * @param  bool   $remember
	 * @return Cellcast\Vouch\Users\UserInterface
	 * @throws Cellcast\Vouch\Users\LoginRequiredException
	 * @throws Cellcast\Vouch\Users\PasswordRequiredException
	 */
    public function authenticate(array $credentials, $remember = false)
    {
        $loginIdentifier = $this->userProvider->getEmptyUser()->getIdentifier();

        if (empty($credentials[$loginIdentifier]))
        {
            throw new LoginRequiredException("The login attribute is required.");
        }

        if (empty($credentials['password']))
        {
            throw new PasswordRequiredException("The password attribute is required.");
        }

        try
        {
            $user = $this->userProvider->findByCredentials($credentials);
        }
        catch (UserNotFoundException $e)
        {
            throw $e;
        }

        return true;
    }

}