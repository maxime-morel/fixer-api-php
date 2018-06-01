<?php
namespace InfiniWeb\FixerAPI;

final class Symbols
{

	protected $endpointKey = 'symbols';

	protected $fixer;

	public function __construct(Fixer $fixer)
	{
		$this->fixer = $fixer;
	}

	public function get()
	{
		$response = $this->fixer->getResponse($this->endpointKey);

		if (!isset($response->symbols)) {
			throw new Exception("Error Processing Request", 1);
		}

		return $response->symbols;
	}

}
