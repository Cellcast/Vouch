<?php namespace Cellcast\Vouch;

use Cellcast\Vouch\Users\LoginRequiredException;

class Vouch {

    public function authenticate(array $credentials, $remember = false)
    {
        if (empty($credentials))
        {
            throw new LoginRequiredException("The attribute is required.");
        }
    }

}