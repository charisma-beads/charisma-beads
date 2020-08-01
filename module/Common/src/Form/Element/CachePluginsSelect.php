<?php

namespace Common\Form\Element;

use Laminas\Cache\Storage\Plugin\Serializer;
use Laminas\Form\Element\Select;

class CachePluginsSelect extends Select
{
    public function init()
    {
        $options = [
            [
                'label' => Serializer::class,
                'value' => Serializer::class,
            ]
        ];

        $this->setValueOptions($options);
    }
}
