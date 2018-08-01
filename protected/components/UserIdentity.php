<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
    public $errorCode;
    private $_id;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
        if (!isset($this->username)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return !$this->errorCode;
        }

        $user = UserHelper::getUserByEmail($this->username);
        if (!is_object($user)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return !$this->errorCode;
        }
        $this->_id = $user->id;

	if ($user->password !== md5($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->errorCode = self::ERROR_NONE;
        }

	    return !$this->errorCode;
	}

	/**
	 * Fetch the user's id
	 */
    	public function getId() {
        	return $this->_id;
    	}
}