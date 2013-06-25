<?php namespace Cellcast\Vouch\Users\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Cellcast\Vouch\Users\UserInterface;

class User extends Model implements UserInterface {

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = array(
        'password',
        'persist_code',
        'reset_password_code'
    );

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = array(
        'persist_code',
        'reset_password_code'
    );
    
    /**
     * The login identifier
     *
     * @var string
     */
     protected static $loginIdentifier = 'email';

    /**
     * Override the users identifier column
     *
     * @return  void
     */
    public function setIdentifier($loginIdentifier)
    {
        static::$loginIdentifier = $loginIdentifier; 
    }

    /**
     * Returns the column which is used as the users
     * identifier
     *
     * @return  string
     */
    public function getIdentifier()
    {
        return static::$loginIdentifier;
    }

    /**
     * Returns the permissions for the user
     *
     * @return  array
     */
    public function getPermissions()
    {
        
    }

    /**
     * Checks if the user has permission to
     * access the given task
     *
     * @param   string  $task
     * @return  bool
     */
    public function hasPermission($task)
    {
        
    }

    /**
     * Checks if the user is banned
     *
     * @return  bool
     */
    public function isBanned()
    {
        return $this->banned;
    }

    /**
     * Check if the given password against the user's
     * password
     *
     * @param   string  $password
     * @return  bool
     */
    public function checkPassword($password)
    {
        return $this->checkHash($password, $this->password);
    }

    /**
     * Checks a non hashed string against its hashed
     * counterpart
     *
     * @param   string  $string
     * @param   string  $hashedString
     * @return  bool
     */
    public function checkHash($string, $hashedString)
    {
        return false;
    }

    /**
     * Gets the code for when the user is
     * persisted to a cookie or session which
     * identifies the user
     *
     * @return  string
     */
    public function generatePersistCode()
    {
        $this->persist_code = $persistCode = $this->generateRandomString();
        $this->save();
        
        return $persistCode;
    }

    /**
     * Check if the given persist code against the
     * cookie or session
     *
     * @param   string  $persistCode
     * @return  bool
     */
    public function checkPersistCode($persistCode)
    {
        if ( ! $persistCode)
        {
            return false;
        }

        return ($this->persist_code === $persistCode);
    }

    /**
     * Generate a reset code
     *
     * @return  string
     */
    public function generateResetPasswordCode()
    {
        $this->reset_password_code = $resetCode = $this->generateRandomString();
        $this->save();
        
        return $resetCode;
    }

    /**
     * Check if given reset code against the user's
     * reset code
     *
     * @param   string  $resetCode
     * @return  bool
     */
    public function checkResetPasswordCode($resetCode)
    {
        if ( ! $this->reset_password_code)
        {
            return false;
        }

        return ($this->reset_password_code === $resetCode);
    }

    /**
     * Generate a random string that can be used for
     * password reset and persist codes
     * 
     * @param   string  $length
     * @return  string
     */ 
    public function generateRandomString($length = 42)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    /**
     * Password Mutator
     *
     * @return  void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = 'hashed_password';//Hash::make($value);
    }

}
