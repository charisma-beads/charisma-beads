<?php

namespace Common\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;


class NullStrategy implements StrategyInterface
{
    public function extract($value)
    {
        return (0 == $value || '' == $value) ? null : $value;
    }

    public function hydrate($value)
    {
        return (0 == $value || '' == $value) ? null : $value;
    }
}
