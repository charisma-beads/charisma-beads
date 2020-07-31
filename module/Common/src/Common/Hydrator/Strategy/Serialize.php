<?php

namespace Common\Hydrator\Strategy;

use Laminas\Serializer\Serializer;
use Laminas\Hydrator\Strategy\StrategyInterface;


class Serialize implements StrategyInterface
{
    public function extract($value)
    {
        return Serializer::serialize($value);
    }

    public function hydrate($value)
    {
        if (!is_string($value)) {
            return $value;
        }
        
        return Serializer::unserialize($value);
    }
}
