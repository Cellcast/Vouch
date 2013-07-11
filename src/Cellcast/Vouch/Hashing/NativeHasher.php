<?php namespace Cellcast\Vouch\Hashing;

use Cellcast\Vouch\Hashing\HasherInterface;

class NativeHasher implements HasherInterface {

    /**
     * Hash string
     *
     * @param   string  $string
     * @return  string
     */
    public function hash($string)
    {
        if ( ! function_exists('password_hash'))
        {
            throw new \RuntimeException('The function password_hash() does not exist, your PHP environment is probably incompatible. Try running [vendor/ircmaxell/password-compat/version-test.php] to check compatibility or use an alternative hashing strategy.');
        }

        if (($hash = password_hash($string, PASSWORD_DEFAULT)) === false)
        {
            throw new \RuntimeException('Error generating hash from string, your PHP environment is probably incompatible. Try running [vendor/ircmaxell/password-compat/version-test.php] to check compatibility or use an alternative hashing strategy.');
        }

        return $hash;
    }

    /**
     * Check string against hashed string
     *
     * @param   string  $string
     * @param   string  $hashedString
     * @return  bool
     */
    public function checkhash($string, $hashedString)
    {
        return password_verify($string, $hashedString);
    }

}