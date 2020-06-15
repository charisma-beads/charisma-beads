<?php

declare(strict_types=1);


namespace Common\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;
use Zend\Stdlib\AbstractOptions;

class OptionsStrategy implements StrategyInterface
{
    public function extract($value)
    {
        if ($value instanceof AbstractOptions) {
            $value = $value->toArray();
        }

        return $value;
    }

    public function hydrate($value)
    {
        return $value;
    }
}
