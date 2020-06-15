<?php

namespace Common\Hydrator;

use Zend\Hydrator\HydratorInterface;


interface NestedSetInterface extends HydratorInterface
{
    /**
     * @return mixed
     */
    public function addDepth();
}
