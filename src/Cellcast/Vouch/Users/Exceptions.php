<?php namespace Cellcast\Vouch\Users;

class LoginRequiredException extends \UnexpectedValueException {}
class PasswordRequiredException extends \UnexpectedValueException {}
class UserNotFoundException extends \UnexpectedValueException {}