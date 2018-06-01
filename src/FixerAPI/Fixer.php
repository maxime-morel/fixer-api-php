<?php
namespace InfiniWeb\FixerAPI;

class Fixer
{

	/**
	 * The API base URL
	 * @var string
	 */
	private $baseUrl;

	/**
	 * The API provider for GET operations
	 * @var Provider
	 */
	private $provider;

	/**
	 * Object managing the currency list (ISO code and currency name)
	 * @var Symbols
	 */
	public $symbols;

	/**
	 * Object managing the currency rates
	 * @var Rates
	 */
	public $rates;

	public function __construct()
	{
		$this->symbols = new Symbols($this);
		$this->rates = new Rates($this);
	}

	/**
	 * Set the API access key
	 * @param string $accessKey Access Key provided by fixer.io
	 */
	public function setAccessKey($accessKey)
	{
		$this->accessKey = $accessKey;
	}

	/**
	 * Set the base URL of the API.
	 * It will be used to compose the API endpoint
	 * @param string $baseUrl the API base URL
	 */
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

    /**
     * Obtain the API response
     * @param  array $endpointKey The end point key to append to the base url
     * @param  array  $params The request parameters
     * @return Object The API response
     */
    public function getResponse($endpointKey, $params = [])
    {
    	$endpoint = $this->baseUrl . $endpointKey;
    	$provider = $this->getProvider();
    	return $this->checkResponse($provider->getResponse($endpoint, $params));
    }

    /**
     * Check response for errors
     * @param  Object $response The API response
     * @throws \Exception
     * @return Object
     */
    public function checkResponse($response)
    {
    	if (!$response) {
    		throw new \Exception("Error Processing Request", 1);
    	}

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
