<?php

namespace Common\Hydrator\Strategy;

use Laminas\Hydrator\Strategy\StrategyInterface;


class EmptyString implements StrategyInterface
{

    public function extract($value)
    {
        return $value;
    }

    public function hydrate($value)
    {
        return '';
    }
}
