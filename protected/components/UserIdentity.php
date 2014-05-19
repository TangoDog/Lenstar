<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = User::model()->findByAttributes(array('email'=>$this->username));
		//@todo - need to make LOWER
		if ($user === null) {
		// No user found!
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		} else if ($user->password !==	hash_hmac('sha256', $this->password,
				                           Yii::app()->params['encryptionKey']) ) {
		// Invalid password!
		$this->errorCode=self::ERROR_PASSWORD_INVALID;
		} else { // Okay!
			$this->_id=$user->id;
			$this->_dbowner=$user->dbowner;
			$this->username=$user->name;
			$this->setState('lastLogin', date("m/d/y g:i A", strtotime($user->last_login_time)));
			$this->setState('dbowner', $user->dbowner);
			$this->setState('userid', $user->id);
                        //var_dump($user);
			//Yii::app()->session['dbowner'] = $user->dbowner;
			//Yii::app()->session['userid'] = $user->id;
                        //var_dump($this);
//			$user->saveAttributes(array(
//					'last_login_time'=>date("Y-m-d H:i:s", time()),
//			));
			$this->errorCode=self::ERROR_NONE;
		}
	return !$this->errorCode;
	}
}