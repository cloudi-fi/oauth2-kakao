<?php
namespace TunerPrime\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class KakaoUser implements ResourceOwnerInterface{
	protected $response;
	
	public function __construct($response = array()){
		var_dump($response);
		$this->response = $response;
	}
	public function getId(){
		return $this->response['id'];
	}
	
	public function getEmail(){
		if(isset($this->response['kaccount_email']))
			return $this->response['kaccount_email'];
		else
			return NULL;
	}
	public function getEmailVerified(){
		if(isset($this->response['kaccount_email_verified']))
			return $this->response['kaccount_email_verified'];
		else
			return NULL;
	}
	
	public function getPropertiesValue($name = NULL){
		if(is_null($name)){ return NULL; }
		else if(isset($this->response['properties'][$name])){ return $this->response['properties'][$name]; }
		else{ return NULL; }
	}
	public function toArray()
	{
		return $this->response;
	}
}