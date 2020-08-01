<?php

namespace Shop\Hydrator\Strategy;

use Laminas\Hydrator\Strategy\StrategyInterface;

/**
 * Class NumberFormat
 *
 * @package Shop\Hydrator\Strategy
 */
class NumberFormat implements StrategyInterface
{

    /**
     * @param float $value
     * @return float
     */
    public function extract($value)
    {
        return number_format($value, 2);
    }

    /**
     * @param float $value
     * @return float
     */
    public function hydrate($value)
    {
        return number_format($value, 2);
    }
}