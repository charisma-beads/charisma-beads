<?php

namespace Shop\Hydrator\Strategy;

use Shop\Model\ProductCategoryCollection;
use Laminas\Serializer\Serializer;
use Laminas\Hydrator\Strategy\StrategyInterface;

/**
 * Class VoucherCategoriesStrategy
 *
 * @package Shop\Hydrator\Strategy
 */
class VoucherCategoriesStrategy implements StrategyInterface
{
    public function extract($value)
    {
        if ($value instanceof ProductCategoryCollection)  {
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

        $collection = new ProductCategoryCollection();
        $collection->fromArray($value);
        return $collection;
    }
}