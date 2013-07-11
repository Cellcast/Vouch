<?php namespace Cellcast\Vouch\Users\Eloquent;

use Cellcast\Vouch\Users\ProviderInterface;
use Cellcast\Vouch\Users\UserInterface;
use Cellcast\Vouch\Users\UserNotFoundException;


class Provider implements ProviderInterface {

    protected $model = 'Cellcast\Vouch\Users\Eloquent\User';

    /**
	 * Create a new Eloquent User provider.
	 *
	 * @param  string  $model
	 * @return void
	 */
    public function __construct($model)
    {
        if (isset($model))
        {
            $this->model = $model;
        }
    }

	public function getEmptyUser()
	{
		return $this->createModel();
	}

    /**
     * Finds a user by the given credentials
     *
     * @param   array   $credentials
     * @return  Cellcast\Vouch\Users\UserInterface
     * @throws  Cellcast\Vouch\Users\UserNotFoundException
     */
    public function findByCredentials($credentials)
    {
        $model = $this->createModel();
        $identifier = $model->getIdentifier();

        if ( ! array_key_exists($identifier, $credentials))
        {
            throw new \InvalidArgumentException;
        }
        
        $query = $model->newQuery();
        
        $query = $query->where($identifier, '=', $credentials[$identifier]);

        if ( ! $user = $query->first())
        {
            throw new UserNotFoundException("A user was not found with the given credentials.");
        }

        return $user;

    }

    /**
	 * Create a new instance of the model.
	 *
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function createModel()
	{
		$class = '\\'.ltrim($this->model, '\\');

		return new $class;
	}

	/**
	 * Sets a new model class name to be used at
	 * runtime.
	 *
	 * @param  string  $model
	 */
	public function setModel($model)
	{
		$this->model = $model;
		$this->setupHasherWithModel();
	}

}