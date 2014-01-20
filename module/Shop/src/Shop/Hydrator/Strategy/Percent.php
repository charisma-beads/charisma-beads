<?php

namespace Shop\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class Percent implements StrategyInterface
{
	public function extract($value)
	{
		$value = $value / 100;
		
		return $value;
	}
	
	public function hydrate($value)
	{
		$wholePercent = $value * 100;
		
		return ($wholePercent < 100) ? $wholePercent : $value;
	}
}
