<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Strategy
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Hydrator\Strategy;

use Shop\Model\PostUnitModel;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class PostUnitStrategy
 *
 * @package Shop\Hydrator\Strategy
 */
class PostUnitStrategy implements StrategyInterface
{
    /**
     * @param float $value
     * @return float
     */
    public function extract($value)
    {
        return $value;
    }

    /**
     * @param float|PostUnitModel $value
     * @return float
     */
    public function hydrate($value)
    {
        return ($value instanceof PostUnitModel) ? $value->getPostUnit() : $value;
    }
}
