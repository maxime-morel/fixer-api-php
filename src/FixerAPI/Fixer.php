<?php
namespace InfiniWeb\FixerAPI;

final class Fixer
{

	private $accessKey;

	private $baseUrl;

	private $provider;

	public function __construct($accessKey, $baseUrl)
	{
		$this->accessKey = $accessKey;
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

    protected function getResponse($endpointKey, $params = [])
    {

    }

}
