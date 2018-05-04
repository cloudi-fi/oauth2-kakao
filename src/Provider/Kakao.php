<?php namespace TunerPrime\OAuth2\Client\Provider;


use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Kakao extends AbstractProvider{
	const BASE_KAKAO_URL = 'https://kauth.kakao.com/oauth/';
	
	const BASE_KAKAO_PROFILE_URL = 'https://kapi.kakao.com/v1/user/me';
	
	public function __construct(array $options = [], array $collaborators = [])
	{
		parent::__construct($options, $collaborators);
	}
	
	public function getBaseAuthorizationUrl(){
		return static::BASE_KAKAO_URL.'authorize';
	}
	
	public function getBaseAccessTokenUrl(array $params){
		return static::BASE_KAKAO_URL.'token';
	}
	
	public function getResourceOwnerDetailsUrl(AccessToken $token)
	{
		return static::BASE_KAKAO_PROFILE_URL;
	}
	
	protected function getDefaultScopes()
	{
		return [];
	}
	
	public function getAuthorizationHeaders($token = NULL){
		return ['Authorization'=>'Bearer '.$token];
	}
	
	protected function checkResponse(ResponseInterface $response, $data)
	{
		if( $response->getStatusCode() != '200' ) {
			throw new IdentityProviderException($response->getBody(), $response->getStatusCode(), $data);
		}
	}
	protected function createResourceOwner(array $response, AccessToken $token)
	{
		$user = new KakaoUser($response);
		return $user;
	}
	
}