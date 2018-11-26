<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Hydrator\Strategy;

use Shop\Model\VoucherZoneCollection;
use Zend\Serializer\Serializer;
use Zend\Hydrator\Strategy\StrategyInterface;

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