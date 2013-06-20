<?php namespace Cellcast\Vouch\Users\Eloquent

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

}
