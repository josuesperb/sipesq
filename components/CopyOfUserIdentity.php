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
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}
	
public function autentica(){
	

	$connection=Yii::app()->db;
	$sql = "select * from users where password = :password AND username = :username";
	$command = $connection->createCommand($sql);

	$command->bindParam(":username",$this->username,PDO::PARAM_STR);
	// replace the placeholder ":email" with the actual email value
	$command->bindParam(":password",$this->password,PDO::PARAM_STR);
	if($command->execute() > 0)
		$this->errorCode=self::ERROR_NONE;
	else $this->errorCode=self::ERROR_PASSWORD_INVALID;

		return !$this->errorCode;
		
	
		
	
	}
}