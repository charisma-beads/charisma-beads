<?php

namespace Testimonial;

use Common\Config\ConfigInterface;
use Common\Config\ConfigTrait;


class Module implements ConfigInterface
{
    use ConfigTrait;

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
