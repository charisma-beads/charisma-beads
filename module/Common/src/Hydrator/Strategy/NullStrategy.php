<?php

namespace Common\Hydrator\Strategy;

use Laminas\Hydrator\Strategy\StrategyInterface;


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
