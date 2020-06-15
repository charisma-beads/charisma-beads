<?php

namespace Twitter\Option;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwitterOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $config = $services->get('config');

        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }

        $config = $config['uthando_social_media']['twitter'];

        $options = new TwitterOptions($config);

        return $options;
    }
}