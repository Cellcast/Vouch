<?php namespace Cellcast\Vouch;

use Cellcast\Vouch\Vouch;
use Cellcast\Vouch\Users\Eloquent\Provider as UserProvider;
use Illuminate\Support\ServiceProvider;

class VouchServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events
     *
     * @return  void
     */
    public function boot()
    {
        $this->package('cellcast/vouch', 'cellcast/vouch');

        $this->registerVouchEvents();
    }

    /**
     * Register the service provider
     *
     * @return void
     */
    public function register()
    {
        $this->registerUserProvider();
    
        $this->app['vouch'] = $this->app->share(function($app)
        {
            // Once the authentication service has actually been requested by the developer
            // we will set a variable in the application indicating such. This helps us
            // know that we need to set any queued cookies in the after event later.
            $app['vouch'] = true;

            return new Vouch();
        });
    }

    public function registerUserProvider()
    {
        $this->app['vouch.user'] = $this->app->share(function($app)
        {
            $model = 'Cellcast\Vouch\Users\Eloquent\User';
        
            return new UserProvider($model);
        });
    }

    /**
     * Get the services provided by the provider
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * Register the events needed for authentication
     *
     * @return  void
     */
    public function registerVouchEvents()
    {
        
    }

}
