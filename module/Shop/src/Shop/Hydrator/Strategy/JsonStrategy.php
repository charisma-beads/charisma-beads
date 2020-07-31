<?php

declare(strict_types=1);


namespace Shop\Hydrator\Strategy;


use Laminas\Hydrator\Strategy\StrategyInterface;
use Laminas\Json\Json;

class JsonStrategy implements StrategyInterface
{

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param mixed $value The original value.
     * @return mixed Returns the value that should be extracted.
     */
    public function extract($value)
    {
        return Json::encode($value);
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param mixed $value The original value.
     * @return mixed Returns the value that should be hydrated.
     */
    public function hydrate($value)
    {
        return Json::decode($value);
    }
}