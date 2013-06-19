<?php namespace Cellcast\Vouch\Users;

interface UserInterface {

    /**
     * Returns the user's ID
     *
     * @return  mixed
     */
    public function getId();

    /**
     * Returns the column which is used as the users
     * identifier
     *
     * @return  string
     */
    public function getIdentifier();

    /**
     * Returns the permissions for the user
     *
     * @return  array
     */
    public function getPermissions();

    /**
     * Checks if the user has permission to
     * access the given task
     *
     * @param   string  $task
     * @return  bool
     */
    public function hasPermission($task);

    /**
     * Checks if the user is banned
     *
     * @return  bool
     */
    public function isBanned();

    /**
     * Check if the user is a super user
     * Grants user access to every task, regardless
     * of assigned permissions
     *
     * @return  bool
     */
    public function isSuperUser();

    /**
     * Gets the code for when the user is
     * persisted to a cookie or session which
     * identifies the user
     *
     * @return  string
     */
    public function getPersistCode();

    /**
     * Check if the given persist code against the
     * cookie or session
     *
     * @param   string  $persistCode
     * @return  bool
     */
    public function checkPersistCode($persistCode);

    /**
     * Check if the given password against the user's
     * password
     *
     * @param   string  $password
     */
    public function checkPassword($password);

    /**
     * Get the reset code assigned to the user
     *
     * @return  string
     */
    public function getResetPasswordCode();

    /**
     * Generate a reset code
     *
     * @return  string
     */
    public function generateResetPasswordCode();

    /**
     * Check if given reset code against the user's
     * reset code
     *
     * @param   string  $resetCode
     * @return  bool
     */
    public function checkResetPasswordCode($resetCode);

}
