<?php
namespace InfiniWeb\FixerAPI;

class Fixer
{

	private $baseUrl;

	private $provider;

	public $symbols;

	public function __construct()
	{
		$this->symbols = new Symbols($this);
	}

	public function setAccessKey($accessKey)
	{
		$this->accessKey = $accessKey;
	}

	public function setBaseUrl($baseUrl)
	{
		$this->baseUrl = $baseUrl;
	}

	/**
	 * Get the request provider for formatted and authenticated requests
	 * @return Provider
	 */
	protected function getProvider()
    {
        if ($this->provider) {
            return $this->provider;
        }

        return new Provider(
            $this->accessKey
        );
    }

    public function getResponse($endpointKey, $params = [])
    {
    	$endpoint = $this->baseUrl . $endpointKey;
    	$provider = $this->getProvider();
    	return $this->checkResponse($provider->getResponse($endpoint, $params));
    }

    public function checkResponse($response)
    {
		if (!isset($response->success) || empty($response->success)) {

			$code = 0;
			$message = "";

			if (isset($response->error) && isset($response->error->code)) {
				$code = (int)$response->error->code;
			}

			if (isset($response->error) && isset($response->error->info)) {
				$message = $response->error->info;
			}

			throw new \Exception($message, $code);
		}

		return $response;
    }

}
