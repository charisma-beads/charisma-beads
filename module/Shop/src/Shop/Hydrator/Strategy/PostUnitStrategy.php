<?php

namespace Shop\Hydrator\Strategy;

use Shop\Model\PostUnitModel;
use Laminas\Hydrator\Strategy\StrategyInterface;

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
