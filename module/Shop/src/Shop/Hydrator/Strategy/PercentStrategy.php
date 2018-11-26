<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Strategy
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;

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
