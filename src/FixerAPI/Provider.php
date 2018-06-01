<?php
namespace InfiniWeb\FixerAPI;

class Provider
{

	private $accessKey;

	public function __construct($accessKey)
	{
		$this->accessKey = $accessKey;
	}

	public function getResponse($endpoint, $data, $method = 'GET')
    {

        $accessToken = $this->getAccessToken();

        $body = http_build_query($data);

        try {
            
            $request = $provider->getAuthenticatedRequest(
                $method,
                $this->settings->getApiUrl() . $endpoint,
                $accessToken,
                [
                    'body' => $body,
                    'headers' => [
                        'content-type' => 'application/x-www-form-urlencoded'
                    ]
                ]
            );

            $response = $provider->getResponse($request);

        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            $errorInfo = $e->getResponseBody();
            $this->lastErrorMessage = $errorInfo['error_description'];
            return false;
        } catch (\Exception $exp){
            $errorInfo = $exp->getMessage();
            $this->lastErrorMessage = $errorInfo;
            return false;
        }

        return $response ;
    }

    public function getAuthenticatedRequest()
    {

    }
    
}
