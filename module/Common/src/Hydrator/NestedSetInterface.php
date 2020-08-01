<?php

namespace Common\Hydrator;

use Laminas\Hydrator\HydratorInterface;


interface NestedSetInterface extends HydratorInterface
{
    /**
     * @return mixed
     */
    public function addDepth();
}
