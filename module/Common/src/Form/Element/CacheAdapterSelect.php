<?php

namespace Common\Form\Element;

use Common\Options\CacheOptions;
use Laminas\Form\Element\Select;

class CacheAdapterSelect extends Select
{
    public function init()
    {
        $registeredAdapters = array_keys(CacheOptions::$adapterOptionsMap);

        $options = [];

        foreach ($registeredAdapters as $adapter) {
            $options[] = [
                'label' => $adapter,
                'value' => $adapter,
            ];
        }

        $this->setValueOptions($options);
    }
}
