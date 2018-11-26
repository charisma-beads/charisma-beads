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
 * Class NumberFormat
 *
 * @package Shop\Hydrator\Strategy
 */
class NumberFormatStrategy implements StrategyInterface
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