<?php

namespace Shop\Hydrator\Strategy;

use Shop\Model\VoucherZoneCollection;
use Laminas\Serializer\Serializer;
use Laminas\Hydrator\Strategy\StrategyInterface;

class VoucherZonesStrategy implements StrategyInterface
{
    public function extract($value)
    {
        if ($value instanceof VoucherZoneCollection)  {
            $value = $value->toArray();
            $value = Serializer::serialize($value);
        }

        return $value;
    }

    public function hydrate($value)
    {
        if (is_string($value)) {
            $value = Serializer::unserialize($value);
        }

        $collection = new VoucherZoneCollection();
        $collection->fromArray($value);
        return $collection;
    }
}