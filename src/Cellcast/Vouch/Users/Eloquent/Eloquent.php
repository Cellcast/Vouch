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
    
}
