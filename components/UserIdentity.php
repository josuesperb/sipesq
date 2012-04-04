<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

	private $_id = false;
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
			'admin'=>'Adm#2011',
			'guisevero'=>'gorder',
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

	//se for o Administrador do sistema
	if($this->username == 'admin' || $this->username == 'guisevero')
		return $this->authenticate();

	$user = $this->username;
	$password = $this->password;
	$host = "ec-server";
	$domain = "ecepik.local";
	$basedn = "dc=ecepik,dc=local";
	$group = "EquipeCepik";
	try{
		$ds = ldap_connect("{$host}.{$domain}");
	}catch(CHttpException $e){
		throw $e(400,'Não foi possível conectar ao nosso servidor LDAP.');
	}
	
	ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
	
	if ($ds) {
	try{
   		$r = @ldap_bind($ds, "{$user}@{$domain}", $password);
	}catch(CHttpException $e){
		throw $e(400,'Usuário ou Senha Inválidos');
	}
   	if (!$r) {
      $this->errorCode=self::ERROR_PASSWORD_INVALID;
   	} else {
   		$this->_id = in_array($user, Yii::app()->params['admins']);
   		
      $this->errorCode=self::ERROR_NONE;
   	}
}
	return !$this->errorCode;
		
	
	}
	public function getId(){
		return $this->_id;
	}
}
