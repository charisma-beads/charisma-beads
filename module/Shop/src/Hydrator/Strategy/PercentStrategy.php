<?php

namespace Shop\Hydrator\Strategy;

use Laminas\Hydrator\Strategy\StrategyInterface;

/**
 * Class Percent
 *
 * @package Shop\Hydrator\Strategy
 */
class PercentStrategy implements StrategyInterface
{
    /**
     * @param float $value
     * @return float
     */
	public function extract($value)
	{
		$value = $value / 100;
		
		return $value;
	}

    /**
     * @param float $value
     * @return float
     */
	public function hydrate($value)
	{
		$wholePercent = $value * 100;
		
		return ($wholePercent < 100) ? $wholePercent : $value;
	}
}
