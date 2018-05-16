# oauth2-kakao
extension league/OAuth2-client version by Kakao

Composer install

    composer require tunerprime/oauth2-kakao

Example Code

    $provider = new TunerPrime\OAuth2\Client\Provider\Kakao([
        'clientId'     => '{kakao-client-Id}',
        'clientSecret' => '{kakao-client-secret}', // kakao isn't require clientsecret! 
        'redirectUri'  => '{your-redirect-Uri}',
    ]);
    
    if (!empty($_GET['error'])) {
    
        exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
    
    } elseif (empty($_GET['code'])) {

        $authUrl = $provider->getAuthorizationUrl();
        $_SESSION['oauth2state'] = $provider->getState();
        header('Location: ' . $authUrl);
        exit;
    
    } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
        exit('Invalid state');
    
    } else {
    
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
    
        try {
        
            $ownerDetails = $provider->getResourceOwner($token);
        
            printf('Hello %s!', $ownerDetails->getPropertiesValue('nickname'));
        
        } catch (Exception $e) {
        
            exit('Something went wrong: ' . $e->getMessage());
        
        }
    
        // Use this to interact with an API on the users behalf
        echo $token->getToken();
        
        // Number of seconds until the access token will expire, and need refreshing
        echo $token->getExpires();
    }
