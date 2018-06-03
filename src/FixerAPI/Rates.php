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
     * @param  string $date To retrive the historical value, format YYYY-MM-DD
     * @return array
     */
    public function get($baseCurrency = null, $symbols = [], $date = null)
    {
        $data = $this->prepareData($baseCurrency, $symbols);

        // If a date is provided, we will get the historical data, the endpoint needs to be changed accordingly
        $endPoint = $date !== null ? $date : $this->endpointKey;

        $response = $this->fixer->getResponse($endPoint, $data);

        if (!isset($response->rates)) {
            throw new \Exception("Error Processing Request", 1);
        }

        return array('timestamp' => $response->timestamp, 'base' => $response->base, 'rates' => (array)$response->rates);
    }

    public function prepareData($baseCurrency = null, $symbols = [], $startDate = null, $endDate = null)
    {
        $data = array();

        if ($baseCurrency !== null) {
            $data['base'] = $baseCurrency;
        }

        if (!empty($symbols) && is_array($symbols)) {
            $data['symbols'] = implode(",", $symbols);
        }

        if ($startDate !== null) {
            $data['start_date'] = $startDate;
        }

        if ($endDate !== null) {
            $data['end_date'] = $endDate;
        }

        return $data;
    }

    public function getDailyRates($startDate, $endDate, $baseCurrency = null, $symbols = [])
    {
        $data = $this->prepareData($baseCurrency, $symbols, $startDate, $endDate);

        $endPoint = "timeseries";

        $response = $this->fixer->getResponse($endPoint, $data);

        if (!isset($response->rates)) {
            throw new \Exception("Error Processing Request", 1);
        }

        return array('base' => $response->base, 'rates' => (array)$response->rates);
    }
    
}
