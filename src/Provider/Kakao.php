<?php 

namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\Exception\KakaoIdentityProviderException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Kakao extends AbstractProvider{
	public $version = 'v2';
	
	public $base_kakao_oauth_url = 'https://kauth.kakao.com/oauth/';
	
	public $base_kakao_api_url = 'https://kapi.kakao.com/';
	
	public $base_kakao_profile_url = "/user/me";
	
	public function __construct(array $options = [], array $collaborators = [])
	{
		parent::__construct($options, $collaborators);
	}
	
	public function getBaseAuthorizationUrl(){
		return $this->base_kakao_oauth_url.'authorize';
	}
	
	public function getBaseAccessTokenUrl(array $params){
		return $this->base_kakao_oauth_url.'token';
	}
	
	public function getResourceOwnerDetailsUrl(AccessToken $token)
	{
		return $this->base_kakao_api_url.$this->version.$this->base_kakao_profile_url;
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
        if ($response->getStatusCode() >= 400) {
			throw new IdentityProviderException($response->getBody(), $response->getStatusCode(), $data);
		}
	}
	protected function createResourceOwner(array $response, AccessToken $token)
	{
		$user = new KakaoUser($response);
		return $user;
	}
	
}