<?php

namespace Common\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;


class TrueFalse implements StrategyInterface
{
    /**
     * @param mixed $value
     * @return int
     */
    public function extract($value)
    {
        return ($value == true) ? 1 : 0;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function hydrate($value)
    {
        return ($value == 1) ? true : false;
    }
}
