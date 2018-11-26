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

use Shop\Model\ProductCategoryCollection;
use Zend\Serializer\Serializer;
use Zend\Hydrator\Strategy\StrategyInterface;

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