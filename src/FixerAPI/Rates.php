<?php
namespace InfiniWeb\FixerAPI;

final class Rates
{

	protected $endpointKey = 'latest';

	protected $fixer;

	public function __construct(Fixer $fixer)
	{
		$this->fixer = $fixer;
	}

	/**
	 * Return real-time exchange rate data.
	 * Based on subscription
	 * @param  string|null $baseCurrency the three-letter currency code of the base currency.
	 * @param  array $symbols list of comma-separated currency codes to limit output currencies.
	 * @return Object
	 */
	public function get($baseCurrency = null, $symbols = [])
	{

		$data = array();

		if ($baseCurrency !== null) {
			$data['base'] = $baseCurrency;
		}

		if (!empty($symbols) && is_array($symbols)) {
			$data['symbols'] = implode(",", $symbols);
		}

		$response = $this->fixer->getResponse($this->endpointKey, $data);

		if (!isset($response->rates)) {
			throw new \Exception("Error Processing Request", 1);
		}

		return array('timestamp' => $response->timestamp, 'base' => $response->base, 'rates' => $response->rates);
	}
	
}