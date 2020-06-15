<?php

declare(strict_types=1);

namespace Common\Hydrator\Strategy;

use Common\Model\AbstractCollection;
use Common\Model\ModelInterface;
use Zend\Hydrator\Strategy\StrategyInterface;

class CollectionToArrayStrategy implements StrategyInterface
{
    public function extract($value)
    {
        $returnArray = [];
        if ($value instanceof AbstractCollection) {
            foreach ($value as $item) {
                if ($item instanceof ModelInterface) {
                    $returnArray[] = $item->getArrayCopy();
                }
            }
        }

        return $returnArray;
    }

    public function hydrate($value)
    {
        return $value;
    }
}
