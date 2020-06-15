<?php

namespace Common\Form\Element;

use Zend\Cache\Storage\Plugin\Serializer;
use Zend\Form\Element\Select;

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
