<?php
namespace InfiniWeb\FixerAPI;

class Symbols extends Fixer
{

	protected $endpointKey = 'symbols';

	protected $symbols;

	public function __construct($accessKey)
	{
		parent::__construct($accessKey);
	}

	protected function loadSymbols()
	{
		
	}
}
