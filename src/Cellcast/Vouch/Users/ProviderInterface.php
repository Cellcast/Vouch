<?php namespace Cellcast\Vouch\Users;

interface ProviderInterface {

    public function getEmptyUser();

    public function findByCredentials($credentials);

}