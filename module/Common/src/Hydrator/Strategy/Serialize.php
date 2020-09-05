<?php

namespace Common\Hydrator\Strategy;

use Laminas\Serializer\Serializer;
use Laminas\Hydrator\Strategy\StrategyInterface;
use Zumba\JsonSerializer\Exception\JsonSerializerException;
use Zumba\JsonSerializer\JsonSerializer;


class Serialize implements StrategyInterface
{
    /**
     * @var JsonSerializer
     */
    protected $serializer;

    public function __construct()
    {
        $this->serializer = new JsonSerializer();
    }

    public function extract($value)
    {
        return $this->serializer->serialize($value);
    }

    public function hydrate($value)
    {
        if (!is_string($value)) {
            return $value;
        }

        try {
            $value = $this->serializer->unserialize($value);
        } catch (JsonSerializerException $e) {
            $value = Serializer::unserialize($value);
        }

        return $value;
    }
}
