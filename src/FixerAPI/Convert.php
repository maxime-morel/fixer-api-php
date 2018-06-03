<?php
namespace InfiniWeb\FixerAPI;

final class Convert
{

	protected $endpointKey = 'convert';

	protected $fixer;

	public function __construct(Fixer $fixer)
	{
		$this->fixer = $fixer;
	}

	public function get($from, $to, $amount, $date = null)
	{
		$data = array();

		$data['from'] = $from;
		$data['to'] = $to;
		$data['amount'] = $amount;

		if ($date !== null) {
			$data['date'] = $date;
		}

		$response = $this->fixer->getResponse($this->endpointKey, $data);

		if (!isset($response->rates)) {
			throw new \Exception("Error Processing Request", 1);
		}

		return array('timestamp' => $response->info->timestamp, 'rate' => $response->info->rate, 'result' => $response->result);
	}

}
