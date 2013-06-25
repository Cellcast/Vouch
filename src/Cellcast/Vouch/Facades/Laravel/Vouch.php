<?php namespace Cellcast\Vouch\Facades\Laravel;

use Illuminate\Support\Facades\Facade;

class Vouch extends Facade {

    /**
     * Get the registered name of the component
     *
     * @return  string
     */
    protected static function getFacadeAccessor()
    {
        return 'vouch';
    }

}
